<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sebuah Pesan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        /* --- CORE STYLES (DARK THEME) --- */
        body {
            font-family: 'Poppins', sans-serif;
            /* Gradasi Langit Malam */
            background: radial-gradient(ellipse at bottom, #1b2735 0%, #090a0f 100%);
            color: #e0e0e0;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* --- STAR ANIMATION --- */
        #star-container {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1; pointer-events: none;
        }
        .star {
            position: absolute; background: white; border-radius: 50%; opacity: 0;
            animation: twinkle infinite ease-in-out;
        }
        @keyframes twinkle {
            0% { opacity: 0.2; transform: scale(0.8); }
            50% { opacity: 1; transform: scale(1.2); box-shadow: 0 0 10px white; }
            100% { opacity: 0.2; transform: scale(0.8); }
        }

        /* --- OVERLAY TRIGGER (PEMBUKA) --- */
        #start-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: #090a0f; /* Gelap total */
            z-index: 9999;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            color: white;
            transition: opacity 1s ease;
        }

        .btn-open-story {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.5);
            color: white;
            padding: 15px 40px; border-radius: 50px;
            font-size: 1.1rem; letter-spacing: 2px;
            margin-top: 30px;
            transition: 0.3s;
            cursor: pointer;
            box-shadow: 0 0 20px rgba(255,255,255,0.1);
        }
        .btn-open-story:hover {
            background: white; color: #090a0f;
            box-shadow: 0 0 40px rgba(255,255,255,0.5);
            transform: scale(1.05);
        }

        /* --- PAPER CONTAINER (DARK GLASS) --- */
        .paper-wrapper { 
            padding: 20px 15px; 
            display: none; /* Disembunyikan dulu */
            justify-content: center; 
            min-height: 100vh; 
            align-items: center;
        }
        
        .paper-container {
            width: 100%; max-width: 700px; 
            background: rgba(0, 0, 0, 0.5); 
            backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
            padding: 50px; border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(0,0,0,0.5); 
            border-top: 4px solid #a18cd1; 
            position: relative; z-index: 10;
        }

        h2 { 
            color: #e0c3fc; font-weight: 600; letter-spacing: 1px; margin-bottom: 2rem;
            text-shadow: 0 0 10px rgba(224, 195, 252, 0.3);
        }
        
        p { 
            line-height: 1.8; margin-bottom: 1.5rem; text-align: justify; 
            font-size: 1rem; color: #d1d1d1; font-weight: 300;
        }

        .highlight {
            color: #8fd3f4; font-weight: 600; text-shadow: 0 0 15px rgba(143, 211, 244, 0.4);
            transition: all 0.3s;
        }
        .paper-container:hover .highlight { color: #fff; text-shadow: 0 0 20px #8fd3f4; }

        .btn-next {
            background: transparent; border: 2px solid #a18cd1; color: #a18cd1;
            padding: 12px 40px; border-radius: 50px; font-weight: 600; 
            letter-spacing: 1px; transition: all 0.3s; text-decoration: none; 
            display: inline-block; box-shadow: 0 0 15px rgba(161, 140, 209, 0.1);
        }
        .btn-next:hover { 
            background: #a18cd1; color: #090a0f; 
            box-shadow: 0 0 30px rgba(161, 140, 209, 0.6); transform: translateY(-3px);
        }

        /* TOMBOL MUSIK (Manual Control) */
        .music-toggle-btn {
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;
            padding: 8px 18px; border-radius: 50px; font-weight: 400; font-size: 0.85rem;
            transition: all 0.3s; display: inline-flex; align-items: center; gap: 10px; cursor: pointer;
        }
        .music-toggle-btn:hover { background: rgba(255,255,255,0.2); border-color: #fff; }
        .music-toggle-btn.playing { 
            background: rgba(161, 140, 209, 0.3); border-color: #a18cd1; color: #e0c3fc;
            box-shadow: 0 0 15px rgba(161, 140, 209, 0.3);
        }

        @media (max-width: 768px) {
            .paper-container { padding: 30px 20px; }
            h2 { font-size: 1.5rem; }
            p { font-size: 0.95rem; }
        }
    </style>
</head>
<body>

    <audio id="bg-music" loop>
        <source src="{{ asset('audio/penjaga-hati.mp3') }}" type="audio/mpeg">
    </audio>

    <div id="start-overlay">
        <small class="text-white-50 mb-4 animate__animated animate__fadeIn">Untuk Hasna</small>
        
        <button class="btn-open-story animate__animated animate__pulse animate__infinite" onclick="openStory()">
            <i class="fas fa-book-open me-2"></i> BUKA
        </button>
    </div>

    <div id="star-container"></div>

    <div class="paper-wrapper" id="main-wrapper">
        <div class="paper-container">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div></div>
                <button id="btn-music" class="music-toggle-btn playing">
                    <i class="fas fa-pause" id="music-icon"></i> 
                    <span id="music-text">Jeda Lagu</span>
                </button>
            </div>

            <h2 class="text-center">Untuk, Hasna.</h2>
            
            <p>
                Assalamu'alaikum na... 
            </p>

            <p>
                Sekarang aku yang merasa jahat ke kamu na. Kyknya semenjak hari itu aku jadi kasar ke kamu, <span class="highlight">maaf ya... Aku rasa salah aku ke kamu banyak na...</span> Dari awal aku deketin kamu aja itu udah salah. Harusnya aku gausah maksain diri buat kamu punya perasaan yang sama kyk aku. 
                Aku terlalu percaya waktu kamu bilang juga suka aku na. Aku kira aku udah kenal kamu, aku kira kita udah deket... Ternyata ga gitu, secara teknis mungkin iya, tapi secara rasa nggak.
            </p>

            <p>
                Maaf karna aku juga pertemanan kita jadi hilang na... Bukannya aku gamau temenan sama kamu lagi na, aku mau banget malah terus interaksi sama kamu... <span class="highlight">Aku cuma gamau bikin kamu risih lagi.</span> Selama kita "deket" itu, rasanya aku sering bikin kamu risih dan aku seolah ga peduli. 
                Aku juga insecure sama kamu na... Aku ga berkembang, sedangkan kamu sebaliknya, kamu ambis. Makanya waktu itu aku ga jadi bilang "mending kita ulang dari awal" karna setelah dipikir-pikir hal yang sama mungkin terulang lagi na.
            </p>

            <p>
                Waktu hari itu, kalau itu aku setahun lalu, aku bakal nahan kamu, nyoba hubungin kamu terus, panas dingin karena itu... Tapi waktu itu ga gitu, aku santai ngelepasnya hanya karna udah capek kalau hal yang sama terus berulang.
            </p>

            <p>
                Kamu bagi aku kyk sesuatu yang harus terus dijaga dan dikasih tau, kalau dibiarin aja sebentar bakal lupa yang sebelumnya... Makanya setiap kamu ngilang aku selalu kesel na, terlalu takut kamu pergi... Jadi aku rasa mungkin apa yang udah kamu lakuin ke aku itu karna aku sendiri, 
                karna aku memanipulasi kamu pake kata-kata yang bikin kamu mikir. Padahal bukan itu yang aku mau, <span class="highlight">aku cuma pengen kamu ngelakuin hal yang bener² dari kamu sendiri.</span> Setiap kali kamu ngejauh dari aku, aku kyk ga peduli padahal itu yang sebenernya kamu mau, aku malah terus bilang ini itu biar kamu ga pergi... Maaf ya na...
            </p>

            <p>
                Aku kira kita bakal bisa bareng terus... Aku seneng pas kamu cerita ke aku, aku juga seneng cerita ke kamu, aku seneng pas kita jalan², aku seneng kalau kamu minta bantuan ke aku... Sampai waktu itu kamu bilang mau pulang ke bekasi bareng aku naik motor, 
                kamu bilang mau jalan² bareng aku sama temen² kamu... <span class="highlight">Aku seneng semua hal² bareng kamu...</span> Yang aku ga seneng itu pemikiran kamu yang aneh dan ga masuk akal itu na...
            </p>

            <p>
                Setelah diliat-liat, rasanya tipe kamu gaada di diri aku, apalagi aku yang sekarang. Tipe kamu mungkin yang aktif orangnya, ambis, dan bisa diajak gila²an... Mungkin kyk wali. Ya... Kyk tadi, ternyata kita belum deket, rasanya diri kamu yang asli blom keliatan pas sama aku, begitu pun sebaliknya.
            </p>

            <p>
                <span class="highlight">Apa kita masih bisa balikan?</span> apa kita bisa kyk biasa lagi? apa kamu ga risih sama ingatan masa lalu? Aku gatau kamu lagi deket sama cowo atau ngga, tapi kalau iya tolong kasih tau, biar aku punya alasan kuat buat ga interaksi sama kamu lagi...
            </p>

            <div class="text-center mt-5">
                <a href="{{ route('choice') }}" class="btn-next">
                    Lanjut ke Pertanyaan <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
            
        </div>
    </div>

    <script>
        // FUNGSI BUKA SURAT & PLAY MUSIK
        function openStory() {
            var audio = document.getElementById('bg-music');
            var overlay = document.getElementById('start-overlay');
            var wrapper = document.getElementById('main-wrapper');

            // 1. Play Musik
            if(audio) {
                audio.volume = 0.6;
                audio.play();
            }

            // 2. Fade Out Overlay -> Fade In Surat
            $(overlay).fadeOut(1000, function() {
                $(wrapper).css('display', 'flex').hide().fadeIn(1500).addClass('animate__animated animate__fadeInUp');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // --- 1. GENERATE BINTANG ---
            const starContainer = document.getElementById('star-container');
            for (let i = 0; i < 100; i++) {
                const star = document.createElement('div');
                star.classList.add('star');
                const x = Math.random() * 100;
                const y = Math.random() * 100;
                const size = Math.random() * 3 + 1;
                const duration = Math.random() * 3 + 2;
                const delay = Math.random() * 5;
                star.style.left = `${x}%`; star.style.top = `${y}%`;
                star.style.width = `${size}px`; star.style.height = `${size}px`;
                star.style.animationDuration = `${duration}s`; star.style.animationDelay = `${delay}s`;
                starContainer.appendChild(star);
            }

            // --- 2. LOGIKA TOMBOL MUSIK (PAUSE/RESUME) ---
            const audio = document.getElementById('bg-music');
            const btn = document.getElementById('btn-music');
            const icon = document.getElementById('music-icon');
            const text = document.getElementById('music-text');

            btn.addEventListener('click', function() {
                if (audio.paused) {
                    audio.play();
                    btn.classList.add('playing');
                    icon.classList.remove('fa-play');
                    icon.classList.add('fa-pause');
                    text.innerText = "Jeda Lagu";
                } else {
                    audio.pause();
                    btn.classList.remove('playing');
                    icon.classList.remove('fa-pause');
                    icon.classList.add('fa-play');
                    text.innerText = "Putar Lagu";
                }
            });
        });
    </script>
</body>
</html>