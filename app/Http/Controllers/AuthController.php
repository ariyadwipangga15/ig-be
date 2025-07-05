<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use JWTAuth;
use App\Models\User;
use App\Models\Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $authModel;
    public function __construct()
    {
        $this->authModel = new Auth();
    }
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            // 'email' => 'required|email',
            'username' => 'required',
            'password' => 'required|string|min:6|max:50',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Create token
        try {
            JWTAuth::factory()->setTTL(60 * 24); // 24 jam
            $token = JWTAuth::attempt($credentials);
            if (!$token) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Login credentials are invalid.',
                    ],
                    400
                );
            }
        } catch (JWTException $e) {
            return $credentials;
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Could not create token.',
                ],
                500
            );
        }

        //Token created, return with success response and jwt token
        $user = $this->authModel->getUserLogin($request->username);
        for ($i = 0; $i < sizeof($user); $i++) {
            $row = $user[$i];
            $roleData = $this->authModel->getRole($row->role);
            $user[$i]->role = $roleData[0];
        }
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user[0],
        ]);
    }

    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated, do logout
        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out',
            ]);
        } catch (JWTException $exception) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Sorry, user cannot be logged out',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
        ]);

        $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }

    public function ubahPassword(Request $request)
    {
        $user = $this->authModel->getUserLogin($request->username);
        if ($user != null) {
            if (Hash::check($request->password, $user[0]->password)) {
                $auth = Auth::find($user[0]->id);
                $password = Hash::make($request->password_baru);

                DB::beginTransaction();
                $auth->update([
                    'password' => $password,
                    'updated_at' => Carbon::now(),
                ]);
                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Password Berhasil Diubah',
                    'user' => $auth,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Password lama tidak sama.',
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.',
            ]);
        }
    }
}
