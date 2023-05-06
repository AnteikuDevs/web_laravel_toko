<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
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

        $dataTransaction = Transaction::withCasts(['created_at' => 'date:D, d M Y']);

        if(!empty($search))
        {
            $dataTransaction = $dataTransaction->where(function($query) use ($search){
                $query->where('order_id','like',"%$search%")
                ->orWhere('total','like',"%$search%")
                ->orWhereRelation('detail',function($query) use ($search){
                    $query->whereRelation('product','name','like','%'.$search.'%');
                });
            });
        }

        $total = $dataTransaction->count();

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

        $data = $dataTransaction->orderBy('created_at','desc')->offset($start)->limit($length)->get();

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
            'data' => 'array|required',
            'data.*.product' => 'required|exists:products,id',
            'data.*.qty' => 'required|numeric'
        ]);

        $sv = Transaction::create([
            'order_id' => 'ORD-'.date('YmdHi'),
            'total' => 0
        ]);

        if($sv)
        {
            $transaction_id = $sv->id;
            $total = 0;

            $detail = [];

            foreach($request->data as $item){
                $product = Product::find($item['product']);
                $product->update([
                    'stock' => $product->stock - $item['qty']
                ]);
                $total += ($product->price * $item['qty']);

                $detail[] = [
                    'transaction_id' => $transaction_id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'qty' => $item['qty'],
                    'total' => ($product->price * $item['qty'])
                ];

            }

            TransactionDetail::insert($detail);

            $sv->update(['total' => $total]);

            return response([
                'status' => true,
                'message' => 'Berhasil membuat transaksi'
            ]);
        }

        return response([
            'status' => false,
            'message' => 'Gagal membuat transaksi'
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
