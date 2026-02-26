<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Catalogue des livres
        </h2>
    </x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'DM Sans', sans-serif; }

        .page-bg {
            background-color: #f5f0eb;
            min-height: 100vh;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: #1a2332;
            letter-spacing: -0.5px;
        }

        .subtitle {
            color: #6b7280;
            font-size: 0.95rem;
            margin-top: 4px;
        }

        .search-bar {
            background: #fff;
            border: 1.5px solid #d1c9be;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 0.95rem;
            width: 280px;
            outline: none;
            transition: border 0.2s;
            font-family: 'DM Sans', sans-serif;
        }

        .search-bar:focus {
            border-color: #1a2332;
        }

        .book-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            border: 1.5px solid #e5ddd4;
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
            overflow: hidden;
        }

        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(26, 35, 50, 0.1);
        }

        .book-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: #1a2332;
            border-radius: 12px 0 0 12px;
        }

        .book-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            color: #1a2332;
            font-weight: 600;
            line-height: 1.3;
        }

        .book-author {
            color: #6b7280;
            font-size: 0.88rem;
            margin-top: 4px;
        }

        .badge-category {
            display: inline-block;
            background-color: #f0ebe4;
            color: #7c6a55;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 3px 10px;
            border-radius: 20px;
            margin-top: 12px;
        }

        .available-yes {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background-color: #ecfdf5;
            color: #065f46;
            font-size: 0.78rem;
            font-weight: 500;
            padding: 3px 10px;
            border-radius: 20px;
            margin-left: 6px;
        }

        .available-no {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background-color: #fef2f2;
            color: #991b1b;
            font-size: 0.78rem;
            font-weight: 500;
            padding: 3px 10px;
            border-radius: 20px;
            margin-left: 6px;
        }

        .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .dot-green { background-color: #10b981; }
        .dot-red { background-color: #ef4444; }

        .stats-bar {
            background: #1a2332;
            color: #fff;
            border-radius: 12px;
            padding: 20px 28px;
            display: flex;
            gap: 40px;
            margin-bottom: 32px;
        }

        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #9ca3af;
            margin-top: 2px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #9ca3af;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .book-card {
            animation: fadeUp 0.4s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* petit délai pour chaque carte sur l'animation */
        .book-card:nth-child(1) { animation-delay: 0.05s; }
        .book-card:nth-child(2) { animation-delay: 0.10s; }
        .book-card:nth-child(3) { animation-delay: 0.15s; }
        .book-card:nth-child(4) { animation-delay: 0.20s; }
        .book-card:nth-child(5) { animation-delay: 0.25s; }
        .book-card:nth-child(6) { animation-delay: 0.30s; }
    </style>

    <div class="page-bg py-10 px-4">
        <div style="max-width: 1100px; margin: 0 auto;">

            {{-- titre + recherche --}}
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px;">
                <div>
                    <h1 class="section-title">Catalogue</h1>
                    <p class="subtitle">Tous les livres disponibles dans la bibliothèque</p>
                </div>
                <input
                    type="text"
                    class="search-bar"
                    id="searchInput"
                    placeholder="Rechercher un livre..."
                    onkeyup="filterBooks()"
                >
            </div>

            {{-- barre de stats --}}
            <div class="stats-bar">
                <div>
                    <div class="stat-number">{{ $books->count() }}</div>
                    <div class="stat-label">Livres au total</div>
                </div>
                <div>
                    <div class="stat-number">{{ $books->where('available_copies', '>', 0)->count() }}</div>
                    <div class="stat-label">Disponibles</div>
                </div>
                <div>
                    <div class="stat-number">{{ $books->sum('available_copies') }}</div>
                    <div class="stat-label">Exemplaires libres</div>
                </div>
            </div>

            {{-- liste des livres --}}
            @if($books->isEmpty())
                <div class="empty-state">
                    <p>Aucun livre disponible pour le moment</p>
                </div>
            @else
                <div class="books-grid" id="booksGrid">
                    @foreach($books as $book)
                        <div class="book-card" data-title="{{ strtolower($book->title) }}" data-author="{{ strtolower($book->author->name) }}">

                            <div class="book-title">{{ $book->title }}</div>
                            <div class="book-author">par {{ $book->author->name }}</div>

                            <div style="margin-top: 14px;">
                                <span class="badge-category">{{ $book->category->name }}</span>

                                @if($book->available_copies > 0)
                                    <span class="available-yes">
                                        <span class="dot dot-green"></span>
                                        {{ $book->available_copies }} dispo
                                    </span>
                                @else
                                    <span class="available-no">
                                        <span class="dot dot-red"></span>
                                        Indisponible
                                    </span>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

    {{-- script pour la recherche de livre--}}
    <script>
        function filterBooks() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.book-card');

            cards.forEach(card => {
                const title = card.getAttribute('data-title');
                const author = card.getAttribute('data-author');
                if (title.includes(input) || author.includes(input)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>

</x-app-layout>