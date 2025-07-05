<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    protected $roleModel;
    public function __construct()
    {
        $this->roleModel = new Role();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getAll()
    {
        $data =  $this->roleModel->getAll();
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
            $limit = $request->get('limit');
            $sortBy = $request->get('sortBy');
            $sortType = $request->get('sortType');
            $q = $request->get('q') != '' ? $request->get('q') : '';
            $q = str_replace(' ', '%', $q);
            $columnMap = $this->roleModel->columnMap();

            $filter = [
                'q' => $q,
                'page' => $page,
                'limit' => $limit,
                'sortBy' => isset($columnMap[$sortBy])
                    ? $columnMap[$sortBy]
                    : 'nama',
                'sortType' => $sortType != '' ? $sortType : 'desc',
            ];

            $totalData = $this->roleModel->getCountRole($filter);
            $data = $this->roleModel->getListRole($filter);

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
    public function getAllRoleId($id)
    {
        $data = $this->roleModel->getAllRoleId($id);
        $response = [
            'success' => true,
            'data' => $data,
        ];
        return response()->json($response, 200, [], JSON_UNESCAPED_SLASHES);
    }
    public function CreateRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Silahkan isi role yang Kosong',
                    'data' => $validator->errors(),
                ],
            );
        }

        if (
            Role::whereRaw('LOWER(nama) = (?)', [strtolower($request->nama)])
                ->where('status', '=', '1')
                ->exists()
        ) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Nama Role sudah ada',
                ],
            );
        } elseif (
            Role::whereRaw('LOWER(keterangan) = (?)', [strtolower($request->keterangan)])
                ->where('status', '=', '1')
                ->exists()
        ) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Keterangan sudah ada',
                ],
            );
        } else {
            try {
                DB::beginTransaction();
                $role = Role::create([
                    'id' => Str::uuid(36),
                    'nama' => $request->nama,
                    'keterangan' => $request->keterangan,
                    'is_view_data_all' => $request->is_view_data_all,
                    'is_choose_pegawai' => $request->is_choose_pegawai,
                    'is_choose_terbatas' => $request->is_choose_terbatas,
                    'status' => 1
                ]);

                DB::commit();
                $response = [
                    'success' => true,
                    'message' => 'Data berhasil disimpan !',
                    'data' => $role,
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
    public function UpdateRole(Request $request, $id)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Silahkan isi Role yang Kosong',
                    'data' => $validator->errors(),
                ],

            );
        }

        try {
            $role = Role::find($id);
            if (is_null($role)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan !',
                ]);
            }

            if (
                Role::whereRaw('LOWER(nama) = (?)', [
                    strtolower($request->nama),
                ])
                    ->whereRaw('LOWER(keterangan) = (?)', [
                        strtolower($request->keterangan),
                    ])
                    ->where('status', '=', '1')
                    ->where('id', '=', $role['id'])
                    ->exists()
            ) {
                DB::beginTransaction();
                $role->update([
                    'nama' => $request->nama,
                    'keterangan' => $request->keterangan,
                    'is_view_data_all' => $request->is_view_data_all,
                    'is_choose_pegawai' => $request->is_choose_pegawai,
                    'is_choose_terbatas' => $request->is_choose_terbatas
                ]);

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil diubah !',
                    'data' => $role,
                ]);
            } else {
                if (
                    Role::whereRaw('LOWER(nama) = (?)', [
                        strtolower($request->nama),
                    ])
                        ->where('status', '=', '1')
                        ->where('id', '=', $role['id'])
                        ->exists()
                ) {
                    if (
                        Role::whereRaw('LOWER(keterangan) = (?)', [
                            strtolower($request->keterangan),
                        ])
                            ->where('status', '=', '1')
                            ->where('id', '=', $role['id'])
                            ->exists()
                    ) {
                        DB::beginTransaction();
                        $role->update([
                            'nama' => $request->nama,
                            'keterangan' => $request->keterangan,
                            'is_view_data_all' => $request->is_view_data_all,
                            'is_choose_pegawai' => $request->is_choose_pegawai,
                            'is_choose_terbatas' => $request->is_choose_terbatas
                        ]);

                        DB::commit();
                        return response()->json([
                            'success' => true,
                            'message' => 'Data berhasil diubah !',
                            'data' => $role,
                        ]);
                    } else {
                        if (
                            Role::whereRaw('LOWER(keterangan) = (?)', [
                                strtolower($request->keterangan),
                            ])
                                ->where('status', '=', '1')
                                ->exists()
                        ) {
                            return response()->json(
                                [
                                    'success' => false,
                                    'message' => 'Keterangan sudah ada',
                                ],

                            );
                        } else {
                            DB::beginTransaction();
                            $role->update([
                                'nama' => $request->nama,
                                'keterangan' => $request->keterangan,
                                'is_view_data_all' => $request->is_view_data_all,
                                'is_choose_pegawai' => $request->is_choose_pegawai,
                                'is_choose_terbatas' => $request->is_choose_terbatas
                            ]);

                            DB::commit();
                            return response()->json([
                                'success' => true,
                                'message' => 'Data berhasil diubah !',
                                'data' => $role,
                            ]);
                        }
                    }
                } else {
                    if (
                        Role::whereRaw('LOWER(nama) = (?)', [
                            strtolower($request->nama),
                        ])
                            ->where('status', '=','1')
                            ->exists()
                    ) {
                        return response()->json(
                            [
                                'success' => false,
                                'message' => 'Nama sudah ada',
                            ],

                        );
                    } else {
                        if (
                            Role::whereRaw('LOWER(keterangan) = (?)', [
                                strtolower($request->keterangan),
                            ])
                                ->where('status', '=', '1')
                                ->where('id', '=', $role['id'])
                                ->exists()
                        ) {
                            DB::beginTransaction();
                            $role->update([
                                'nama' => $request->nama,
                                'keterangan' => $request->keterangan,
                                'is_view_data_all' => $request->is_view_data_all,
                                'is_choose_pegawai' => $request->is_choose_pegawai,
                                'is_choose_terbatas' => $request->is_choose_terbatas
                            ]);

                            DB::commit();
                            return response()->json([
                                'success' => true,
                                'message' => 'Data berhasil diubah !',
                                'data' => $role,
                            ]);
                        } else {
                            if (
                                Role::whereRaw('LOWER(keterangan) = (?)', [
                                    strtolower($request->keterangan),
                                ])
                                    ->where('status', '=', '1')
                                    ->exists()
                            ) {
                                return response()->json(
                                    [
                                        'success' => false,
                                        'message' => 'Keterangan sudah ada',
                                    ],

                                );
                            } else {
                                DB::beginTransaction();
                                $role->update([
                                    'nama' => $request->nama,
                                    'keterangan' => $request->keterangan,
                                    'is_view_data_all' => $request->is_view_data_all,
                                    'is_choose_pegawai' => $request->is_choose_pegawai,
                                    'is_choose_terbatas' => $request->is_choose_terbatas
                                ]);

                                DB::commit();
                                return response()->json([
                                    'success' => true,
                                    'message' => 'Data berhasil diubah !',
                                    'data' => $role,
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
    public function DeleteRole($id)
    {
        try {
            // Soft Delete
            $role = Role::find($id);
            if (is_null($role)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan !',
                ]);
            }

            DB::beginTransaction();
            $role->update([
                'status' => '0'
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

}
