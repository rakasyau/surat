<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hai Hasna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* --- BACKGROUND --- */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f2027; /* Fallback */
            /* Deep Dark Gradient */
            background-image: linear-gradient(to right, #0f2027, #203a43, #2c5364); 
            height: 100vh;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; margin: 0; color: white;
            position: relative;
        }

        /* --- MOVING BLOBS (Bola Cahaya di Belakang Kaca) --- */
        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: 0;
            opacity: 0.6;
            animation: moveBlob 20s infinite alternate;
        }
        .blob-1 {
            top: 10%; left: 20%; width: 300px; height: 300px;
            background: #7F7FD5; /* Ungu Kebiruan */
        }
        .blob-2 {
            bottom: 20%; right: 20%; width: 350px; height: 350px;
            background: #91EAE4; /* Cyan Muda */
            animation-delay: -5s;
        }
        .blob-3 {
            bottom: 10%; left: 10%; width: 250px; height: 250px;
            background: #ff9a9e; /* Pink Soft */
            animation-delay: -10s;
        }

        @keyframes moveBlob {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, -30px) scale(1.1); }
        }

        /* --- GLASS CARD (INTI GLASSMORPHISM) --- */
        .glass-panel {
            background: rgba(255, 255, 255, 0.1); /* Putih Transparan */
            backdrop-filter: blur(15px); /* Efek Blur Kaca */
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2); /* Border tipis mengkilap */
            border-top: 1px solid rgba(255, 255, 255, 0.5); /* Highlight atas */
            border-left: 1px solid rgba(255, 255, 255, 0.5); /* Highlight kiri */
            border-radius: 20px;
            padding: 3rem 2.5rem;
            width: 90%; max-width: 420px;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5); /* Bayangan dalam */
            position: relative; z-index: 10;
        }

        /* --- TYPOGRAPHY --- */
        h1.greeting {
            font-family: cursive;
            font-size: 3.5rem; margin-bottom: 0.5rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .sub-text {
            font-size: 0.85rem; letter-spacing: 3px; text-transform: uppercase;
            color: rgba(255,255,255,0.7); margin-bottom: 2.5rem;
        }

        /* --- INPUT FIELD TRANSPARAN --- */
        .input-group-glass {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .input-glass {
            width: 100%;
            background: rgba(255,255,255,0.1);
            border: none;
            border-radius: 50px;
            padding: 15px 25px;
            color: white;
            font-size: 1rem;
            text-align: center;
            transition: all 0.3s;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .input-glass:focus {
            outline: none;
            background: rgba(255,255,255,0.2);
            box-shadow: 0 0 15px rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.5);
        }
        .input-glass::placeholder { color: rgba(255,255,255,0.5); }

        /* --- BUTTON GLASS --- */
        .btn-glass {
            background: linear-gradient(135deg, rgba(255,255,255,0.4) 0%, rgba(255,255,255,0.1) 100%);
            border: 1px solid rgba(255,255,255,0.3);
            color: white; font-weight: 600;
            padding: 12px 40px; border-radius: 50px;
            width: 100%;
            transition: 0.3s;
            cursor: pointer;
            text-transform: uppercase; letter-spacing: 1px;
            font-size: 0.9rem;
        }
        .btn-glass:hover {
            background: white; color: #203a43;
            box-shadow: 0 0 20px rgba(255,255,255,0.4);
            transform: translateY(-2px);
        }

        /* Error Badge */
        .error-glass {
            background: rgba(255, 99, 71, 0.2);
            border: 1px solid rgba(255, 99, 71, 0.5);
            color: #ffcccb; font-size: 0.8rem;
            padding: 8px 15px; border-radius: 50px;
            margin-top: 15px; display: inline-block;
        }

        /* Typing Cursor */
        .cursor { display: inline-block; width: 2px; height: 1em; background: white; animation: blink 1s infinite; }
        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }
    </style>
</head>
<body>

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="glass-panel animate__animated animate__fadeInUp">
        
        <div class="mb-2 opacity-75">
            <i class="fas fa-feather-alt fa-2x"></i>
        </div>

        <h3 class="greeting">
            <span id="typewriter"></span><span class="cursor">|</span>
        </h3>
        <p class="sub-text">private ini mah</p>

        <form action="{{ route('check.name') }}" method="POST" autocomplete="off">
            @csrf
            <div class="input-group-glass">
                <input type="text" name="name" class="input-glass" 
                       placeholder="coba aja masukin nama lain" required>
            </div>
            
            <button type="submit" class="btn-glass">
                Masuk
            </button>
        </form>

        @if(session('error'))
            <div class="error-glass animate__animated animate__headShake">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="mt-4 opacity-50" style="font-size: 0.7rem;">
            pake headset biar asik
        </div>
    </div>

    <script>
        // TYPEWRITER EFFECT
        const text = "masukin nama kamu, kalo bener boleh masuk";
        const typeWriterElement = document.getElementById('typewriter');
        let i = 0;

        function type() {
            if (i < text.length) {
                typeWriterElement.innerHTML += text.charAt(i);
                i++;
                setTimeout(type, 50); 
            } else {
                document.querySelector('.cursor').style.display = 'none';
            }
        }
        setTimeout(type, 500);
    </script>
</body>
</html>