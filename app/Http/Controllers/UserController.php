<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $data =  $this->userModel->getAll();
        $response = [
            'success' => true,
            'data' => $data,
        ];
        return response()->json($response, 200, [], JSON_UNESCAPED_SLASHES);
    }
    public function ResolveAll(Request $request)
    {
        try {
            $page = $request->get('page');
            $role = $request->get('role');
            $limit = $request->get('limit');
            $sortBy = $request->get('sortBy');
            $sortType = $request->get('sortType');
            $q = $request->get('q') != '' ? $request->get('q') : '';
            $q = str_replace(' ', '%', $q);
            $columnMap = $this->userModel->columnMap();

            $filter = [
                'q' => $q,
                'page' => $page,
                'role' => $role,
                'limit' => $limit,
                'sortBy' => isset($columnMap[$sortBy])
                    ? $columnMap[$sortBy]
                    : 'created_at',
                'sortType' => $sortType != '' ? $sortType : 'asc',
            ];

            $totalData = $this->userModel->getCountUser($filter);
            $data = $this->userModel->getListUser($filter);

            $response = [
                'success' => true,
                'data' => $data,
                'meta' => [
                    'page' => $page,
                    'pageSize' => $limit,
                    'total' => $totalData,
                ],
            ];
            return response()->json($response, 200, [], JSON_UNESCAPED_SLASHES);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errorInfo,
            ]);
        }
    }
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAllUserId($id)
    {
        $data = $this->userModel->getAllUserId($id);
        $response = [
            'success' => true,
            'data' => $data,
        ];
        return response()->json($response, 200, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function CreateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama" => ['required'],
            "username" => ['required'],
            "email" => ['required'],
            "password" => ['required'],
            "role" => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Silahkan isi user yang Kosong',
                    'data' => $validator->errors(),
                ],
            );
        }

        if (
            User::whereRaw('LOWER(username) = (?)', [strtolower($request->username)])
                ->where('is_deleted', '=', false)
                ->exists()
        ) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Username sudah ada',
                ],
            );
        } elseif (
            User::whereRaw('LOWER(email) = (?)', [strtolower($request->email)])
                ->where('status', '=', '1')
                ->exists()
        ) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'email sudah ada',
                ],
            );
        } else {
            try {
                DB::beginTransaction();
                $user = User::create([
                    'id' => Str::uuid(36),
                    'nama' => $request->nama,
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                    'id_gudang' => $request->id_gudang,
                    'status' => true,
                    'is_deleted' => false,
                ]);

                DB::commit();
                $response = [
                    'success' => true,
                    'message' => 'Data berhasil disimpan !',
                    'data' => $user,
                ];

                return response()->json($response, 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => $e->errorInfo,
                ]);
            }
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function UpdateUser(Request $request, $id)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            "nama" => ['required'],
            "username" => ['required'],
            "email" => ['required'],
            "role" => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Silahkan isi User yang Kosong',
                    'data' => $validator->errors(),
                ],

            );
        }

        try {
            $user = User::find($id);
            if (is_null($user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan !',
                ]);
            }

            if (
                User::whereRaw('LOWER(username) = (?)', [
                    strtolower($request->username),
                ])
                    ->whereRaw('LOWER(email) = (?)', [
                        strtolower($request->email),
                    ])
                    ->where('is_deleted', '=', false)
                    ->where('id', '=', $user['id'])
                    ->exists()
            ) {
                DB::beginTransaction();
                $user->update([
                    'nama' => $request->nama,
                    'username' => $request->username,
                    'email' => $request->email,
                    'role' => $request->role,
                    'id_gudang' => $request->id_gudang,
                ]);

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil diubah !',
                    'data' => $user,
                ]);
            } else {
                if (
                    User::whereRaw('LOWER(username) = (?)', [
                        strtolower($request->username),
                    ])
                        ->where('is_deleted', '=', false)
                        ->where('id', '=', $user['id'])
                        ->exists()
                ) {
                    if (
                        User::whereRaw('LOWER(email) = (?)', [
                            strtolower($request->email),
                        ])
                            ->where('is_deleted', '=', false)
                            ->where('id', '=', $user['id'])
                            ->exists()
                    ) {
                        DB::beginTransaction();
                        $user->update([
                            'nama' => $request->nama,
                            'username' => $request->username,
                            'email' => $request->email,
                            'role' => $request->role,
                        ]);

                        DB::commit();
                        return response()->json([
                            'success' => true,
                            'message' => 'Data berhasil diubah !',
                            'data' => $user,
                        ]);
                    } else {
                        if (
                            User::whereRaw('LOWER(email) = (?)', [
                                strtolower($request->email),
                            ])
                                ->where('is_deleted', '=', false)
                                ->exists()
                        ) {
                            return response()->json(
                                [
                                    'success' => false,
                                    'message' => 'Email sudah ada',
                                ],

                            );
                        } else {
                            DB::beginTransaction();
                            $user->update([
                                'nama' => $request->nama,
                                'username' => $request->username,
                                'email' => $request->email,
                                'role' => $request->role,
                            ]);

                            DB::commit();
                            return response()->json([
                                'success' => true,
                                'message' => 'Data berhasil diubah !',
                                'data' => $user,
                            ]);
                        }
                    }
                } else {
                    if (
                        User::whereRaw('LOWER(username) = (?)', [
                            strtolower($request->username),
                        ])
                            ->where('is_deleted', '=', false)
                            ->exists()
                    ) {
                        return response()->json(
                            [
                                'success' => false,
                                'message' => 'Username sudah ada',
                            ],

                        );
                    } else {
                        if (
                            User::whereRaw('LOWER(email) = (?)', [
                                strtolower($request->email),
                            ])
                                ->where('is_deleted', '=', false)
                                ->where('id', '=', $user['id'])
                                ->exists()
                        ) {
                            DB::beginTransaction();
                            $user->update([
                                'nama' => $request->nama,
                                'username' => $request->username,
                                'email' => $request->email,
                                'role' => $request->role,
                            ]);

                            DB::commit();
                            return response()->json([
                                'success' => true,
                                'message' => 'Data berhasil diubah !',
                                'data' => $user,
                            ]);
                        } else {
                            if (
                                User::whereRaw('LOWER(email) = (?)', [
                                    strtolower($request->email),
                                ])
                                    ->where('is_deleted', '=', false)
                                    ->exists()
                            ) {
                                return response()->json(
                                    [
                                        'success' => false,
                                        'message' => 'Email sudah ada',
                                    ],

                                );
                            } else {
                                DB::beginTransaction();
                                $user->update([
                                    'nama' => $request->nama,
                                    'username' => $request->username,
                                    'email' => $request->email,
                                    'role' => $request->role,
                                ]);

                                DB::commit();
                                return response()->json([
                                    'success' => true,
                                    'message' => 'Data berhasil diubah !',
                                    'data' => $user,
                                ]);
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->errorInfo,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteUser($id)
    {
        try {
            // Soft Delete
            $user = User::find($id);
            if (is_null($user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan !',
                ]);
            }

            DB::beginTransaction();
            $user->update([
                'is_deleted' => true
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus !',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->errorInfo,
            ]);
        }
    }
    public function ResetPassword(Request $request, $id)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'newPassword' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi data yang Kosong',
                'data'    => $validator->errors()
            ], 401);
        }

        try {
            $user = User::find($id);
            if (is_null($user)) {
                return response()->json([
                    "success" => false,
                    "message" => "Data tidak ditemukan !",
                ]);
            }

            DB::beginTransaction();
            $user->update([
                'password' => Hash::make($request->newPassword),
            ]);

            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Data berhasil diubah !",
                "data" => $user,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->errorInfo,
            ]);
        }
    }
}
