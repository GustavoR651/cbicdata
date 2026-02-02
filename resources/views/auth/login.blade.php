<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso | CBIC Agenda</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

    <style>
        /* ================= RESET ================= */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        
        body {
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #1a1a1a;
            position: relative;
            overflow: hidden;
        }

        /* ================= FUNDO VIVO (RED EDITION) ================= */
        
        /* 1. Imagem de Construção (Fundo) */
        .bg-image {
            position: absolute;
            top: -10%; left: -10%; width: 120%; height: 120%;
            /* Imagem PB ou mais escura funciona melhor com vermelho */
            background-image: url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=2670&auto=format&fit=crop'); 
            background-size: cover;
            background-position: center;
            z-index: 0;
            animation: slowZoom 30s infinite alternate ease-in-out;
            filter: grayscale(100%) contrast(1.2); /* Preto e branco para destacar o vermelho */
        }

        @keyframes slowZoom {
            0% { transform: scale(1); }
            100% { transform: scale(1.1) translate(20px, -20px); }
        }

        /* 2. Overlay Escuro (Para o Vermelho Brilhar) */
        .bg-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 0, 5, 0.9) 100%);
            z-index: 1;
            backdrop-filter: blur(2px);
        }

        /* 3. Partículas de Luz (Vermelho CBIC) */
        .light-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            z-index: 2;
            opacity: 0.5;
            animation: floatOrb 10s infinite alternate;
        }
        /* Orb Principal: #FF3842 */
        .orb-1 { width: 450px; height: 450px; background: #FF3842; top: -120px; right: -120px; animation-delay: 0s; opacity: 0.4; }
        /* Orb Secundário: Vermelho mais escuro */
        .orb-2 { width: 350px; height: 350px; background: #991b1b; bottom: -80px; left: -80px; animation-delay: -5s; opacity: 0.3; }

        @keyframes floatOrb {
            0% { transform: translate(0, 0); opacity: 0.3; }
            100% { transform: translate(30px, 50px); opacity: 0.5; }
        }

        /* ================= CARD DE VIDRO ================= */
        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 45px;
            background: rgba(255, 255, 255, 0.9); /* Um pouco mais sólido */
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            text-align: center;
            animation: slideUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ================= CABEÇALHO ================= */
        .logo-area {
            margin-bottom: 30px;
        }

        .cbic-title {
            font-family: 'Roboto', sans-serif;
            font-weight: 900;
            font-size: 42px;
            color: #FF3842; /* O VERMELHO SOLICITADO */
            letter-spacing: -1.5px;
            margin: 0;
            line-height: 1;
            text-shadow: 0 4px 15px rgba(255, 56, 66, 0.2);
        }

        .cbic-subtitle {
            font-size: 11px;
            font-weight: 800;
            color: #1e293b; /* Texto escuro para contraste */
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 6px;
            display: block;
        }

        .divider {
            height: 4px;
            width: 40px;
            background: linear-gradient(90deg, #1e293b, #FF3842);
            margin: 15px auto 0;
            border-radius: 2px;
        }

        /* ================= INPUTS ================= */
        .input-group {
            margin-bottom: 20px;
            text-align: left;
            position: relative;
        }

        .input-label {
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 6px;
            display: block;
            margin-left: 5px;
        }

        .input-wrapper {
            position: relative;
            transition: all 0.3s;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #94a3b8;
            transition: 0.3s;
        }

        .styled-input {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 2px solid #e2e8f0;
            background: #f8fafc;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            outline: none;
            transition: all 0.3s ease;
        }

        /* Foco Vermelho */
        .styled-input:focus {
            background: #fff;
            border-color: #FF3842;
            box-shadow: 0 0 0 4px rgba(255, 56, 66, 0.15);
        }

        .styled-input:focus + .input-icon {
            color: #FF3842;
            transform: translateY(-50%) scale(1.1);
        }

        /* ================= BOTÃO VERMELHO ================= */
        .btn-login {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 12px;
            /* Gradiente Vermelho CBIC */
            background: linear-gradient(135deg, #FF3842 0%, #d32f2f 100%);
            color: white;
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 10px 20px -5px rgba(211, 47, 47, 0.4);
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -5px rgba(255, 56, 66, 0.5);
            background: linear-gradient(135deg, #ff5c65 0%, #FF3842 100%);
        }

        /* ================= LINKS & EXTRAS ================= */
        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            margin-bottom: 25px;
            color: #666;
        }

        .link { color: #FF3842; text-decoration: none; font-weight: 700; transition: 0.2s; }
        .link:hover { color: #d32f2f; text-decoration: underline; }

        .checkbox-label {
            display: flex; align-items: center; gap: 6px; cursor: pointer; font-weight: 600; color: #64748b;
        }
        input[type="checkbox"] { accent-color: #FF3842; cursor: pointer; }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            color: #888;
            font-weight: 600;
        }

        .error-msg {
            color: #FF3842; font-size: 11px; font-weight: 700; margin-top: 5px; display: block;
        }

    </style>
</head>
<body>

    <div class="bg-image"></div>
    <div class="bg-overlay"></div>
    <div class="light-orb orb-1"></div>
    <div class="light-orb orb-2"></div>

    <div class="login-card">
        
        <div class="logo-area">
            <h1 class="cbic-title">CBIC</h1>
            <span class="cbic-subtitle">Agenda Legislativa</span>
            <div class="divider"></div>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group">
                <label class="input-label">Email Corporativo</label>
                <div class="input-wrapper">
                    <input type="email" name="email" class="styled-input" placeholder="seu.email@cbic.org.br" value="{{ old('email') }}" required autofocus>
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                </div>
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="input-group">
                <label class="input-label">Senha</label>
                <div class="input-wrapper">
                    <input type="password" name="password" class="styled-input" placeholder="••••••••" required>
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="options">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember">
                    <span>Lembrar-me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link">Esqueci a senha</a>
                @endif
            </div>

            <button type="submit" class="btn-login">
                Entrar no Sistema
            </button>

            <div class="footer">
                © {{ date('Y') }} Câmara Brasileira da Indústria da Construção
            </div>
        </form>
    </div>

</body>
</html>