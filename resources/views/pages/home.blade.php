<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hai Hasna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
            height: 100vh; display: flex; align-items: center; justify-content: center;
        }
        .card-custom {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: none;
            padding: 2rem;
        }
        .btn-start {
            background: #00c6ff; color: white; border: none; font-weight: 600;
            padding: 10px 30px; border-radius: 50px; transition: 0.3s;
        }
        .btn-start:hover { background: #0072ff; transform: scale(1.05); }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="card card-custom mx-auto" style="max-width: 400px;">
            <h3 class="fw-bold text-dark mb-4">Masukin nama dulu, kalo bener boleh masuk</h3>
            <form action="{{ route('check.name') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="name" class="form-control text-center rounded-pill py-2" placeholder="Masukin nama" required>
                </div>
                <button type="submit" class="btn btn-start w-100">Masuk</button>
            </form>
            @if(session('error'))
                <div class="alert alert-danger mt-3 rounded-pill py-2 text-sm">{{ session('error') }}</div>
            @endif
        </div>
    </div>
</body>
</html>