<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilihanmu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* --- ANIMATED BACKGROUND (CALM) --- */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(-45deg, #a18cd1, #fbc2eb, #96e6a1, #d4fc79);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            height: 100vh; overflow: hidden;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            margin: 0;
            /* Fix tinggi di mobile browser modern */
            min-height: -webkit-fill-available;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* --- OVERLAY PEMICU MUSIK --- */
        #music-trigger-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6); backdrop-filter: blur(10px);
            z-index: 9999;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            color: white; padding: 20px; text-align: center;
        }

        .btn-start-choice {
            background: white; color: #a18cd1; border: none;
            padding: 15px 40px; border-radius: 50px; font-weight: 700;
            font-size: 1.2rem; margin-top: 30px;
            box-shadow: 0 0 20px rgba(255,255,255, 0.4);
            transition: 0.3s; animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); } 50% { transform: scale(1.05); } 100% { transform: scale(1); }
        }

        /* --- GAME AREA --- */
        .game-area {
            position: relative;
            width: 90%; max-width: 700px; height: 500px;
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255,255,255,0.4);
            border-radius: 30px;
            display: none; /* Hidden Awal */
            flex-direction: column; align-items: center; justify-content: center;
            padding: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        h2 { 
            text-align: center; color: white; margin-bottom: 3rem; 
            text-shadow: 0 2px 4px rgba(0,0,0,0.1); 
            z-index: 10; font-size: 2rem;
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

        /* Wrapper Tombol */
        .btn-wrapper {
            display: flex; gap: 25px; justify-content: center; align-items: center;
            transition: all 0.5s ease; width: 100%;
        }

        /* Tombol Welcome */
        .btn-welcome {
            padding: 15px 40px; font-size: 1.1rem; font-weight: 700;
            border: none; border-radius: 50px;
            color: #a18cd1; box-shadow: 0 5px 15px rgba(0,0,0,0.1); z-index: 20;
            background-image: linear-gradient(to right, #ffffff 0%, #ffffff 50%, #92d18cff 100%);
            background-size: 200% auto; transition: 0.5s;
        }
        .btn-welcome:hover {
            background-position: right center; color: black;
            box-shadow: 0 0 20px rgba(161, 140, 209, 0.6); transform: scale(1.1);
        }

        /* Tombol Goodbye */
        .btn-goodbye {
            padding: 15px 40px; font-size: 1.1rem; font-weight: 600;
            border: 2px solid white; border-radius: 50px;
            cursor: pointer; z-index: 20;
            background: transparent; color: white;
            background-image: linear-gradient(to right, transparent 50%, #ff758c 100%);
            background-size: 200% auto; transition: all 0.4s ease-out;
        }
        .btn-goodbye:hover {
            background-position: right center; border-color: #ff758c;
            box-shadow: 0 0 15px rgba(255, 117, 140, 0.5); transform: scale(0.95);
        }

        .btn-absolute { position: absolute !important; }

        /* --- RESPONSIVE MOBILE (< 768px) --- */
        @media (max-width: 768px) {
            .game-area {
                height: 65vh; /* Sesuaikan tinggi dengan layar HP */
                padding: 15px;
            }
            h2 { 
                font-size: 1.5rem; /* Font Judul Lebih Kecil */
                margin-bottom: 2rem; 
            }
            .btn-wrapper { 
                flex-direction: column; /* Tombol jadi Atas-Bawah */
                gap: 20px; 
            }
            .btn-welcome, .btn-goodbye { 
                width: 100%; /* Tombol Full Width */
                max-width: 280px;
                padding: 12px 20px;
                font-size: 1rem;
            }
            .btn-goodbye.btn-absolute {
                width: auto; /* Kalau lari, ukurannya balik normal */
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    
    <audio id="bg-music" loop>
        <source src="{{ asset('audio/Snowfall.mp3') }}" type="audio/mpeg">
    </audio>

    <div id="music-trigger-overlay">
        <h2 class="mb-2 animate__animated animate__fadeInDown">Satu Pertanyaan Terakhir</h2>
        <p class="mb-4 text-white-50 small">Pilih dengan hati ya, Na.</p>
        <button class="btn-start-choice" onclick="openChoice()">
            <i class="fas fa-question-circle me-2"></i> Jawab
        </button>
    </div>

    <div class="game-area" id="main-content">

        <h2 id="question">kamu pilih yang mana?</h2>
        
        <div class="btn-wrapper">
            <button class="btn btn-welcome" onclick="submitChoice('welcome')" id="btn-welcome-el">Balikan</button>
            <button class="btn btn-goodbye" id="btn-run">Udahan</button>
        </div>
    </div>

    <form id="decision-form" action="{{ route('save.decision') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="choice" id="input-choice">
        <input type="hidden" name="attempts" id="input-attempts" value="0">
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function openChoice() {
            var audio = document.getElementById('bg-music');
            var overlay = document.getElementById('music-trigger-overlay');
            var content = document.getElementById('main-content');
            
            if(audio) { audio.volume = 0.6; audio.play(); }

            $(overlay).fadeOut(800, function() {
                $(content).css('display', 'flex').addClass('animate__animated animate__fadeIn');
            });
        }

        $(document).ready(function() {
            const audio = document.getElementById('bg-music');
            const musicBtn = $('#btn-toggle-music');
            const musicIcon = $('#music-icon');
            
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
                    submitChoice('goodbye'); return;
                }

                if (!btnRun.hasClass('btn-absolute')) {
                    btnRun.addClass('btn-absolute');
                }

                const maxX = container.width() - btnRun.outerWidth();
                const maxY = container.height() - btnRun.outerHeight();
                const randomX = Math.random() * maxX;
                const randomY = Math.random() * maxY;

                btnRun.css({
                    'left': randomX + 'px', 'top': randomY + 'px',
                    'transition': 'all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1)'
                });

                let scale = 1.1 + (attempts * 0.1);
                btnWelcome.css('transform', `scale(${scale})`);

                const texts = ["Yakin na?", "Beneran mau udahan?", "Coba pikirin lagi...", "Jangan dong na...", "......."];
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