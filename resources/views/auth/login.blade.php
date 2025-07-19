<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h1 class="h4 text-gray-900">
                                <i class="fas fa-calendar-check text-primary me-2"></i>Attendance System
                            </h1>
                            <p class="text-muted">Login to access your account</p>
                        </div>

                        <x-validation-errors />

                        @if(session('status'))
                            <x-alert type="success" class="mb-4">
                                {{ session('status') }}
                            </x-alert>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <x-form-input 
                                type="email"
                                name="email"
                                label="Email Address"
                                placeholder="Enter your email"
                                icon="envelope"
                                required
                                autofocus
                            />

                            <x-form-input 
                                type="password"
                                name="password"
                                label="Password"
                                placeholder="Enter your password"
                                icon="lock"
                                required
                            />

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </button>
                                <a href="{{ route('register') }}" class="btn btn-light">
                                    <i class="fas fa-user-plus me-2"></i>Create New Account
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>