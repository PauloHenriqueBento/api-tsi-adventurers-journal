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
    /**
     * @OA\Get(
     *     path="/user",
     *     tags={"Users"},
     *     summary="Get all users",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/UserSchema")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    //Cadastra novo usuario
    //Obs.: Ao usar Postman ou outra plataforma de testar api. Configurar o header
    //Accept: application/json
    //Content-Type: application/json



    /**
     * @OA\Post(
     *     path="/user",
     *     tags={"Users"},
     *     summary="Create a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserRequestBody")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", ref="#/components/schemas/UserSchema"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     )
     * )
     */
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
            'user' => new UserResource($user, 'teste'),
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

    /**
     * @OA\Get(
     *     path="/user",
     *     tags={"Users"},
     *     summary="Get the authenticated user",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/UserSchema")
     *     )
     * )
     */
    public function show()
    {
        $user = Auth::user();
        $this->authorize('view', $user);
        $user->base64 = true;
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
    /**
     * @OA\Put(
     *     path="/user",
     *     tags={"Users"},
     *     summary="Update the authenticated user",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserRequestBody")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/UserSchema")
     *     )
     * )
     */
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
