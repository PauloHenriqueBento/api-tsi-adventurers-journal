<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);

        $data['profile_photo_path'] = $request->profile_photo_path ? $this->storeImage($request->profile_photo_path, 'profile_photos') : null;
        $data['profile_banner_path'] = $request->profile_banner_path ? $this->storeImage($request->profile_banner_path, 'profile_banner') : null;
        $user = User::create($data);
        $user->modalidades()->attach($request->input('modalidades'));

        $token = $user->createToken('api_token')->plainTextToken;
        return [
            'user' => new UserResource($user),
            'token' => $token,
        ];
    }

    public function storeImage($image, $path)
    {
        $folderPath = "/{$path}/"; //path location
        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $extension = $image_type_aux[1];
        $decodedImage = base64_decode($image_parts[1]);
        $filename = uniqid() . '.' . $extension;
        Storage::put($folderPath . $filename, $decodedImage);
        return $filename;
    }

    //Retorna apenas um user
    public function show()
    {
        $user = Auth::user();
        $this->authorize('view', $user);
        return new UserResource($user);
        // try {
        //     $user = User::findOrFail($id);
        //     $this->authorize('view', $user);
        //     return new UserResource($user);
        // } catch (ModelNotFoundException $e) {
        //     return response([
        //         'Status' => 'Error',
        //         'error' => '404'
        //     ], 404);
        // } catch (AuthorizationException $e) {
        //     return response([
        //         'Status' => 'Error',
        //         'error' => 'Usuário não autorizado'
        //     ], 403);
        // }
    }

    //Atualiza user
    public function update(StoreUpdateUserRequest $request)
    {
        $user = $request->user(); // pega o usuário autenticado

        $data = $request->all();

        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        if ($request->has('modalidades')) {
            $user->modalidades()->sync($request->modalidades);
        }

        return new UserResource($user);
    }

    //Deletar
    public function destroy(string $id)
    {
        $user = User::findOrFail($id)->delete();

        return response()->json([], 204);
    }
}
