@extends('layouts.fullwidth')
@section('content')
<div class="col-md-6">
    <div class="authincation-content">
        <div class="row no-gutters">
            <div class="col-xl-12">
                <div class="auth-form">
                    <div class="text-center mb-3">
                        <a href="{!! url('/login'); !!}"><img class="w-100" src="{{ asset('images/logo-full.png') }}"
                                alt=""></a>
                    </div>
                    <h4 class="text-center mb-4">Inicia sesión</h4>
                    <form action="/login" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="mb-1"><strong>Correo electrónico</strong></label>
                            <input type="email" name="email" required class="form-control"
                                placeholder="Ingresa tu correo electrónico">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="mb-1"><strong>Contraseña</strong></label>
                            <input type="password" name="password" required class="form-control"
                                placeholder="Ingresa tu Contraseña">
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block text-center">Iniciar sesión</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection