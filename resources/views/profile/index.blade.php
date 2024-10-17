@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary" id="data_profile">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
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
        </div>
        <img class="profile-user-img img-responsive img-circle" src="{{ asset('storage/images/'.$user->foto) }}" alt="Foto Profil Pengguna"
            style="border: 3px solid #adb5bd; margin: auto; padding: 3px; width:150px;">
        <h3 class="profile-username text-center">{{ Auth::user()->nama }}</h3>
        <p class="text-muted text-center">{{ Auth::user()->username }}</p>
        <br>
        <div class="card-header">
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/profile/'.$user->user_id.'/upload') }}')" class="btn btn-info">Edit Profile</button>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"
        data-width="75%"></div>
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