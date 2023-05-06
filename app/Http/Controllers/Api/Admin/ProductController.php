<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
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

        $dataCategory = Product::with('category');

        if(!empty($search))
        {
            $dataCategory = $dataCategory->where(function($query) use ($search){
                $query->where('name','like',"%$search%")
                ->orWhere('price','like',"%$search%");
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
            'image' => 'required|regex:/data:([a-zA-Z]*)\/([a-zA-Z]*);base64,([^\"]*)/u',
            'category' => 'required|exists:categories,id',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ],[
            'image.regex' => 'Image is base64 only',
        ]);

        $imageUpload = fileUpload(
            $request->image,
            "product",
            ['png','jpg','jpeg'],
            'image'
        );

        if($imageUpload['status'] == false)
        {
            return response($imageUpload);
        }

        $sv = Product::create([
            'image' => $imageUpload['data'],
            'category_id' => $request->category,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        if($sv)
        {
            return response([
                'status' => true,
                'message' => 'Berhasil menambah produk'
            ]);
        }

        return response([
            'status' => false,
            'message' => 'Gagal menambah produk'
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
        $dataProduk = Product::find($id);
        if(!$dataProduk)
        {
            return response([
                'status' => false,
                'message' => "Data tidak ditemukan"
            ]);
        }

        $request->validate([
            'image_deleted' => 'in:0,1',
            'image' => 'nullable|required_if:image_deleted,1|regex:/data:([a-zA-Z]*)\/([a-zA-Z]*);base64,([^\"]*)/u',
            'category' => 'required|exists:categories,id',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ],[
            'image.regex' => 'Image is base64 only',
        ]);

        $image_path = $dataProduk->image;

        if($request->input('image'))
        {
            $imageUpload = fileUpload(
                $request->image,
                "product",
                ['png','jpg','jpeg'],
                'image'
            );
    
            if($imageUpload['status'] == false)
            {
                return response($imageUpload);
            }

            $image_path = $imageUpload['data'];

        }


        $sv = $dataProduk->update([
            'image' => $image_path,
            'category_id' => $request->category,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        if($sv)
        {
            return response([
                'status' => true,
                'message' => 'Berhasil mengubah produk'
            ]);
        }

        return response([
            'status' => true,
            'message' => 'Gagal mengubah produk'
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
        $dataProduk = Product::find($id);
        if(!$dataProduk)
        {
            return response([
                'status' => false,
                'message' => "Data tidak ditemukan"
            ]);
        }

        try {
            $dataProduk->delete();
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
}
