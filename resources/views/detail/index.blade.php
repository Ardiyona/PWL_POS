@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/detail/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
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
                            <select name="penjualan_id" id="penjualan_id" class="form-control" required>
                                <option value="">- Semua -</option>
                                @foreach ($penjualan as $l)
                                    <option value="{{ $l->penjualan_id }}">{{ $l->penjualan_kode }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kode Penjualan</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_detail">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Penjualan</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
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

        var dataDetail;
        $(document).ready(function() {
            dataDetail = $('#table_detail').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('detail/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.penjualan_id = $('#penjualan_id').val();
                    }
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    ClassName: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "penjualan.penjualan_kode",
                    ClassName: "",
                    orderable: false,
                    searchable: false
                }, {
                    // mengambil data barang hasil dari ORM berelasi
                    data: "barang.barang_nama",
                    ClassName: "",
                    orderable: false,
                    searchable: true
                }, {
                    data: "harga",
                    ClassName: "",
                    orderable: true,
                    searchable: false
                }, {
                    data: "jumlah",
                    ClassName: "",
                    orderable: true,
                    searchable: false
                }, {
                    data: "aksi",
                    ClassName: "",
                    orderable: false,
                    searchable: false
                }]
            });
            $('#penjualan_id').on('change', function() {
                dataDetail.ajax.reload();
            });
        });
    </script>
@endpush
