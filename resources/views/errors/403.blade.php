<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès refusé</title>
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
            padding: 56px 48px;
            width: 100%;
            max-width: 420px;
            text-align: center;
            box-shadow: 0 8px 40px rgba(26, 35, 50, 0.07);
        }

        .code {
            font-family: 'Playfair Display', serif;
            font-size: 5rem;
            font-weight: 700;
            color: #1a2332;
            line-height: 1;
            margin-bottom: 16px;
        }

        .title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            color: #1a2332;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #9ca3af;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 36px;
        }

        .btn {
            display: inline-block;
            background-color: #1a2332;
            color: #fff;
            border: none;
            border-radius: 9px;
            padding: 12px 32px;
            font-size: 0.95rem;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
        }

        .btn:hover { background-color: #2c3e55; }
    </style>
</head>
<body>
    <div class="card">
        <div class="code">403</div>
        <div class="title">Accès refusé</div>
        <p class="subtitle">Vous n'avez pas la permission d'accéder à cette page.</p>
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('books.index') }}" class="btn">
            Retourner en arrière
        </a>
    </div>
</body>
</html>