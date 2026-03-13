<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Biblio</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #ede8e0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Top bar ── */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 40px;
            background: #fff;
            border-bottom: 1px solid #e5ddd4;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.45rem;
            color: #1a2332;
            text-decoration: none;
        }

        .logo span { color: #c0844a; }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-text { font-size: 0.88rem; color: #6b7280; }

        .btn-signup {
            background-color: #1a2332;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 22px;
            font-size: 0.88rem;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-signup:hover { background-color: #2c3e55; }

        /* ── Main area ── */
        .main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #e5ddd4;
            box-shadow: 0 8px 40px rgba(26,35,50,0.08);
            display: flex;
            width: 100%;
            max-width: 860px;
            min-height: 460px;
            overflow: hidden;
        }

        /* ── Left : formulaire ── */
        .form-side {
            flex: 1;
            padding: 52px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.1rem;
            color: #1a2332;
            letter-spacing: -0.5px;
            margin-bottom: 28px;
        }

        .form-group { margin-bottom: 18px; }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            border: 1.5px solid #d1c9be;
            border-radius: 9px;
            padding: 11px 14px;
            font-size: 0.93rem;
            font-family: 'DM Sans', sans-serif;
            color: #1a2332;
            background: #faf8f5;
            outline: none;
            transition: border-color 0.2s, background 0.2s;
        }

        .form-input:focus { border-color: #1a2332; background: #fff; }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper .form-input { padding-right: 44px; }

        .toggle-password {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: #9ca3af;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .toggle-password:hover { color: #1a2332; }

        .form-error-block {
            background-color: #fef2f2;
            border: 1.5px solid #fca5a5;
            color: #991b1b;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 0.85rem;
        }

        .form-error-block ul { padding-left: 16px; }
        .form-error-block li { margin-top: 3px; }

        .status-msg {
            background-color: #ecfdf5;
            border: 1.5px solid #6ee7b7;
            color: #065f46;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 0.85rem;
        }

        .forgot-link {
            display: block;
            text-align: center;
            font-size: 0.83rem;
            color: #9ca3af;
            text-decoration: none;
            margin-top: 10px;
            transition: color 0.2s;
        }

        .forgot-link:hover { color: #1a2332; }

        .btn-submit {
            width: 100%;
            background-color: #1a2332;
            color: #fff;
            border: none;
            border-radius: 9px;
            padding: 13px;
            font-size: 0.95rem;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 6px;
        }

        .btn-submit:hover { background-color: #2c3e55; }

        .social-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 22px;
        }

        .social-label { font-size: 0.82rem; color: #9ca3af; white-space: nowrap; }

        .social-icons { display: flex; gap: 10px; }

        .social-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1.5px solid #d1c9be;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #374151;
            background: #fff;
            transition: border-color 0.2s, background 0.2s;
        }

        .social-btn:hover { border-color: #1a2332; background: #f5f0eb; }

        /* ── Right : illustration ── */
        .image-side {
            width: 380px;
            background: #dce8f5;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
            flex-shrink: 0;
        }

        .image-side img {
            width: 100%;
            max-width: 300px;
            object-fit: contain;
            filter: drop-shadow(0 8px 24px rgba(0,0,0,0.12));
        }

        @media (max-width: 700px) {
            .image-side { display: none; }
            .form-side { padding: 36px 28px; }
            .topbar { padding: 14px 20px; }
        }
    </style>
</head>
<body>

    <header class="topbar">
        <a href="/" class="logo">Gestion <span>Biblio</span></a>
        <div class="topbar-right">
            <span class="topbar-text">Pas encore de compte ?</span>
            <a href="{{ route('register') }}" class="btn-signup">S'inscrire</a>
        </div>
    </header>

    <main class="main">
        <div class="card">

            <!-- Gauche : formulaire -->
            <div class="form-side">
                <h1 class="page-title">Connexion</h1>

                @if (session('status'))
                    <div class="status-msg">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="form-error-block">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="email">Adresse Email</label>
                        <input id="email" type="email" name="email" class="form-input"
                            placeholder="Entrez votre adresse email"
                            value="{{ old('email') }}" autocomplete="email" autofocus>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Mot de passe</label>
                        <div class="input-wrapper">
                            <input id="password" type="password" name="password" class="form-input"
                                placeholder="Entrez votre mot de passe"
                                autocomplete="current-password">
                            <button type="button" class="toggle-password"
                                onclick="toggleVisibility('password', this)" tabindex="-1">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Se connecter</button>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </form>
            </div>

            <!-- Droite : illustration -->
            <div class="image-side">
                <img src="{{ asset('images/image_login.png') }}" alt="Livres illustrés">
            </div>

        </div>
    </main>

    <script>
        function toggleVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon  = btn.querySelector('svg');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            if (isHidden) {
                icon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>
                `;
            } else {
                icon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                `;
            }
        }
    </script>

</body>
</html>