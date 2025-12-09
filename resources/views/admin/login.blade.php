<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #2b5876;
            background: linear-gradient(to right, #4e4376, #2b5876);
            height: 100vh;
            display: flex; align-items: center; justify-content: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 2rem; border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 100%; max-width: 400px;
            color: white; border: 1px solid rgba(255,255,255,0.2);
        }
        .form-control {
            background: rgba(255,255,255,0.2); border: none; color: white;
            border-radius: 50px; padding: 10px 20px; text-align: center;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.6); }
        .form-control:focus { background: rgba(255,255,255,0.3); color: white; box-shadow: none; }
        .btn-login {
            background: white; color: #4e4376; border-radius: 50px; font-weight: 700;
            width: 100%; padding: 10px; border: none; transition: 0.3s;
        }
        .btn-login:hover { background: #f0f0f0; transform: scale(1.02); }
    </style>
</head>
<body>
    <div class="container px-4">
        <div class="login-card mx-auto">
            <h3 class="text-center mb-4">Ruang Pantau</h3>
            
            @if(session('error'))
                <div class="alert alert-danger py-2 text-center rounded-pill text-sm mb-3">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.auth') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                </div>
                <button type="submit" class="btn btn-login">Buka Data</button>
            </form>
        </div>
    </div>
</body>
</html>