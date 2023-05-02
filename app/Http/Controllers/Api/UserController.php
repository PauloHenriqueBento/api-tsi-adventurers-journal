<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    //retorna todos usuarios (Debug)
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    //Cadastra novo usuario
    //Obs.: Ao usar Postman ou outra plataforma de testar api. Configurar o header
    //Accept: application/json
    //Content-Type: application/json
    public function store(StoreUpdateUserRequest $request)
    {
        // Pega apenas os dados validados no StoreUpdateUserRequest
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);

        $data['profile_photo_path'] = $request->profile_photo_path ? $this->storeImage($request->profile_photo_path, 'profile_photos') : null;
        $data['profile_banner_path'] = $request->profile_banner_path ? $this->storeImage($request->profile_banner_path, 'profile_banner') : null;

        $user = User::create($data);
        return new UserResource($user);
    }

    public function storeImage($image, $path)
    {
        $filename = uniqid() . '.' . $image->getClientOriginalExtension();
        Storage::putFileAs($path, $image, $filename);
        return $filename;
    }

    //Retorna apenas um user
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return new UserResource($user);
        } catch (ModelNotFoundException $e) {
            return response([
                'Status' => 'Error',
                'error' => '404'
            ], 404);
        }
    }

    //Atualiza user
    public function update(StoreUpdateUserRequest $request, string $id)
    {
        // dd($request->all());
        $user = User::findOrFail($id);

        $data = $request->all();

        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return new UserResource($user);
    }

    //Deletar
    public function destroy(string $id)
    {
        $user = User::findOrFail($id)->delete();

        return response()->json([], 204);
    }
}