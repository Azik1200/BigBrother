<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login • BigBrother</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .login-card-header {
            background: #343a40;
            color: white;
            padding: 1.5rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
        }

        .icon-inside {
            position: absolute;
            left: 15px;
            top: 2.5rem; /* или 50% + transformY(-50%) при необходимости */
            color: #6c757d;
            pointer-events: none;
            font-size: 1rem;
            line-height: 1.5;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom input {
            padding-left: 2.5rem;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card login-card">
                <div class="login-card-header text-center">
                    <h3 class="fw-bold mb-0">Welcome to BigBrother</h3>
                    <small class="text-light">Please log in to continue</small>
                </div>
                <div class="card-body p-4">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3 input-group-custom">
                            <label for="username" class="form-label">Username</label>
                            <i class="bi bi-person icon-inside"></i>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required value="{{ old('username') }}">
                        </div>

                        <div class="mb-4 input-group-custom">
                            <label for="password" class="form-label">Password</label>
                            <i class="bi bi-lock icon-inside"></i>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </button>
                    </form>
                </div>
            </div>

            <p class="text-center text-white-50 mt-4 small">© {{ date('Y') }} BigBrother Platform</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
