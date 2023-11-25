@extends('layouts.fullwidth')
<style>
    .password-container {
        display: flex;
        align-items: center;
    }

    .password-toggle-icon {
        margin-left: -30px;
        cursor: pointer;
    }
</style>
@section('content')
    <div class="col-md-6">
        <div class="authincation-content">
            <div class="row no-gutters">
                <div class="col-xl-12">
                    <div class="auth-form">
                        <div class="text-center mb-3">
                            <a href="{!! url('/login') !!}"><img class="w-100" src="{{ asset('images/logo-full.png') }}"
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
                                <div class="password-container">
                                    <input type="password" name="password" required class="form-control"
                                        placeholder="Ingresa tu Contraseña">
                                    <span class="password-toggle-icon" onclick="togglePasswordVisibility()">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
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

@section('scripts')
    <script>
        function togglePasswordVisibility() {
            let passwordInput = document.querySelector('input[name="password"]');
            let passwordToggleIcon = document.querySelector('.password-toggle-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggleIcon.innerHTML = '<i class="fa fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                passwordToggleIcon.innerHTML = '<i class="fa fa-eye"></i>';
            }
        }
    </script>
@endsection
