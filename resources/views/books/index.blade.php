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

        .book-card:nth-child(1) { animation-delay: 0.05s; }
        .book-card:nth-child(2) { animation-delay: 0.10s; }
        .book-card:nth-child(3) { animation-delay: 0.15s; }
        .book-card:nth-child(4) { animation-delay: 0.20s; }
        .book-card:nth-child(5) { animation-delay: 0.25s; }
        .book-card:nth-child(6) { animation-delay: 0.30s; }

        /* --- boutons modifier / supprimer --- */
        .card-actions {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 52px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            opacity: 0;
            transform: translateX(10px);
            transition: opacity 0.22s ease, transform 0.22s ease;
            background: linear-gradient(to left, rgba(255,255,255,0.97) 60%, transparent);
            border-radius: 0 12px 12px 0;
            padding-right: 10px;
        }

        .book-card:hover .card-actions {
            opacity: 1;
            transform: translateX(0);
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s, transform 0.15s;
            text-decoration: none;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .btn-edit {
            background-color: #1a2332;
            color: #ffffff;
        }

        .btn-edit:hover {
            background-color: #2c3e55;
        }

        .btn-delete {
            background-color: #1a2332;
            color: #ffffff;
        }

        .btn-delete:hover {
            background-color: #2c3e55;
        }

        /* message flash */
        .flash-success {
            background-color: #ecfdf5;
            border: 1.5px solid #6ee7b7;
            color: #065f46;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
    </style>

    <div class="page-bg py-10 px-4">
        <div style="max-width: 1100px; margin: 0 auto;">

            {{-- message flash --}}
            @if(session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif

            {{-- bouton ajouter visible seulement pour l'admin --}}
            @if(Auth::user()->role == 'admin')
                <div style="text-align: right; margin-bottom: 16px;">
                    <a href="{{ route('books.create') }}" style="background-color: #1a2332; color: #fff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 0.9rem;">
                        ajouter un livre
                    </a>
                </div>
            @endif

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

                            {{-- bouton emprunter — visible seulement pour le client --}}
                            @if(Auth::user()->role == 'client')
                                @if($book->available_copies > 0)
                                    <form method="POST" action="{{ route('borrowings.emprunter', $book->id) }}" style="margin-top: 14px;">
                                        @csrf
                                        <button type="submit" style="background-color: #1a2332; color: #fff; border: none; border-radius: 7px; padding: 7px 16px; font-size: 0.82rem; font-family: 'DM Sans', sans-serif; cursor: pointer;">
                                            Emprunter
                                        </button>
                                    </form>
                                @endif
                            @endif

                            {{-- boutons modifier / supprimer — visibles seulement pour l'admin au hover --}}
                            @if(Auth::user()->role == 'admin')
                                <div class="card-actions">

                                    {{-- bouton modifier (icone crayon) --}}
                                    <a href="{{ route('books.edit', $book->id) }}" class="action-btn btn-edit" title="Modifier">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </a>

                                    {{-- bouton supprimer (icone corbeille) --}}
                                    <form method="POST" action="{{ route('books.destroy', $book->id) }}" onsubmit="return confirm('Supprimer ce livre ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete" title="Supprimer">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                                <path d="M10 11v6"/>
                                                <path d="M14 11v6"/>
                                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

    {{-- script pour la recherche de livre --}}
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