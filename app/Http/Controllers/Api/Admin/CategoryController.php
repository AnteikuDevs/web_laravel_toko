<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $start  = $request->input('start',0);
        $length = $request->input('length',10);
        $draw   = $request->input('draw');
        $search = $request->input('search.value');

        $dataCategory = new Category();

        if(!empty($search))
        {
            $dataCategory = $dataCategory->where(function($query) use ($search){
                $query->where('name','like',"%$search%");
            });
        }

        $total = $dataCategory->count();

        if($total == 0)
        {
            $result['recordsTotal']     = 0;
            $result['recordsFiltered']  = 0;
            $result['draw']             = $draw;
            $result['data']             = [];
            $result['status']           = false;
            $result['message']          = "Data tidak ditemukan";
            return response($result);
        }

        $data = $dataCategory->offset($start)->limit($length)->get();

        $result['recordsTotal']     = $total;
        $result['recordsFiltered']  = $total;
        $result['draw']             = $draw;
        $result['data']             = $data;
        $result['status']           = true;
        $result['message']          = "OK";
        return response($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $sv = Category::create([
            'name' => $request->name,
        ]);

        if($sv)
        {
            return response([
                'status' => true,
                'message' => 'Berhasil menambah kategori'
            ]);
        }

        return response([
            'status' => false,
            'message' => 'Gagal menambah kategori'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dataCategory = Category::find($id);
        if(!$dataCategory)
        {
            return response([
                'status' => false,
                'message' => "Data tidak ditemukan"
            ]);
        }

        $request->validate([
            'name' => 'required',
        ]);

        $sv = $dataCategory->update([
            'name' => $request->name,
        ]);

        if($sv)
        {
            return response([
                'status' => true,
                'message' => 'Berhasil mengubah kategori'
            ]);
        }

        return response([
            'status' => true,
            'message' => 'Gagal mengubah kategori'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataCategory = Category::find($id);
        if(!$dataCategory)
        {
            return response([
                'status' => false,
                'message' => "Data tidak ditemukan"
            ]);
        }

        try {
            $dataCategory->delete();
            return response([
                'status' => true,
                'message' => "Berhasil menghapus data"
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => true,
                'message' => "Data tidak dapat dihapus"
            ]);
        }
    }

    public function list()
    {
        $data = Category::all();
        if(count($data))
        {
            return response([
                'status' => true,
                'data' => $data
            ]);
        }

        return response([
            'status' => false,
            'message' => 'Data tidak ditemukan'
        ]);
    }
}
