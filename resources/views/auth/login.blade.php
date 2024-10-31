@extends('layouts.app-auth')

@section('title', 'Iniciar sesión')

@section('content')
    <!-- Register -->
    <div class="card">
        <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                    {{--  <span class="app-brand-logo demo">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="App Logo" class="w-px-50 h-auto" />
                    </span>  --}}
                    <span class="app-brand-text demo text-body fw-bolder">Force Filters</span>
                </a>
            </div>
            <!-- /Logo -->

            <h4 class="mb-2">Bienvenido a Force Filters! 👋</h4>
            <p class="mb-4">Inicia sesión en tu cuenta y comienza la aventura.</p>

            <!-- Mostrar errores de sesión -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="text" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                        autocomplete="email" placeholder="Ingrese su correo electrónico o nombre de usuario" autofocus />
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">Contraseña</label>
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                ¿Has olvidado tu contraseña?
                            </a>
                        @endif
                    </div>
                    <div class="input-group input-group-merge">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            autocomplete="current-password" />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember-me"> Recuedame </label>
                    </div>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary d-grid w-100" type="submit">Iniciar sesión</button>
                </div>
            </form>
            {{--  <p class="text-center">
                <span>¿Nuevo en nuestra plataforma?</span>
                <a href="#">
                    <span>Crear una cuenta</span>
                </a>
            </p>  --}}
        </div>
        <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                    ©
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    , Ducker Dev
                    <a href="https://forcefilters.com" target="_blank" class="footer-link fw-bolder">Force Filters</a>
                </div>
            </div>
        </footer>
    </div>
    <!-- /Register -->
@endsection
