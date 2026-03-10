<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion des Retours
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

        .emprunt-card {
            background: #fff;
            border-radius: 12px;
            border: 1.5px solid #e5ddd4;
            padding: 20px 26px;
            margin-bottom: 14px;
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

        .book-title {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            color: #1a2332;
            font-weight: 600;
        }

        .info-line {
            color: #6b7280;
            font-size: 0.85rem;
            margin-top: 3px;
        }

        .info-line span {
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

        .dot-blue  { background-color: #3b82f6; }
        .dot-red   { background-color: #ef4444; }

        .btn-retour {
            background-color: #1a2332;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 18px;
            font-size: 0.85rem;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: background 0.2s;
            white-space: nowrap;
        }

        .btn-retour:hover {
            background-color: #2c3e55;
        }

        .right-block {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
        }

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

        .retard-label {
            font-size: 0.78rem;
            color: #991b1b;
            font-weight: 500;
        }
    </style>

    <div class="page-bg py-10 px-4">
        <div style="max-width: 960px; margin: 0 auto;">

            @if(session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif

            <div style="margin-bottom: 28px;">
                <h1 class="section-title">Emprunts en cours</h1>
                <p class="subtitle">Validez les retours de livres rendus par les clients</p>
            </div>

            {{-- stats --}}
            <div class="stats-bar">
                <div>
                    <div class="stat-number">{{ $emprunts->count() }}</div>
                    <div class="stat-label">Emprunts actifs</div>
                </div>
                <div>
                    <div class="stat-number">{{ $emprunts->where('status', 'en_retard')->count() }}</div>
                    <div class="stat-label">En retard</div>
                </div>
                <div>
                    <div class="stat-number">{{ $emprunts->where('status', 'en_cours')->count() }}</div>
                    <div class="stat-label">Dans les délais</div>
                </div>
            </div>

            {{-- liste --}}
            @if($emprunts->isEmpty())
                <div class="empty-state">
                    <p>Aucun emprunt en cours pour le moment.</p>
                </div>
            @else
                @foreach($emprunts as $emprunt)
                    <div class="emprunt-card {{ $emprunt->status == 'en_retard' ? 'en-retard' : '' }}">

                        <div>
                            <div class="book-title">{{ $emprunt->book->title }}</div>

                            <div class="info-line">
                                Client : <span>{{ $emprunt->user->name }}</span>
                                &nbsp;—&nbsp;
                                Email : <span>{{ $emprunt->user->email }}</span>
                            </div>

                            <div class="info-line">
                                Emprunté le <span>{{ \Carbon\Carbon::parse($emprunt->borrow_date)->format('d/m/Y') }}</span>
                                &nbsp;—&nbsp;
                                Retour prévu le <span>{{ \Carbon\Carbon::parse($emprunt->due_date)->format('d/m/Y') }}</span>
                            </div>

                            @if($emprunt->status == 'en_retard')
                                <div class="retard-label" style="margin-top: 5px;">
                                    En retard de {{ \Carbon\Carbon::parse($emprunt->due_date)->diffInDays(\Carbon\Carbon::today()) }} jour(s)
                                </div>
                            @endif
                        </div>

                        <div class="right-block">
                            @if($emprunt->status == 'en_cours')
                                <span class="badge badge-en-cours">
                                    <span class="dot dot-blue"></span>
                                    En cours
                                </span>
                            @else
                                <span class="badge badge-en-retard">
                                    <span class="dot dot-red"></span>
                                    En retard
                                </span>
                            @endif

                            {{-- bouton valider le retour --}}
                            <form method="POST" action="{{ route('admin.emprunts.retour', $emprunt->id) }}" onsubmit="return confirm('Valider le retour de ce livre ?')">
                                @csrf
                                <button type="submit" class="btn-retour">
                                    Valider le retour
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            @endif

        </div>
    </div>

</x-app-layout>