<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Bibliothèque</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #f5f0eb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            border: 1.5px solid #e5ddd4;
            padding: 48px 44px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 8px 40px rgba(26, 35, 50, 0.07);
        }

        .card-header { margin-bottom: 36px; }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #1a2332;
            letter-spacing: -0.5px;
        }

        .card-subtitle { color: #9ca3af; font-size: 0.9rem; margin-top: 6px; }

        .form-group { margin-bottom: 20px; }

        .form-label {
            display: block;
            font-size: 0.88rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 7px;
        }

        .form-input {
            width: 100%;
            border: 1.5px solid #d1c9be;
            border-radius: 9px;
            padding: 11px 14px;
            font-size: 0.95rem;
            font-family: 'DM Sans', sans-serif;
            color: #1a2332;
            background: #faf8f5;
            outline: none;
            transition: border-color 0.2s, background 0.2s;
        }

        .form-input:focus { border-color: #1a2332; background: #fff; }

        /* wrapper pour input + icône */
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper .form-input {
            padding-right: 44px;
        }

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

        .error-msg { color: #c81e1e; font-size: 0.82rem; margin-top: 5px; }

        .form-error-block {
            background-color: #fef2f2;
            border: 1.5px solid #fca5a5;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.88rem;
        }

        .form-error-block ul { padding-left: 16px; }
        .form-error-block li { margin-top: 3px; }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.88rem;
            color: #6b7280;
            cursor: pointer;
        }

        .remember-label input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: #1a2332;
        }

        .forgot-link { font-size: 0.85rem; color: #9ca3af; text-decoration: none; transition: color 0.2s; }
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
        }

        .btn-submit:hover { background-color: #2c3e55; }

        .divider {
            text-align: center;
            color: #d1c9be;
            font-size: 0.82rem;
            margin: 20px 0;
            position: relative;
        }

        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 42%;
            height: 1px;
            background: #e5ddd4;
        }

        .divider::before { left: 0; }
        .divider::after  { right: 0; }

        .btn-register {
            width: 100%;
            background-color: transparent;
            color: #1a2332;
            border: 1.5px solid #d1c9be;
            border-radius: 9px;
            padding: 12px;
            font-size: 0.95rem;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: block;
            transition: border-color 0.2s, background 0.2s;
        }

        .btn-register:hover { border-color: #1a2332; background-color: #f5f0eb; }

        .status-msg {
            background-color: #ecfdf5;
            border: 1.5px solid #6ee7b7;
            color: #065f46;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.88rem;
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Connexion</h1>
            <p class="card-subtitle">Accédez à votre espace bibliothèque</p>
        </div>

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
                <label class="form-label" for="email">Adresse email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    class="form-input"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    autofocus
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Mot de passe</label>
                <div class="input-wrapper">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-input"
                        autocomplete="current-password"
                    >
                    <button type="button" class="toggle-password" onclick="toggleVisibility('password', this)" tabindex="-1">
                        <svg id="icon-password" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="remember-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember">
                    Se souvenir de moi
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Mot de passe oublié ?</a>
                @endif
            </div>

            <button type="submit" class="btn-submit">Se connecter</button>

            <div class="divider">ou</div>

            <a href="{{ route('register') }}" class="btn-register">Créer un compte</a>
        </form>
    </div>

    <script>
        function toggleVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon  = btn.querySelector('svg');
            const isHidden = input.type === 'password';

            input.type = isHidden ? 'text' : 'password';

            // oeil ouvert = mot de passe visible, oeil barré = masqué
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