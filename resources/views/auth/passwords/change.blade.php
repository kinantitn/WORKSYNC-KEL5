@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

{{--@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )--}}

{{--@section('auth_header', __('adminlte::adminlte.password_reset_message'))--}}

@section('auth_body')
    <form onsubmit="handleChangePassword(this,event)">
        <div class="input-group mb-3">
            <input type="text" name="email" class="form-control" value="{{ auth()->user()->name }}" disabled>
        </div>

        <div class="input-group mb-3">
            <input type="text" name="email" class="form-control" id="old_password" placeholder="password lama">
        </div>

        <div class="input-group mb-3">
            <input type="text" name="email" class="form-control" id="new_password" placeholder="password baru">
        </div>

        <div class="input-group mb-3">
            <input type="text" name="email" class="form-control" id="confirm_password" placeholder="konfirmasi password baru">
        </div>


        {{-- Confirm password reset button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}"
            <span class="fas fa-sync-alt"></span>
            Ubah Password
        </button>

    </form>
@stop


@section('js')
    <script src="{{asset('app/build/changePassword.js')}}"></script>
    <script src="{{asset('app/build/app.js')}}"></script>
@stop
