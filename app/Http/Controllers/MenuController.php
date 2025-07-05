<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\MenuUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    protected $menuModel;
    protected $menuUserModel;
    public function __construct()
    {
        $this->menuModel = new Menu();
        $this->menuUserModel = new MenuUser();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // Start Menu Transaksi Akses
    public function index(Request $request)
    {
        $idRole = $request->get('idRole');
        $app = $request->get('app');
        $Posisi = $request->get('posisi');
        $posisiSubMenu = $request->get('posisiSubMenu');
        $level = '1';
        $linkParent = $request->get('linkParent');

        // Filter Data
        $filter = array(
            'idRole' => $idRole,
            'app' => $app,
            'posisi' => ($Posisi != "") ? $Posisi : '1',
            'level' => $level,
            'posisiSubMenu' => $posisiSubMenu,
            'linkParent' => $linkParent,
        );

        $data = $this->menuModel->ResolveMenuByRoleID($filter);
        for ($i=0; $i < sizeof($data) ; $i++) {
            $row = $data[$i];
            $subMenu= $this->menuModel->ResolveMenuByParentID($filter,$row->id_menu);
            $data[$i]->children = $subMenu;
     }
        $response = [
            'success' => true,
            'data' => $data,
        ];
        return response()->json($response, 200, [], JSON_UNESCAPED_SLASHES);
    }
    public function permission(Request $request)
    {
        $idRole = $request->get('idRole');
        $app = $request->get('app');
        $Posisi = $request->get('posisi');
        $posisiSubMenu = $request->get('posisiSubMenu');
        $level = $request->get('level');;
        $linkParent = $request->get('linkParent');

        // Filter Data
        $filter = array(
            'idRole' => $idRole,
            'app' => $app,
            'posisi' =>$Posisi,
            'level' => $level,
            'posisiSubMenu' => $posisiSubMenu,
            'linkParent' => $linkParent,
        );

        $data = $this->menuModel->ResolveMenuByRoleID($filter);
        $response = [
            'success' => true,
            'data' => $data,
        ];
        return response()->json($response, 200, [], JSON_UNESCAPED_SLASHES);
    }
    public function CreateMenuUser(Request $request)
    {
    try {
        $filter = array(
            'posisi' => $request->posisi,
            'level' => $request->level,
            'id_role' => $request->idRole,
            'parent' => $request->parent,
        );
        $cekLevel=$request->level;
            $menuSelect=$request->idMenu;
            $parent_save = "";
            if($cekLevel !="" && $cekLevel != 1 ){
              $parent_save = $request->parent;
            }
            DB::beginTransaction();
        for ($i=0; $i < sizeof($menuSelect) ; $i++) {
                $idMenu = $menuSelect[$i];
               $cekMenuUser = $this->menuUserModel->cekMenuUser($filter,$idMenu);
               if($cekMenuUser==0){
                   $cekMenuUrutan = $this->menuUserModel->cekMenuUrutan($filter);
                   $menuUser = MenuUser::create([
                       'id' =>  Str::uuid(),
                       'id_menu' => $idMenu,
                       'posisi' => $request->posisi,
                       'level' => $request->level,
                       'parent' => $parent_save,
                       'id_role' => $request->idRole,
                       'status' => 1,
                       'urutan' => $cekMenuUrutan,
                       'created_at' => Carbon::now(),
                    ]);
                }
        }

            DB::commit();
            $response = [
                'success' => true,
                'message' => 'Data berhasil disimpan !',
                'data' => $cekMenuUser,
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
    public function UpMenu(Request $request, $id)
    {
        try {
            $menuUser = MenuUser::find($id);
            if (is_null($menuUser)) {
                return response()->json([
                    "success" => false,
                    "message" => "Data tidak ditemukan !",
                ]);
            }
            $cekMenUp = $this->menuUserModel->cekMenuUp($id);
            $filter = array(
                'id_menu_dipilih' => $cekMenUp->id_menu,
                'posisi_dipilih' => $cekMenUp->posisi,
                'level_dipilih' => $cekMenUp->level,
                'urutan_dipilih' => $cekMenUp->urutan,
                'parent_dipilih' => $cekMenUp->parent,
                'id_role_dipilih' => $cekMenUp->id_role,
                'urutan_sebelumnya' => $cekMenUp->urutan-1,
            );
            $urutan_sebelumnya = $cekMenUp->urutan-1;

            DB::beginTransaction();
            $MenUp = $this->menuUserModel->upMenu($filter);
            // proses
            MenuUser::where('id', $id)->update( array('urutan'=>$urutan_sebelumnya) );

            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Data berhasil diubah !",
                "data" => $MenUp,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->errorInfo,
            ]);
        }
    }
    public function DownMenu(Request $request, $id)
    {
        try {
            $menuUser = MenuUser::find($id);
            if (is_null($menuUser)) {
                return response()->json([
                    "success" => false,
                    "message" => "Data tidak ditemukan !",
                ]);
            }
            $cekMenUp = $this->menuUserModel->cekMenuUp($id);
            $filter = array(
                'id_menu_dipilih' => $cekMenUp->id_menu,
                'posisi_dipilih' => $cekMenUp->posisi,
                'level_dipilih' => $cekMenUp->level,
                'urutan_dipilih' => $cekMenUp->urutan,
                'parent_dipilih' => $cekMenUp->parent,
                'id_role_dipilih' => $cekMenUp->id_role,
                'urutan_selanjutnya' => $cekMenUp->urutan+1,
            );
            $urutan_selanjutnya = $cekMenUp->urutan+1;

            DB::beginTransaction();
            $MenDown = $this->menuUserModel->downMenu($filter);
            // proses
            MenuUser::where('id', $id)->update( array('urutan'=>$urutan_selanjutnya) );

            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Data berhasil diubah !",
                "data" => $MenDown,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->errorInfo,
            ]);
        }
    }
    public function HapusMenuUser($id)
    {
        try {
            // Soft Delete
            $menuUser = MenuUser::find($id);
            if (is_null($menuUser)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan !',
                ]);
            }

            DB::beginTransaction();
            $menuUser->update([
                'is_deleted' => 'true',
                'status' => '0',
                'updated_at' => Carbon::now(),
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

    // Start Master
    public function ResolveAll(Request $request)
    {
        try {
            $app = $request->get('app');
            $page = $request->get('page');
            $limit = $request->get('limit');
            $sortBy = $request->get('sortBy');
            $sortType = $request->get('sortType');
            $q = $request->get('q') != '' ? $request->get('q') : '';
            $q = str_replace(' ', '%', $q);
            $columnMap = $this->menuModel->columnMap();

            $filter = [
                'q' => $q,
                'page' => $page,
                'app' => $app,
                'limit' => $limit,
                'sortBy' => isset($columnMap[$sortBy])
                    ? $columnMap[$sortBy]
                    : 'created_at',
                'sortType' => $sortType != '' ? $sortType : 'desc',
            ];

            $totalData = $this->menuModel->getCountMenu($filter);
            $data = $this->menuModel->getListMenu($filter);

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
    public function getAllMenu(Request $request)
    {
        $app = $request->get('app');
        $filter = [
            'app' => $app,
        ];
        $data = $this->menuModel->getAllMenu($filter);
        $response = [
            'success' => true,
            'data' => $data,
        ];
        return response()->json($response, 200, [], JSON_UNESCAPED_SLASHES);
    }
    public function getAllMenuId(Request $request)
    {
        $id = $request->get('id');
        $data = $this->menuModel->getAllMenuId($id);
        $response = [
            'success' => true,
            'data' => $data,
        ];
        return response()->json($response, 200, [], JSON_UNESCAPED_SLASHES);
    }
    public function CreateMenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_menu' => ['required'],
            'link_menu' => ['required'],
            'app' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Silahkan isi menu yang Kosong',
                    'data' => $validator->errors(),
                ],
            );
        }

        if (
            Menu::whereRaw('LOWER(nama_menu) = (?)', [strtolower($request->nama_menu)])
                ->where('is_deleted', '=', false)
                ->exists()
        ) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Nama Menu sudah ada',
                ],
            );
        } elseif (
            Menu::whereRaw('LOWER(link_menu) = (?)', [strtolower($request->link_menu)])
                ->where('is_deleted', '=', false)
                ->exists()
        ) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Link Menu sudah ada',
                ],
            );
        } else {
            try {
                DB::beginTransaction();
                $menu = Menu::create([
                    'id' => Str::uuid(36),
                    'nama_menu' => $request->nama_menu,
                    'link_menu' => $request->link_menu,
                    'keterangan' => $request->keterangan,
                    'class_icon' => $request->class_icon,
                    'app' => $request->app,
                    'status' => 1,
                    'is_deleted' => false,
                    'created_at' => Carbon::now(),
                ]);

                DB::commit();
                $response = [
                    'success' => true,
                    'message' => 'Data berhasil disimpan !',
                    'data' => $menu,
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
    public function UpdateMenu(Request $request, $id)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'nama_menu' => ['required'],
            'link_menu' => ['required'],
            'app' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Silahkan isi menu yang Kosong',
                    'data' => $validator->errors(),
                ],

            );
        }

        try {
            $menu = Menu::find($id);
            if (is_null($menu)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan !',
                ]);
            }

            if (
                Menu::whereRaw('LOWER(nama_menu) = (?)', [
                    strtolower($request->nama_menu),
                ])
                    ->whereRaw('LOWER(link_menu) = (?)', [
                        strtolower($request->link_menu),
                    ])
                    ->where('is_deleted', '=', false)
                    ->where('id', '=', $menu['id'])
                    ->exists()
            ) {
                DB::beginTransaction();
                $menu->update([
                    'nama_menu' => $request->nama_menu,
                    'link_menu' => $request->link_menu,
                    'keterangan' => $request->keterangan,
                    'class_icon' => $request->class_icon,
                    'app' => $request->app,
                    'updated_at' => Carbon::now(),
                ]);

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil diubah !',
                    'data' => $menu,
                ]);
            } else {
                if (
                    Menu::whereRaw('LOWER(nama_menu) = (?)', [
                        strtolower($request->nama_menu),
                    ])
                        ->where('is_deleted', '=', false)
                        ->where('id', '=', $menu['id'])
                        ->exists()
                ) {
                    if (
                        Menu::whereRaw('LOWER(link_menu) = (?)', [
                            strtolower($request->link_menu),
                        ])
                            ->where('is_deleted', '=', false)
                            ->where('id', '=', $menu['id'])
                            ->exists()
                    ) {
                        DB::beginTransaction();
                        $menu->update([
                            'nama_menu' => $request->nama_menu,
                            'link_menu' => $request->link_menu,
                            'keterangan' => $request->keterangan,
                            'class_icon' => $request->class_icon,
                            'app' => $request->app,
                            'updated_at' => Carbon::now(),
                        ]);

                        DB::commit();
                        return response()->json([
                            'success' => true,
                            'message' => 'Data berhasil diubah !',
                            'data' => $menu,
                        ]);
                    } else {
                        if (
                            Menu::whereRaw('LOWER(link_menu) = (?)', [
                                strtolower($request->link_menu),
                            ])
                                ->where('is_deleted', '=', false)
                                ->exists()
                        ) {
                            return response()->json(
                                [
                                    'success' => false,
                                    'message' => 'Link Menu sudah ada',
                                ],

                            );
                        } else {
                            DB::beginTransaction();
                            $menu->update([
                                'nama_menu' => $request->nama_menu,
                                'link_menu' => $request->link_menu,
                                'keterangan' => $request->keterangan,
                                'class_icon' => $request->class_icon,
                                'app' => $request->app,
                                'updated_at' => Carbon::now(),
                            ]);

                            DB::commit();
                            return response()->json([
                                'success' => true,
                                'message' => 'Data berhasil diubah !',
                                'data' => $menu,
                            ]);
                        }
                    }
                } else {
                    if (
                        Menu::whereRaw('LOWER(nama_menu) = (?)', [
                            strtolower($request->nama_menu),
                        ])
                            ->where('is_deleted', '=',false)
                            ->exists()
                    ) {
                        return response()->json(
                            [
                                'success' => false,
                                'message' => 'Nama Menu sudah ada',
                            ],

                        );
                    } else {
                        if (
                            Menu::whereRaw('LOWER(link_menu) = (?)', [
                                strtolower($request->link_menu),
                            ])
                                ->where('is_deleted', '=', false)
                                ->where('id', '=', $menu['id'])
                                ->exists()
                        ) {
                            DB::beginTransaction();
                            $menu->update([
                                'nama_menu' => $request->nama_menu,
                                'link_menu' => $request->link_menu,
                                'keterangan' => $request->keterangan,
                                'class_icon' => $request->class_icon,
                                'app' => $request->app,
                                'updated_at' => Carbon::now(),
                            ]);

                            DB::commit();
                            return response()->json([
                                'success' => true,
                                'message' => 'Data berhasil diubah !',
                                'data' => $menu,
                            ]);
                        } else {
                            if (
                                Menu::whereRaw('LOWER(link_menu) = (?)', [
                                    strtolower($request->link_menu),
                                ])
                                    ->where('is_deleted', '=', false)
                                    ->exists()
                            ) {
                                return response()->json(
                                    [
                                        'success' => false,
                                        'message' => 'Link Menu sudah ada',
                                    ],

                                );
                            } else {
                                DB::beginTransaction();
                                $menu->update([
                                    'nama_menu' => $request->nama_menu,
                                    'link_menu' => $request->link_menu,
                                    'keterangan' => $request->keterangan,
                                    'class_icon' => $request->class_icon,
                                    'app' => $request->app,
                                    'updated_at' => Carbon::now(),
                                ]);

                                DB::commit();
                                return response()->json([
                                    'success' => true,
                                    'message' => 'Data berhasil diubah !',
                                    'data' => $menu,
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
    public function HapusMenu($id)
    {
        try {
            // Soft Delete
            $menu = Menu::find($id);
            if (is_null($menu)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan !',
                ]);
            }

            DB::beginTransaction();
            $menu->update([
                'is_deleted' => 'true',
                'status' => '0',
                'updated_at' => Carbon::now(),
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
