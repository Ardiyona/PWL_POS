@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/penjualan/import') }}')" class="btn btn-info">Import Transaksi Penjualan</button>
                <a href="{{ url('/penjualan/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export Transaksi Penjualan</a>
                <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export Transaksi Penjualan</a>
                <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-success">Tambah Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">- Semua -</option>
                                @foreach ($user as $l)
                                    <option value="{{ $l->user_id }}">{{ $l->nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Nama Pengguna</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pengguna</th>
                        <th>Pembeli</th>
                        <th>Kode Penjualan</th>
                        <th>Tanggal Penjualan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var dataPenjualan;
        $(document).ready(function() {
            dataPenjualan = $('#table_penjualan').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('penjualan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.user_id = $('#user_id').val();
                    }
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    ClassName: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "user.nama",
                    ClassName: "",
                    orderable: false,
                    searchable: false
                }, {
                    // mengambil data barang hasil dari ORM berelasi
                    data: "pembeli",
                    ClassName: "",
                    orderable: false,
                    searchable: true
                }, {
                    // mengambil data barang hasil dari ORM berelasi
                    data: "penjualan_kode",
                    ClassName: "",
                    orderable: true,
                    searchable: true
                }, {
                    // mengambil data barang hasil dari ORM berelasi
                    data: "penjualan_tanggal",
                    ClassName: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "aksi",
                    ClassName: "",
                    orderable: false,
                    searchable: false
                }]
            });
            $('#user_id').on('change', function() {
                dataPenjualan.ajax.reload();
            });
        });
    </script>
@endpush
