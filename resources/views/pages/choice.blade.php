<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilihanmu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
            height: 100vh; overflow: hidden;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }

        /* Container Utama */
        .game-area {
            position: relative;
            width: 90%; max-width: 700px; height: 500px;
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255,255,255,0.4);
            border-radius: 30px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        h2 { 
            text-align: center; color: white; margin-bottom: 3rem; 
            text-shadow: 0 2px 4px rgba(0,0,0,0.1); 
            z-index: 10;
        }

        /* TOMBOL MUSIK */
        .music-btn-container { position: absolute; top: 20px; right: 20px; z-index: 50; }
        .btn-music {
            background: rgba(255, 255, 255, 0.3); border: 1px solid rgba(255, 255, 255, 0.6);
            color: white; border-radius: 50px; padding: 8px 15px; font-size: 0.85rem;
            cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px;
        }
        .btn-music:hover { background: white; color: #a18cd1; }
        .btn-music.playing { background: white; color: #a18cd1; box-shadow: 0 0 15px rgba(255, 255, 255, 0.6); }
        
        /* WRAPPER TOMBOL */
        .btn-wrapper {
            display: flex; gap: 25px; justify-content: center; align-items: center;
            transition: all 0.5s ease; width: 100%;
        }

        /* --- UPDATE: TOMBOL WELCOME (COLORFUL) --- */
        .btn-welcome {
            padding: 15px 40px; font-size: 1.1rem; font-weight: 700;
            border: none; border-radius: 50px;
            color: #a18cd1; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.1); 
            z-index: 20;
            
            /* Magic Gradient */
            background-image: linear-gradient(to right, #ffffff 0%, #ffffff 50%, #92d18cff 100%);
            background-size: 200% auto;
            transition: 0.5s;
        }

        .btn-welcome:hover {
            /* Saat hover, background geser jadi ungu, teks jadi putih */
            background-position: right center; 
            color: black;
            box-shadow: 0 0 20px rgba(161, 140, 209, 0.6); /* Glowing Ungu */
            transform: scale(1.1);
        }

        /* --- UPDATE: TOMBOL GOODBYE (COLORFUL WARNING) --- */
        .btn-goodbye {
            padding: 15px 40px; font-size: 1.1rem; font-weight: 600;
            border: 2px solid white; 
            border-radius: 50px;
            cursor: pointer;
            z-index: 20;

            /* Base State */
            background: transparent;
            color: white;
            
            /* Persiapan Gradient Merah */
            background-image: linear-gradient(to right, transparent 50%, #ff758c 100%);
            background-size: 200% auto;
            transition: all 0.4s ease-out;
        }

        .btn-goodbye:hover {
            /* Saat hover, jadi merah soft */
            background-position: right center;
            border-color: #ff758c;
            box-shadow: 0 0 15px rgba(255, 117, 140, 0.5); /* Glowing Merah */
            transform: scale(0.95);
        }

        .btn-absolute { position: absolute !important; }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .btn-wrapper { flex-direction: column; gap: 15px; }
            .btn-welcome, .btn-goodbye { width: 80%; }
            .btn-goodbye.btn-absolute { width: auto; }
        }
    </style>
</head>
<body>
    
    <audio id="bg-music" loop>
        <source src="{{ asset('audio/penjaga-hati.mp3') }}" type="audio/mpeg">
    </audio>

    <div class="game-area">
        
        <div class="music-btn-container">
            <button id="btn-toggle-music" class="btn-music">
                <i class="fas fa-play" id="music-icon"></i> 
                <span>Musik</span>
            </button>
        </div>

        <h2 id="question">kamu mau yang mana?</h2>
        
        <div class="btn-wrapper">
            <button class="btn btn-welcome" onclick="submitChoice('welcome')" id="btn-welcome-el">Selamat Datang Kembali</button>
            <button class="btn btn-goodbye" id="btn-run">Selamat Tinggal</button>
        </div>
    </div>

    <form id="decision-form" action="{{ route('save.decision') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="choice" id="input-choice">
        <input type="hidden" name="attempts" id="input-attempts" value="0">
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // LOGIKA MUSIK
            const audio = document.getElementById('bg-music');
            const musicBtn = $('#btn-toggle-music');
            const musicIcon = $('#music-icon');
            
            audio.volume = 0.6;

            musicBtn.click(function() {
                if (audio.paused) {
                    audio.play();
                    musicBtn.addClass('playing');
                    musicIcon.removeClass('fa-play').addClass('fa-pause');
                } else {
                    audio.pause();
                    musicBtn.removeClass('playing');
                    musicIcon.removeClass('fa-pause').addClass('fa-play');
                }
            });

            // LOGIKA TOMBOL LARI
            let attempts = 0;
            const btnRun = $('#btn-run');
            const btnWelcome = $('#btn-welcome-el');
            const container = $('.game-area');
            const questionText = $('#question');

            btnRun.on('click', function(e) {
                e.preventDefault();
                attempts++;
                $('#input-attempts').val(attempts);

                if(attempts >= 6) {
                    submitChoice('goodbye');
                    return;
                }

                if (!btnRun.hasClass('btn-absolute')) {
                    btnRun.addClass('btn-absolute');
                }

                const maxX = container.width() - btnRun.outerWidth();
                const maxY = container.height() - btnRun.outerHeight();

                const randomX = Math.random() * maxX;
                const randomY = Math.random() * maxY;

                btnRun.css({
                    'left': randomX + 'px',
                    'top': randomY + 'px',
                    'transition': 'all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1)'
                });

                // Efek Welcome Membesar
                let scale = 1.1 + (attempts * 0.1);
                // Update transform scale tapi tetap pertahankan logic hover CSS
                btnWelcome.css('transform', `scale(${scale})`);

                const texts = [
                    "Yakin na?", 
                    "Beneran mau udahan?", 
                    "Coba pikirin lagi...", 
                    "Jangan dong na...", 
                    "Sekali lagi klik, aku ikhlas."
                ];
                if(attempts <= texts.length) {
                    questionText.fadeOut(200, function() {
                        $(this).html(texts[attempts-1]).fadeIn(200);
                    });
                }
            });

            window.submitChoice = function(choice) {
                $('#input-choice').val(choice);
                $('#decision-form').submit();
            }
        });
    </script>
</body>
</html>