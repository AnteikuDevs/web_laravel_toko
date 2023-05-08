@extends('layouts.index')
@section('content')
<div class="pagetitle">
    <h1>Kategori</h1>
</div>

<div class="card">
    <div class="card-body p-3">

        <div class="text-end mb-3">
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAdd"><i
                    class="ri-add-line"></i> Tambah</button>
        </div>

        <div class="table-responsive">
            <table class="table" width="100%" id="dt-content">
                <thead class="bg-primary text-white">
                    <tr>
                        <th width="80px">No</th>
                        <th>Nama</th>
                        <th width="300px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAdd" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="alert-message"></div>
                    <div class="mb-3">
                        <label for="" class="mb-2"><b>Nama</b> <small class="text-danger">*</small></label>
                        <input type="text" class="form-control" name="name" placeholder="Masukkan nama kategori">
                        <div data-error="name"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="alert-message"></div>
                    <div class="mb-3">
                        <label for="" class="mb-2"><b>Nama</b> <small class="text-danger">*</small></label>
                        <input type="text" class="form-control" name="name" placeholder="Masukkan nama kategori">
                        <div data-error="name"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modalDelete" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Konfirmasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="post">
            <div class="modal-body">
                <div class="_alert-message"></div>
                <div class="alert alert-warning alert-outline alert-outline-coloured alert-dismissible user-select-none" role="alert">
                        <div class="alert-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        </div>
                        <div class="alert-message">
                            Apakah anda yakin ingin menghapus data ini?
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="{{ asset('js/admin/category/index.js') }}"></script>    
@endpush