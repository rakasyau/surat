<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30">
    <title>Dashboard Hasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f6f9; color: #333; }
        .navbar { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .card-stats {
            border: none; border-radius: 15px; background: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05); padding: 20px; margin-bottom: 20px;
        }
        .table-responsive {
            background: white; border-radius: 15px; padding: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        .badge-welcome { background: #d1e7dd; color: #0f5132; padding: 8px 12px; border-radius: 30px; }
        .badge-goodbye { background: #f8d7da; color: #842029; padding: 8px 12px; border-radius: 30px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-light px-3 px-lg-5">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 fw-bold text-primary">Admin Panel</span>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-outline-danger rounded-pill px-3">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container py-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0">Daftar Respons</h4>
            <span class="badge bg-secondary rounded-pill">Auto-refresh 30s</span>
        </div>

        @if($responses->isEmpty())
            <div class="text-center py-5 card-stats">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada data masuk, Bro. Sabar ya...</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Waktu</th>
                            <th>Nama</th>
                            <th>Pilihan Akhir</th>
                            <th>Usaha Kabur</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($responses as $res)
                        <tr>
                            <td class="small text-muted">{{ $res->created_at->format('d M Y, H:i') }}</td>
                            <td class="fw-bold">{{ ucfirst($res->visitor_name) }}</td>
                            <td>
                                @if($res->choice == 'welcome')
                                    <span class="badge-welcome"><i class="fas fa-check-circle me-1"></i> Terima</span>
                                @else
                                    <span class="badge-goodbye"><i class="fas fa-times-circle me-1"></i> Tolak</span>
                                @endif
                            </td>
                            <td>
                                @if($res->goodbye_attempts > 0)
                                    <span class="text-danger fw-bold">{{ $res->goodbye_attempts }}x Klik</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $res->ip_address }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>

</body>
</html>