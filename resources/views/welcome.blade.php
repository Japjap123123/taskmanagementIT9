<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #0b0b0b;
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .box {
            background: #121212;
            padding: 50px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #222;
        }

        .btn-main {
            background: #1f1f1f;
            color: #fff;
            border: 1px solid #333;
            margin: 5px;
        }

        .btn-main:hover {
            background: #333;
        }
    </style>
</head>
<body>

<div class="box">
    <h1 class="mb-3">Task Manager</h1>
    <p class="mb-4">Organize your work. Stay productive.</p>

    <a href="{{ route('login') }}" class="btn btn-main">Login</a>
    <a href="{{ route('register') }}" class="btn btn-main">Register</a>
</div>

</body>
</html>