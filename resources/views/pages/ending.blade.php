<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center;
            overflow: hidden;
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
        }

        /* Tombol WA (Happy) */
        .btn-wa { 
            background: #25D366; color: white; border: none; 
            padding: 15px 40px; border-radius: 50px; font-weight: 700; text-decoration: none; 
            font-size: 1.1rem; box-shadow: 0 10px 20px rgba(37, 211, 102, 0.3);
            display: inline-block; transition: all 0.3s;
        }
        .btn-wa:hover { 
            background: #128C7E; color: white; transform: translateY(-3px); 
            box-shadow: 0 15px 30px rgba(37, 211, 102, 0.5);
        }

        /* Animasi Hati Berdenyut */
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

    @if($status == 'welcome')
        <audio id="bg-music" autoplay loop>
            <source src="{{ asset('audio/penjaga-hati.mp3') }}" type="audio/mpeg">
        </audio>
    @else
        <audio id="bg-music" autoplay loop>
            <source src="{{ asset('audio/pamit.mp3') }}" type="audio/mpeg">
        </audio>
    @endif

    <div class="content-box animate__animated animate__zoomIn">
        @if($status == 'welcome')
            <div class="heart-icon">❤️</div>
            <h1 class="fw-bold mb-3" style="color: #a18cd1;">Terima Kasih, Na!</h1>
            <p class="fs-5 mb-5 text-secondary" style="line-height: 1.6;">
                Jujur aku seneng banget kamu milih ini.<br>
                Ayo kita mulai lagi pelan-pelan sebagai teman baik ya.
            </p>
            <a href="https://wa.me/628585475995" target="_blank" class="btn-wa">
                <i class="fab fa-whatsapp me-2"></i> Kabari Aku di WA
            </a>
        @else
            <div class="mb-4 text-secondary opacity-50">
                <i class="fas fa-wind fa-3x animate__animated animate__pulse animate__infinite"></i>
            </div>
            <h1 class="fw-bold mb-3 text-secondary">Aku Mengerti.</h1>
            <p class="fs-5 mb-5 text-secondary">
                Gapapa kok. Makasih sudah jujur.<br>
                Sukses terus buat ambisimu ya, Na. Jaga diri baik-baik.
            </p>
            
            <button onclick="exitPage()" class="btn btn-outline-secondary rounded-pill px-4 py-2">Tutup Halaman</button>
        @endif
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script>
        // FUNGSI TUTUP HALAMAN (Alternatif Aman)
        function exitPage() {
            // 1. Coba tutup standar (Biasanya diblokir Chrome/Edge jika user buka sendiri)
            window.close(); 
            
            // 2. Trik paksa (Kadang berhasil di browser lama)
            window.open('','_parent',''); 
            window.close();
            
            // 3. FALLBACK TERAKHIR (Paling Pasti)
            // Arahkan ke halaman kosong putih (about:blank). 
            // Ini ngasih efek "Sudah Selesai" / Hampa.
            window.location.href = "about:blank";
        }

        document.addEventListener('DOMContentLoaded', function() {
            var audio = document.getElementById('bg-music');
            if(audio) {
                audio.volume = document.body.classList.contains('bg-happy') ? 0.8 : 0.5;
                audio.play().catch(error => { console.log("Autoplay blocked"); });
            }

            @if($status == 'welcome')
                var duration = 5 * 1000;
                var end = Date.now() + duration;
                (function frame() {
                    confetti({ particleCount: 5, angle: 60, spread: 55, origin: { x: 0 }, colors: ['#ff9a9e', '#fecfef', '#a18cd1'] });
                    confetti({ particleCount: 5, angle: 120, spread: 55, origin: { x: 1 }, colors: ['#ff9a9e', '#fecfef', '#a18cd1'] });
                    if (Date.now() < end) requestAnimationFrame(frame);
                }());
            @endif
        });
    </script>
</body>
</html>