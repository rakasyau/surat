<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center;
            overflow: hidden; margin: 0; position: relative;
            background: #000; transition: background 1s ease;
        }

        /* --- BACKGROUND STYLES --- */
        .bg-happy { 
            background: linear-gradient(to bottom, #fff1eb 0%, #ace0f9 100%);
            animation: sunrise 3s ease-out forwards; 
        }
        @keyframes sunrise {
            0% { filter: brightness(0.2) grayscale(1); }
            100% { filter: brightness(1) grayscale(0); }
        }

        .bg-sad { 
            background: linear-gradient(to bottom, #203a43, #2c5364); 
            color: #ccc; 
        }

        /* --- CONTENT BOX --- */
        .content-box {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(5px);
            padding: 2.5rem; 
            max-width: 600px; width: 90%;
            position: relative; z-index: 10;
            display: none; border-radius: 30px;
        }
        
        /* Typography */
        h1.happy-title {
            font-size: 2.5rem; font-weight: 700;
            background: -webkit-linear-gradient(#ff9966, #ff5e62);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem; opacity: 0;
        }

        p.happy-text {
            font-size: 1.1rem; color: #555; font-weight: 300; line-height: 1.8;
            opacity: 0;
        }

        /* GIF Container */
        .heart-gif-container {
            margin-bottom: 20px; opacity: 0; display: flex; justify-content: center;
        }
        .heart-gif-image {
            width: 150px; height: auto;
            filter: drop-shadow(0 0 15px rgba(255, 153, 102, 0.4));
        }

        /* Tombol WA */
        .btn-wa { 
            background: linear-gradient(45deg, #11998e, #38ef7d); 
            color: white; border: none; 
            padding: 15px 40px; border-radius: 50px; font-weight: 600; text-decoration: none; 
            font-size: 1.1rem; 
            box-shadow: 0 10px 30px rgba(56, 239, 125, 0.4);
            display: inline-block; transition: all 0.5s;
            opacity: 0; transform: translateY(20px);
        }
        .btn-wa:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 15px 40px rgba(56, 239, 125, 0.6);
        }

        /* OVERLAY TRIGGER */
        #music-trigger-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: #000; z-index: 9999;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            color: white; padding: 20px;
        }
        .btn-open-gift {
            background: white; color: #333; border: none;
            padding: 15px 40px; border-radius: 50px; font-weight: 700;
            font-size: 1.1rem; margin-top: 20px;
            box-shadow: 0 0 30px rgba(255,255,255, 0.3); transition: 0.3s;
        }
        .btn-open-gift:hover { transform: scale(1.1); box-shadow: 0 0 50px rgba(255,255,255, 0.6); }

        /* Particles & Rain */
        .particle {
            position: absolute; border-radius: 50%;
            background: rgba(255, 200, 50, 0.8);
            box-shadow: 0 0 10px rgba(255, 200, 50, 0.5);
            animation: floatUp linear infinite;
        }
        @keyframes floatUp {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateY(-10vh) scale(1.5); opacity: 0; }
        }
        .rain { position: absolute; width: 100%; height: 100%; z-index: 0; pointer-events: none; }
        .drop {
            position: absolute; width: 1px; height: 80px; background: rgba(255,255,255,0.1);
            top: -100px; animation: fall linear infinite;
        }
        @keyframes fall { to { transform: translateY(110vh); } }

        /* --- RESPONSIVE MOBILE (< 576px) --- */
        @media (max-width: 576px) {
            .content-box {
                padding: 2rem 1.5rem; /* Padding lebih kecil */
                width: 85%;
            }
            h1.happy-title { font-size: 2rem; }
            .heart-gif-image { width: 120px; }
            .btn-wa { 
                width: 100%; /* Tombol Full Width */
                padding: 12px 0;
            }
            p.happy-text { font-size: 1rem; }
            
            /* Sad Mode Adjustment */
            h1.fw-bold { font-size: 2rem; }
            .fa-4x { font-size: 3em; }
        }
    </style>
</head>
<body>

    <div id="music-trigger-overlay">
        <h2 class="mb-3 animate__animated animate__fadeIn" style="font-weight: 300; letter-spacing: 2px;">JAWABAN TERKIRIM</h2>
        <button class="btn-open-gift" onclick="openEnding()">
            <i class="fas fa-envelope-open me-2"></i> Buka Hasil
        </button>
    </div>

    @if($status == 'welcome')
        <audio id="bg-music" loop>
            <source src="{{ asset('audio/lesung-pipi-cut.mp3') }}" type="audio/mpeg">
        </audio>
        <div id="particles-js"></div>
    @else
        <audio id="bg-music" loop>
            <source src="{{ asset('audio/pamit.mp3') }}" type="audio/mpeg">
        </audio>
        <div class="rain" id="rain-container"></div>
    @endif

    <div id="main-content" class="content-box">
        @if($status == 'welcome')
            <div class="heart-gif-container">
                <img src="{{ asset('image/happy-cat.gif') }}" alt="Happy Cat GIF" class="heart-gif-image animate__animated animate__pulse animate__infinite animate__slower">
            </div>
            
            <h1 class="happy-title">yeah</h1>
            
            <p class="happy-text">
                Makasih udah ngasih kesempatan lagi na. ayo kita mulai lagi pelan-pelan
            </p>
            
            <div class="mt-4">
                <a href="https://wa.me/628985475995" target="_blank" class="btn-wa">
                    <i class="fab fa-whatsapp me-2"></i> Kabarin Aku
                </a>
            </div>
        @else
            <div class="mb-4 text-secondary opacity-50">
                <i class="fas fa-cloud-showers-heavy fa-4x animate__animated animate__fadeIn"></i>
            </div>
            <h1 class="fw-bold mb-3 text-white-50">Aku ngerti na...</h1>
            <p class="fs-5 mb-5 text-white-50" style="font-weight: 300;">
                Gapapa kok. Makasih udah jujur. Sukses terus buat kamu ya, Na. 
                Tolong hapus semua chat dan foto kita ya, aku juga bakal hapus.<br>
                Jaga diri baik-baik.
            </p>
            <button onclick="exitPage()" class="btn btn-outline-light rounded-pill px-4 py-2 opacity-50 w-100">Tutup Halaman</button>
        @endif
    </div>

    <script>
        function exitPage() {
            window.close();
            window.location.href = "about:blank";
        }

        function openEnding() {
            var audio = document.getElementById('bg-music');
            var overlay = document.getElementById('music-trigger-overlay');
            var content = document.getElementById('main-content');
            var body = document.body;

            if(audio) {
                audio.volume = 0.7;
                audio.play();
            }

            $(overlay).fadeOut(1500, function() { 
                body.classList.add("{{ $status == 'welcome' ? 'bg-happy' : 'bg-sad' }}");
                $(content).fadeIn(1000);

                @if($status == 'welcome')
                    startParticles();
                    
                    setTimeout(() => {
                        $('.heart-gif-container').css({opacity: 0}).animate({opacity: 1}, 1000);
                        startConfetti();
                    }, 500);

                    setTimeout(() => {
                        $('.happy-title').css({opacity: 0, transform: 'translateY(20px)'})
                            .animate({opacity: 1, top: 0}, {
                                duration: 1000,
                                step: function(now, fx) {
                                    if(fx.prop == "top") $(this).css("transform", `translateY(${20-now}px)`);
                                }
                            });
                    }, 1500);

                    setTimeout(() => {
                        $('.happy-text').css({opacity: 0}).animate({opacity: 1}, 1500);
                    }, 3000);

                    setTimeout(() => {
                        $('.btn-wa').css({opacity: 1, transform: 'translateY(0)'});
                    }, 5000);
                @endif
            });
        }

        function startConfetti() {
            var duration = 8 * 1000;
            var end = Date.now() + duration;
            (function frame() {
                confetti({ particleCount: 3, angle: 60, spread: 55, origin: { x: 0 }, colors: ['#FFD700', '#FFA500', '#ffffff'], scalar: 1.2, drift: 0, gravity: 0.5 });
                confetti({ particleCount: 3, angle: 120, spread: 55, origin: { x: 1 }, colors: ['#FFD700', '#FFA500', '#ffffff'], scalar: 1.2, gravity: 0.5 });
                if (Date.now() < end) requestAnimationFrame(frame);
            }());
        }

        function startParticles() {
            const container = document.getElementById('particles-js');
            for(let i=0; i<30; i++) {
                let p = document.createElement('div');
                p.classList.add('particle');
                p.style.left = Math.random() * 100 + 'vw';
                p.style.width = Math.random() * 5 + 'px';
                p.style.height = p.style.width;
                p.style.animationDuration = Math.random() * 5 + 5 + 's';
                p.style.animationDelay = Math.random() * 5 + 's';
                container.appendChild(p);
            }
        }

        @if($status != 'welcome')
            const rainContainer = document.getElementById('rain-container');
            for(let i=0; i<50; i++) {
                let drop = document.createElement('div');
                drop.classList.add('drop');
                drop.style.left = Math.random() * 100 + 'vw';
                drop.style.animationDuration = Math.random() * 1 + 0.5 + 's';
                drop.style.animationDelay = Math.random() * 2 + 's';
                rainContainer.appendChild(drop);
            }
        @endif
    </script>
</body>
</html>