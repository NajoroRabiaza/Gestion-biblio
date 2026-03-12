<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .page-bg { background-color: #f5f0eb; min-height: 100vh; }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: #1a2332;
            letter-spacing: -0.5px;
        }

        .subtitle { color: #6b7280; font-size: 0.95rem; margin-top: 4px; }

        .btn-refresh {
            background: #fff;
            border: 1.5px solid #e5ddd4;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 0.85rem;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            color: #1a2332;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: border-color 0.2s, background 0.2s;
        }
        .btn-refresh:hover { border-color: #1a2332; background: #f5f0eb; }
        .btn-refresh svg { transition: transform 0.5s ease; }
        .btn-refresh.spinning svg { transform: rotate(360deg); }

        /* grille des 4 stats principales */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 36px;
        }

        .stat-card {
            background: #1a2332;
            color: #fff;
            border-radius: 12px;
            padding: 24px 22px;
        }

        .stat-card.warning {
            background: #fef2f2;
            border: 1.5px solid #fca5a5;
            color: #1a2332;
        }

        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-card.warning .stat-number { color: #ef4444; }

        .stat-label {
            font-size: 0.82rem;
            color: #9ca3af;
            margin-top: 6px;
        }

        .stat-card.warning .stat-label { color: #9ca3af; }

        /* les deux colonnes du bas */
        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .panel {
            background: #fff;
            border-radius: 12px;
            border: 1.5px solid #e5ddd4;
            padding: 24px;
        }

        .panel-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            color: #1a2332;
            margin-bottom: 18px;
            font-weight: 600;
        }

        /* top livres */
        .top-book {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0ebe4;
        }

        .top-book:last-child { border-bottom: none; }

        .top-book-rank {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            color: #d1c9be;
            font-weight: 700;
            min-width: 28px;
        }

        .top-book-title {
            font-size: 0.92rem;
            color: #1a2332;
            font-weight: 500;
            flex: 1;
            padding: 0 12px;
        }

        .top-book-count {
            background-color: #f0ebe4;
            color: #7c6a55;
            font-size: 0.78rem;
            font-weight: 500;
            padding: 3px 12px;
            border-radius: 20px;
            white-space: nowrap;
        }

        /* derniers emprunts */
        .emprunt-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 11px 0;
            border-bottom: 1px solid #f0ebe4;
        }

        .emprunt-row:last-child { border-bottom: none; }

        .emprunt-book { font-size: 0.9rem; color: #1a2332; font-weight: 500; }
        .emprunt-user { font-size: 0.82rem; color: #9ca3af; margin-top: 2px; }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 3px 10px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .badge-en-cours  { background-color: #eff6ff; color: #1d4ed8; }
        .badge-en-retard { background-color: #fef2f2; color: #991b1b; }
        .badge-retourne  { background-color: #ecfdf5; color: #065f46; }

        .dot { width: 5px; height: 5px; border-radius: 50%; display: inline-block; }
        .dot-blue  { background-color: #3b82f6; }
        .dot-red   { background-color: #ef4444; }
        .dot-green { background-color: #10b981; }

        /* liens rapides */
        .quick-links {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 28px;
        }

        .quick-link {
            background: #fff;
            border: 1.5px solid #e5ddd4;
            border-radius: 10px;
            padding: 14px 16px;
            text-decoration: none;
            color: #1a2332;
            font-size: 0.88rem;
            font-weight: 500;
            text-align: center;
            transition: box-shadow 0.2s, border-color 0.2s;
        }

        .quick-link:hover {
            box-shadow: 0 4px 14px rgba(26,35,50,0.1);
            border-color: #1a2332;
        }

        @media (max-width: 768px) {
            .stats-grid    { grid-template-columns: repeat(2, 1fr); }
            .bottom-grid   { grid-template-columns: 1fr; }
            .quick-links   { grid-template-columns: repeat(2, 1fr); }
        }
    </style>

    <div class="page-bg py-10 px-4">
        <div style="max-width: 1060px; margin: 0 auto;">

            <div style="margin-bottom: 28px; display: flex; justify-content: space-between; align-items: flex-end;">
                <div>
                    <h1 class="section-title">Tableau de bord</h1>
                    <p class="subtitle">Vue d'ensemble de la bibliothèque</p>
                </div>
                <button class="btn-refresh" onclick="this.classList.add('spinning'); setTimeout(() => window.location.reload(), 500)">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                    </svg>
                    Actualiser
                </button>
            </div>

            {{-- 4 stats principales --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $totalLivres }}</div>
                    <div class="stat-label">Livres au catalogue</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $totalMembres }}</div>
                    <div class="stat-label">Membres inscrits</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $empruntsActifs }}</div>
                    <div class="stat-label">Emprunts en cours</div>
                </div>
                <div class="stat-card {{ $empruntsRetard > 0 ? 'warning' : '' }}">
                    <div class="stat-number">{{ $empruntsRetard }}</div>
                    <div class="stat-label">Emprunts en retard</div>
                </div>
            </div>

            {{-- liens rapides --}}
            <div class="quick-links">
                <a href="{{ route('books.index') }}" class="quick-link">Catalogue</a>
                <a href="{{ route('admin.emprunts') }}" class="quick-link">Retours</a>
                <a href="{{ route('admin.authors.index') }}" class="quick-link">Auteurs</a>
                <a href="{{ route('admin.categories.index') }}" class="quick-link">Catégories</a>
            </div>

            {{-- top livres + derniers emprunts --}}
            <div class="bottom-grid">

                {{-- top 3 livres --}}
                <div class="panel">
                    <div class="panel-title">Top 3 livres les plus empruntés</div>

                    @forelse($topLivres as $i => $livre)
                        <div class="top-book">
                            <span class="top-book-rank">{{ $i + 1 }}</span>
                            <span class="top-book-title">{{ $livre->title }}</span>
                            <span class="top-book-count">{{ $livre->borrowings_count }} emprunt(s)</span>
                        </div>
                    @empty
                        <p style="color:#9ca3af;font-size:0.88rem;">Aucun emprunt enregistré.</p>
                    @endforelse
                </div>

                {{-- 5 derniers emprunts --}}
                <div class="panel">
                    <div class="panel-title">Derniers emprunts</div>

                    @forelse($derniersEmprunts as $emprunt)
                        <div class="emprunt-row">
                            <div>
                                <div class="emprunt-book">{{ $emprunt->book->title }}</div>
                                <div class="emprunt-user">{{ $emprunt->user->name }}</div>
                            </div>

                            @if($emprunt->status == 'en_cours')
                                <span class="badge badge-en-cours">
                                    <span class="dot dot-blue"></span>En cours
                                </span>
                            @elseif($emprunt->status == 'en_retard')
                                <span class="badge badge-en-retard">
                                    <span class="dot dot-red"></span>En retard
                                </span>
                            @else
                                <span class="badge badge-retourne">
                                    <span class="dot dot-green"></span>Rendu
                                </span>
                            @endif
                        </div>
                    @empty
                        <p style="color:#9ca3af;font-size:0.88rem;">Aucun emprunt enregistré.</p>
                    @endforelse
                </div>

            </div>

        </div>
    </div>

</x-app-layout>