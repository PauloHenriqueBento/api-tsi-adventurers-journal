<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login The User
     * @param Request $request
     * @return User
     */

    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Autenticar usuário",
     *     operationId="loginUser",
     *     tags={"Autenticação"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *                 @OA\Property(property="password", type="string", example="password123")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Sucesso"),
     *     @OA\Response(response="401", description="Erro de validação ou credenciais inválidas"),
     *     @OA\Response(response="500", description="Erro interno do servidor")
     * )
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Erro de validação',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'E-mail e senha não correspondem ao nosso registro.'
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            return response()->json([
                'status' => true,
                'message' => 'Usuario logado com sucesso',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * @OA\Post(
 *     path="/logout",
 *     summary="Desconectar usuário",
 *     operationId="logout",
 *     tags={"Autenticação"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(response="200", description="Sucesso"),
 *     @OA\Response(response="401", description="Não autorizado")
 * )
 */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout realizado com sucesso!']);
    }
}
