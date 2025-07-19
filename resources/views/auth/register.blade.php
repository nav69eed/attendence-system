<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Attendance System</title>
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
                                <i class="fas fa-user-plus text-primary me-2"></i>Create Account
                            </h1>
                            <p class="text-muted">Join the Attendance System</p>
                        </div>

                        <x-validation-errors />

                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            <x-form-input 
                                type="text"
                                name="name"
                                label="Full Name"
                                placeholder="Enter your full name"
                                icon="user"
                                required
                                autofocus
                            />

                            <x-form-input 
                                type="email"
                                name="email"
                                label="Email Address"
                                placeholder="Enter your email"
                                icon="envelope"
                                required
                            />

                            <x-form-input 
                                type="password"
                                name="password"
                                label="Password"
                                placeholder="Create a password"
                                icon="lock"
                                required
                            />

                            <x-form-input 
                                type="password"
                                name="password_confirmation"
                                label="Confirm Password"
                                placeholder="Confirm your password"
                                icon="lock"
                                required
                            />

                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Profile Picture (Optional)</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-image"></i>
                                    </span>
                                    <input type="file" 
                                           name="profile_picture" 
                                           id="profile_picture" 
                                           class="form-control @error('profile_picture') is-invalid @enderror" 
                                           accept="image/*">
                                    @error('profile_picture')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-user-plus me-2"></i>Register
                                </button>
                                <a href="{{ route('login') }}" class="btn btn-light">
                                    <i class="fas fa-sign-in-alt me-2"></i>Already have an account? Login
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