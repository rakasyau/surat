<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center;
            overflow: hidden; margin: 0;
        }
        
        /* Style Happy */
        .bg-happy { 
            background: #ff9a9e; 
            background-image: linear-gradient(to top, #fbc2eb 0%, #a6c1ee 100%);
            color: #333; 
        }
        
        /* Style Sad */
        .bg-sad { 
            background: #cfd9df;
            background-image: linear-gradient(120deg, #cfd9df 0%, #e2ebf0 100%);
            color: #555; 
        }
        
        .content-box {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(15px);
            padding: 3.5rem; border-radius: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            max-width: 550px; width: 90%;
            position: relative;
            z-index: 10;
            display: none; /* Disembunyikan dulu sampai tombol diklik */
        }

        /* --- OVERLAY PEMICU MUSIK (SOLUSI HP) --- */
        #music-trigger-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.85);
            z-index: 9999;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            color: white;
        }

        .btn-open-gift {
            background: #a18cd1; color: white; border: none;
            padding: 15px 40px; border-radius: 50px; font-weight: 700;
            font-size: 1.2rem; margin-top: 20px;
            box-shadow: 0 0 20px rgba(161, 140, 209, 0.5);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(161, 140, 209, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 20px rgba(161, 140, 209, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(161, 140, 209, 0); }
        }

        /* Tombol WA */
        .btn-wa { 
            background: #25D366; color: white; border: none; 
            padding: 15px 40px; border-radius: 50px; font-weight: 700; text-decoration: none; 
            font-size: 1.1rem; box-shadow: 0 10px 20px rgba(37, 211, 102, 0.3);
            display: inline-block; transition: all 0.3s;
        }
        
        .heart-icon {
            color: #ff6b6b; font-size: 4rem; margin-bottom: 20px;
            animation: heartbeat 1.5s infinite;
        }
        @keyframes heartbeat {
            0% { transform: scale(1); } 15% { transform: scale(1.2); } 30% { transform: scale(1); }
            45% { transform: scale(1.2); } 60% { transform: scale(1); }
        }
    </style>
</head>
<body class="{{ $status == 'welcome' ? 'bg-happy' : 'bg-sad' }}">

    <div id="music-trigger-overlay">
        <h2 class="mb-3 animate__animated animate__fadeInDown">Jawaban Terkirim</h2>
        <p class="mb-4 text-white-50">Ketuk tombol di bawah untuk membuka hasilnya</p>
        <button class="btn-open-gift" onclick="openEnding()">
            <i class="fas fa-envelope-open-text me-2"></i> Buka Pesan
        </button>
    </div>

    @if($status == 'welcome')
        <audio id="bg-music" loop>
            <source src="{{ asset('audio/lesung-pipi-cut.mp3') }}" type="audio/mpeg">
        </audio>
    @else
        <audio id="bg-music" loop>
            <source src="{{ asset('audio/pamit.mp3') }}" type="audio/mpeg">
        </audio>
    @endif

    <div id="main-content" class="content-box">
        @if($status == 'welcome')
            <div class="heart-icon">❤️</div>
            <h1 class="fw-bold mb-3" style="color: #a18cd1;">Terima Kasih, Na...</h1>
            <p class="fs-5 mb-5 text-secondary" style="line-height: 1.6;">
                Aku seneng banget kamu milih ini.<br>
                Kita mulai lagi pelan-pelan ya...
            </p>
            <a href="https://wa.me/628985475995" target="_blank" class="btn-wa">
                <i class="fab fa-whatsapp me-2"></i> Kabarin Aku di WA
            </a>
        @else
            <div class="mb-4 text-secondary opacity-50">
                <i class="fas fa-wind fa-3x animate__animated animate__pulse animate__infinite"></i>
            </div>
            <h1 class="fw-bold mb-3 text-secondary">Aku ngerti na...</h1>
            <p class="fs-5 mb-5 text-secondary">
                Gapapa kok. Makasih udah jujur.<br>
                Sukses terus buat ambisimu ya, Na. Jaga diri baik-baik.
                Tolong hapus semua chat kita ya, aku juga bakal demikian.
            </p>
            <button onclick="exitPage()" class="btn btn-outline-secondary rounded-pill px-4 py-2">Tutup Halaman</button>
        @endif
    </div>

    <script>
        // Fungsi Exit untuk Sad Ending
        function exitPage() {
            window.close();
            window.location.href = "about:blank";
        }

        // FUNGSI UTAMA: BUKA HASIL & PUTAR MUSIK
        function openEnding() {
            var audio = document.getElementById('bg-music');
            var overlay = document.getElementById('music-trigger-overlay');
            var content = document.getElementById('main-content');
            
            // 1. Putar Musik (Dijamin jalan di HP karena dipicu klik user)
            if(audio) {
                audio.volume = document.body.classList.contains('bg-happy') ? 0.8 : 0.5;
                audio.play();
            }

            // 2. Hilangkan Overlay dengan animasi
            $(overlay).fadeOut(500, function() {
                // 3. Munculkan Konten Utama
                $(content).fadeIn(500).addClass('animate__animated animate__zoomIn');
                
                // 4. Jalankan Confetti jika Happy
                @if($status == 'welcome')
                    startConfetti();
                @endif
            });
        }

        function startConfetti() {
            var duration = 5 * 1000;
            var end = Date.now() + duration;

            (function frame() {
                confetti({ particleCount: 5, angle: 60, spread: 55, origin: { x: 0 }, colors: ['#ff9a9e', '#fecfef', '#a18cd1'] });
                confetti({ particleCount: 5, angle: 120, spread: 55, origin: { x: 1 }, colors: ['#ff9a9e', '#fecfef', '#a18cd1'] });
                if (Date.now() < end) requestAnimationFrame(frame);
            }());
        }
    </script>
</body>
</html>