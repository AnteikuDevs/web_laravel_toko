@extends('layouts.index')
@section('content')
<div class="pagetitle">
    <h1>Tambah Transaksi</h1>
</div>

<div class="card">
    <div class="card-body p-3">
        <div class="text-end mb-3">
            <button class="btn btn-success" id="add-product">Tambah Produk</button>
        </div>
        <form action="" id="transaction-add">
        
            <div class="table-responsive mb-3">
                <table class="table" width="100%" id="list-produk">
                    <thead class="bg-success text-white">
                        <tr>
                            <th width="80px">No</th>
                            <th>Produk</th>
                            <th width="200px">Harga</th>
                            <th width="200px">Jumlah</th>
                            <th width="350px">Subtotal</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <div class="text-end">
                <span>Total: <b class="total-all">Rp. 0</b></span> <br>

                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            </div>
        
        </form>
    </div>
</div>

@endsection
@push('script')
<script src="{{ asset('js/kasir/transaction/create.js') }}"></script>
@endpush