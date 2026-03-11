<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte — Bibliothèque</title>
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

        .card-subtitle {
            color: #9ca3af;
            font-size: 0.9rem;
            margin-top: 6px;
        }

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

        .form-input:focus {
            border-color: #1a2332;
            background: #fff;
        }

        .error-msg {
            color: #c81e1e;
            font-size: 0.82rem;
            margin-top: 5px;
        }

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
            margin-top: 8px;
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

        .btn-login {
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

        .btn-login:hover {
            border-color: #1a2332;
            background-color: #f5f0eb;
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Créer un compte</h1>
            <p class="card-subtitle">Rejoignez la bibliothèque en tant que membre</p>
        </div>

        @if ($errors->any())
            <div class="form-error-block">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Nom complet</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    class="form-input"
                    value="{{ old('name') }}"
                    autocomplete="name"
                    autofocus
                >
                @error('name') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Adresse email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    class="form-input"
                    value="{{ old('email') }}"
                    autocomplete="email"
                >
                @error('email') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Mot de passe</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-input"
                    autocomplete="new-password"
                >
                @error('password') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirmer le mot de passe</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="form-input"
                    autocomplete="new-password"
                >
            </div>

            <button type="submit" class="btn-submit">Créer mon compte</button>

            <div class="divider">ou</div>

            <a href="{{ route('login') }}" class="btn-login">Se connecter</a>
        </form>
    </div>

</body>
</html>