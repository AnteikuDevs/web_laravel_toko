@extends('layouts.index')
@section('content')
<div class="pagetitle">
    <h1>Transaksi</h1>
</div>

<div class="card">
    <div class="card-body p-3">

        <div class="text-end mb-3">
            <a href="{{ route('kasir.transaction.create') }}" class="btn btn-success btn-sm"><i
                    class="ri-add-line"></i> Tambah Transaksi</a>
        </div>

        <div class="table-responsive">
            <table class="table" width="100%" id="dt-content">
                <thead class="bg-primary text-white">
                    <tr>
                        <th width="80px">No</th>
                        <th>Tanggal</th>
                        <th>Order ID</th>
                        <th>Total</th>
                        <th width="300px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
@push('script')
<script src="{{ asset('js/kasir/transaction/index.js') }}"></script>    
@endpush