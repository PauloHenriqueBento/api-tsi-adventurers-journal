<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $users->each(function ($user) {
            $user->profile_photo_path = $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : null;
            $user->profile_banner_path = $user->profile_banner_path ? asset('storage/' . $user->profile_banner_path) : null;
        });
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
        // Verificar se o usuário está criando um Guia
        $isGuia = $request->input('isGuia') === true;

        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $data['isGuia'] = $isGuia;

        // Criar o usuário
        $user = User::create($data);
        $user->modalidades()->attach($request->input('modalidades'));

        if ($request->hasFile('profile_photo_path')) {
            $profilePhoto = $request->file('profile_photo_path');
            $profilePhotoPath = $profilePhoto->storePublicly('profile_photos', 'public');
            $user->profile_photo_path = $profilePhotoPath;
            $user->save();
        }

        // Salvar banner do perfil, se fornecido
        if ($request->hasFile('profile_banner_path')) {
            $profileBanner = $request->file('profile_banner_path');
            $profileBannerPath = $profileBanner->storePublicly('banner_photos', 'public');
            $user->profile_banner_path = $profileBannerPath;
            $user->save();
        }
        /* $data['profile_photo_path'] = $request->profile_photo_path ? $this->storeImage($request->profile_photo_path, 'profile_photos') : null;
        $data['profile_banner_path'] = $request->profile_banner_path ? $this->storeImage($request->profile_banner_path, 'profile_banner') : null;*/


        $token = $user->createToken('api_token')->plainTextToken;
        return [
            'user' => new UserResource($user, 'teste'),
            'token' => $token,
        ];
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
    public function show($id = '')
    {
        $user = '';
        if (!$id) {
            $user = Auth::user();
            $this->authorize('view', $user);
        } else {
            $user = User::find($id);
            if (!$user)
                return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        $user->profile_photo_path = $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : null;
        $user->profile_banner_path = $user->profile_banner_path ? asset('storage/' . $user->profile_banner_path) : null;

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
    public function update(UpdateUserRequest $request)
    {
        $user = $request->user(); // pega o usuário autenticado
        $data = $request->all();

        if ($request->has('confirmPassword')) {
            $user_password = $user->password();
            $user_confirm_password = $request->confirmPassword;
            if (!Hash::check($user_confirm_password, $user_password)) {
                return response()->json([
                    'error' => 'Senha incorreta',
                ], 401);
            }
        }

        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Verifica se uma nova imagem de perfil foi enviada
        if ($request->hasFile('profile_photo_path')) {
            // Obtém o arquivo enviado
            $profilePhoto = $request->file('profile_photo_path');

            // Salva a nova imagem de perfil no diretório de armazenamento
            $filename = $profilePhoto->storePublicly('profile_photos', 'public');

            // Remove a imagem antiga, se existir
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Atualiza o caminho da nova imagem de perfil no modelo do usuário
            $data['profile_photo_path'] = $filename;
        }

        if ($request->hasFile('profile_banner_path')) {
            // Obtém o arquivo enviado
            $profileBanner = $request->file('profile_banner_path');

            // Salva a nova imagem de perfil no diretório de armazenamento
            $filename = $profileBanner->storePublicly('profile_banner', 'public');

            // Remove a imagem antiga, se existir
            if ($user->profile_banner_path) {
                Storage::disk('public')->delete($user->profile_banner_path);
            }

            // Atualiza o caminho da nova imagem de perfil no modelo do usuário
            $data['profile_banner_path'] = $filename;
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
