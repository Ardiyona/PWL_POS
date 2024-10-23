@extends('layouts.template')

@section('content')
    <div class="container-fluid">
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
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img src="{{ auth()->user()->foto ? asset('storage/images/' . auth()->user()->foto) : asset('default-avatar.png') }}"
                                class="profile-user-img img-fluid img-circle" style="width: 150px; height: 150px;"
                                alt="Avatar">
                        </div>

                        <h3 class="profile-username text-center">{{ auth()->user()->nama }}</h3>
                        <p class="text-muted text-center">{{ auth()->user()->username }}</p>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->

            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <!-- /.card-header -->

                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="editdatadiri">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{ Auth::user()->username }}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nama" id="nama" class="form-control"
                                            value="{{ Auth::user()->nama }}" disabled>
                                        <small id="error-nama" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="password" id="password" class="form-control"
                                            value="*****" disabled>
                                        <small id="error-password" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10 offset-sm-2">
                                        <button onclick="modalAction('{{ url('/profile/' . $user->user_id . '/upload') }}')"
                                            class="btn btn-primary">Update Profil</button>
                                    </div>
                                </div>
                            </div>

                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"
            data-width="75%"></div>
    </div><!-- /.container-fluid -->
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
    </script>
@endpush
