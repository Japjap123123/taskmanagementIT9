<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #0b0b0b;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            background: #121212;
            border: 1px solid #222;
            border-radius: 12px;
            padding: 30px;
            width: 350px;
        }

        h3 {
            color: #ffffff !important;
        }

        .form-control {
            background: #111 !important;
            color: #ffffff !important;
            border: 1px solid #333;
        }

        .form-control::placeholder {
            color: #aaaaaa !important;
        }

        .form-control:focus {
            background: #111 !important;
            color: #ffffff !important;
            border-color: #666;
            box-shadow: none;
        }

        .btn-main {
            background: #1f1f1f;
            border: 1px solid #333;
            color: #fff;
        }

        .btn-main:hover {
            background: #333;
        }

        a {
            color: #ccc;
        }

        a:hover {
            color: #fff;
        }
    </style>
</head>
<body>

<div class="card">

    <h3 class="mb-4 text-center">Register</h3>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <input type="text" name="name" class="form-control mb-3" placeholder="Name" required>

        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

        <input type="password" name="password_confirmation" class="form-control mb-3" placeholder="Confirm Password" required>

        <button class="btn btn-main w-100">Register</button>
    </form>

    <div class="text-center mt-3">
        <a href="{{ route('login') }}">Already have an account?</a>
    </div>

</div>

</body>
</html>