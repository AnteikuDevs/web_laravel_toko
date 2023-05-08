@extends('layouts.index')
@section('content')
<div class="pagetitle">
    <h1>Detail Transaksi <b>({{ $transaction->order_id }})</b></h1>
</div>

<div class="card">
    <div class="card-body p-3">
        <div class="table-responsive mb-3">
            <table class="table" width="100%" id="list-produk">
                <thead class="bg-success text-white">
                    <tr>
                        <th width="80px">No</th>
                        <th>Produk</th>
                        <th width="200px">Harga</th>
                        <th width="200px">Jumlah</th>
                        <th width="350px">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($transaction->detail as $detail)
                    @php
                        $total += $detail->total;
                    @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset($detail->product->image) }}" alt="Image" width="120px"/>
                                    <span class="ms-2">{{ $detail->product->name }}</span>
                                </div>
                            </td>
                            <td>
                                Rp. {{ number_format($detail->price,0,',','.') }}
                            </td>
                            <td>
                                {{ $detail->qty }}
                            </td>
                            <td>
                                Rp. {{ number_format($detail->total,0,',','.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-end">
            <span>Total: <b class="total-all">Rp. {{ number_format($total,0,',','.') }}</b></span> <br>
        </div>
    </div>
</div>

@endsection