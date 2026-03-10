<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes Emprunts
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

        .emprunt-card {
            background: #fff;
            border-radius: 12px;
            border: 1.5px solid #e5ddd4;
            padding: 22px 26px;
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: box-shadow 0.2s;
        }

        .emprunt-card:hover {
            box-shadow: 0 6px 20px rgba(26, 35, 50, 0.08);
        }

        .emprunt-card.en-retard {
            border-left: 4px solid #ef4444;
            background-color: #fff8f8;
        }

        .emprunt-card.retourne {
            opacity: 0.65;
        }

        .book-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            color: #1a2332;
            font-weight: 600;
        }

        .book-author {
            color: #6b7280;
            font-size: 0.85rem;
            margin-top: 2px;
        }

        .date-info {
            font-size: 0.82rem;
            color: #9ca3af;
            margin-top: 8px;
        }

        .date-info span {
            color: #374151;
            font-weight: 500;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.78rem;
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 20px;
        }

        .badge-en-cours {
            background-color: #eff6ff;
            color: #1d4ed8;
        }

        .badge-retourne {
            background-color: #ecfdf5;
            color: #065f46;
        }

        .badge-en-retard {
            background-color: #fef2f2;
            color: #991b1b;
        }

        .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .dot-blue { background-color: #3b82f6; }
        .dot-green { background-color: #10b981; }
        .dot-red { background-color: #ef4444; }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #9ca3af;
        }

        .flash-success {
            background-color: #ecfdf5;
            border: 1.5px solid #6ee7b7;
            color: #065f46;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .flash-error {
            background-color: #fef2f2;
            border: 1.5px solid #fca5a5;
            color: #991b1b;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

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
        .btn-annuler {
            background-color: transparent;
            color: #9ca3af;
            border: 1.5px solid #e5e7eb;
            border-radius: 7px;
            padding: 5px 14px;
            font-size: 0.8rem;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: border-color 0.2s, color 0.2s;
        }

        .btn-annuler:hover {
            border-color: #ef4444;
            color: #ef4444;
        }
    </style>

    <div class="page-bg py-10 px-4">
        <div style="max-width: 900px; margin: 0 auto;">

            {{-- messages flash --}}
            @if(session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="flash-error">{{ session('error') }}</div>
            @endif

            {{-- titre --}}
            <div style="margin-bottom: 28px;">
                <h1 class="section-title">Mes Emprunts</h1>
                <p class="subtitle">Historique de tous vos emprunts</p>
            </div>

            {{-- barre de stats --}}
            <div class="stats-bar">
                <div>
                    <div class="stat-number">{{ $emprunts->count() }}</div>
                    <div class="stat-label">Total emprunts</div>
                </div>
                <div>
                    <div class="stat-number">{{ $emprunts->where('status', 'en_cours')->count() }}</div>
                    <div class="stat-label">En cours</div>
                </div>
                <div>
                    <div class="stat-number">{{ $emprunts->where('status', 'en_retard')->count() }}</div>
                    <div class="stat-label">En retard</div>
                </div>
            </div>

            {{-- liste des emprunts --}}
            @if($emprunts->isEmpty())
                <div class="empty-state">
                    <p>Vous n'avez aucun emprunt pour le moment.</p>
                    <a href="{{ route('books.index') }}" style="display: inline-block; margin-top: 16px; color: #1a2332; font-weight: 500; text-decoration: underline;">
                        Voir le catalogue
                    </a>
                </div>
            @else
                @foreach($emprunts as $emprunt)
                    <div class="emprunt-card {{ $emprunt->status == 'en_retard' ? 'en-retard' : '' }} {{ $emprunt->status == 'retourne' ? 'retourne' : '' }}">

                        <div>
                            <div class="book-title">{{ $emprunt->book->title }}</div>
                            <div class="book-author">par {{ $emprunt->book->author->name }}</div>

                            <div class="date-info">
                                Emprunté le <span>{{ \Carbon\Carbon::parse($emprunt->borrow_date)->format('d/m/Y') }}</span>
                                &nbsp;—&nbsp;
                                Retour prévu le <span>{{ \Carbon\Carbon::parse($emprunt->due_date)->format('d/m/Y') }}</span>

                                @if($emprunt->return_date)
                                    &nbsp;—&nbsp;
                                    Rendu le <span>{{ \Carbon\Carbon::parse($emprunt->return_date)->format('d/m/Y') }}</span>
                                @endif
                            </div>
                        </div>

                        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 10px;">
                            @if($emprunt->status == 'en_cours')
                                <span class="badge badge-en-cours">
                                    <span class="dot dot-blue"></span>
                                    En cours
                                </span>
                            @elseif($emprunt->status == 'en_retard')
                                <span class="badge badge-en-retard">
                                    <span class="dot dot-red"></span>
                                    En retard
                                </span>
                            @else
                                <span class="badge badge-retourne">
                                    <span class="dot dot-green"></span>
                                    Rendu
                                </span>
                            @endif

                            {{-- bouton annuler seulement pour les emprunts en cours --}}
                            @if($emprunt->status == 'en_cours')
                                <form method="POST" action="{{ route('borrowings.annuler', $emprunt->id) }}" onsubmit="return confirm('Annuler cet emprunt ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-annuler">
                                        Annuler
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                @endforeach
            @endif

        </div>
    </div>

</x-app-layout>