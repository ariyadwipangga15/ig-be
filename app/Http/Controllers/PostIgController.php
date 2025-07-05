<?php

namespace App\Http\Controllers;

use App\Models\PostIg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use File;

class PostIgController extends Controller
{
    protected $postIgModel;
    public function __construct()
    {
        $this->postIgModel = new PostIg();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $page = $request->get('page');
            $limit = $request->get('limit');
            $sortBy = $request->get('sortby');
            $sortType = $request->get('sorttype');
            $q = ($request->get('q') != "") ? $request->get('q') : "";
            $q = str_replace(" ", "%", $q);
            $columnMap = $this->postIgModel->columnMap();

            // Filter Pagination
            $filter = array(
                'q' => $q,
                'page' => $page,
                'limit' => $limit,
                'sortby' => (isset($columnMap[$sortBy])) ? $columnMap[$sortBy] : 'created_at',
                'sorttype' => ($sortType != "") ? $sortType : 'desc',
            );

            $totalData = $this->postIgModel->getCountPostIg($filter);
            $data = $this->postIgModel->getListPostIg($filter);

            $response = [
                'success' => true,
                'data' => $data,
                'meta' => array(
                    'page' => $page,
                    'pageSize' => $limit,
                    'total' => $totalData,
                ),
            ];
            return response()->json($response, 200, [], JSON_UNESCAPED_SLASHES);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errorInfo,
            ]);
        }
    }

    public function getAll(Request $request)
    {
        $data = $this->postIgModel->getAllPostIg();
        foreach ($data as $row) {
            $row->foto = ($row->foto) ? url('/') . '/' . $row->foto : null;
        }

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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi data yang Kosong',
                'data'    => $validator->errors()
            ], 401);
        }

        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $image = $request->file('file');
        $imageName = time().'.'.$image->extension();
        $image->move(public_path('path_image'), $imageName);
        $path_data = 'path_image/';

        try {
            DB::beginTransaction();
            $postIg = PostIg::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'is_post' => $request->is_post,
                'is_like' => $request->is_like,
                'is_komentar' => $request->is_komentar,
                'path_image' => $path_data.$imageName

            ]);

            DB::commit();
            $response = [
                'success' => true,
                'message' => 'Data berhasil disimpan !',
                'data' => $postIg,
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $postIg = $this->postIgModel->getByID($id)->first();
            if (is_null($postIg)) {
                return response()->json([
                    "success" => false,
                    "message" => "Data tidak ditemukan !",
                ]);
            }

            return response()->json([
                "success" => true,
                "data" => $postIg,
            ], 200, [], JSON_UNESCAPED_SLASHES);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errorInfo,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi data yang Kosong',
                'data'    => $validator->errors()
            ], 401);
        }
        $id = $request->id;
        $imageOld = $request->fileOld;
        $image = $request->file('file');
        try {
            $postIg = PostIg::find($id);
            if (is_null($postIg)) {
                return response()->json([
                    "success" => false,
                    "message" => "Data tidak ditemukan !",
                ]);
            }

            if($image){
                $oldImagePath = public_path($imageOld); // Ganti dengan path gambar lama
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }        
                $imageName = time().'.'.$image->extension();
                $image->move(public_path('path_image'), $imageName);
                $path_image = 'path_image/';
                $upload = $path_image.$imageName;
            }else{
             $upload = $postIg->path_image;
            }

            DB::beginTransaction();
            $postIg->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'is_komentar' => $request->is_komentar,
                'is_like' => $request->is_like,
                'is_post' => $request->is_post,
                'path_image' => $upload
               
            ]);

            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Data berhasil diubah !",
                "data" => $postIg,
            ]);
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
    public function destroy($id)
    {
        try {
            // Soft Delete
            $postIg = PostIg::find($id);
            if (is_null($postIg)) {
                return response()->json([
                    "success" => false,
                    "message" => "Data tidak ditemukan !",
                ]);
            }

            DB::beginTransaction();
            $postIg->update([
                'status' => false,
            ]);
            DB::commit();

            return response()->json([
                "success" => true,
                "message" => "Data berhasil dihapus !",
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
