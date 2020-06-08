@extends('layouts.app')
@section('login')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card-group shadow mb-5">
            <div class="card p-4">
                <form action="{{ route('login') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="card-body">
                        <h1>Acceder</h1>
                        <p class="text-muted">Control de acceso al sistema</p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                            </div>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" placeholder="Correo electronico" required autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="mdi mdi-lock"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña">
                            @error('password')
                                <div class="invalid-feedback">
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary px-4">Acceder</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                <div class="card-body text-center">
                    <div>
                        <h2>Sistema Altout</h2>
                        <p>Sistema de promocion y gestion de atractivos turisticos de la ciudad de El Alto</p>
                        <a href="#" class="btn btn-primary active mt-3">Ver Pagina Facebook</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

