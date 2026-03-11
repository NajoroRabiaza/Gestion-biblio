<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion des Retours
        </h2>
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

        .stat-label { font-size: 0.8rem; color: #9ca3af; margin-top: 2px; }

        .emprunt-card {
            background: #fff;
            border-radius: 12px;
            border: 1.5px solid #e5ddd4;
            padding: 20px 26px;
            margin-bottom: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: box-shadow 0.2s, opacity 0.4s, transform 0.4s;
        }

        .emprunt-card:hover { box-shadow: 0 6px 20px rgba(26, 35, 50, 0.08); }

        .emprunt-card.en-retard {
            border-left: 4px solid #ef4444;
            background-color: #fff8f8;
        }

        /* animation disparition */
        .emprunt-card.suppression {
            opacity: 0;
            transform: translateX(-20px);
            transition: opacity 0.35s ease, transform 0.35s ease;
        }

        .book-title {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            color: #1a2332;
            font-weight: 600;
        }

        .info-line { color: #6b7280; font-size: 0.85rem; margin-top: 3px; }
        .info-line span { color: #374151; font-weight: 500; }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.78rem;
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 20px;
        }

        .badge-en-cours  { background-color: #eff6ff; color: #1d4ed8; }
        .badge-en-retard { background-color: #fef2f2; color: #991b1b; }

        .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
        .dot-blue { background-color: #3b82f6; }
        .dot-red  { background-color: #ef4444; }

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

        .btn-retour:hover    { background-color: #2c3e55; }
        .btn-retour:disabled { opacity: 0.5; cursor: not-allowed; }

        .right-block { display: flex; flex-direction: column; align-items: flex-end; gap: 10px; }

        .empty-state { text-align: center; padding: 80px 20px; color: #9ca3af; }

        .retard-label { font-size: 0.78rem; color: #991b1b; font-weight: 500; margin-top: 5px; }

        /* toast */
        .toast {
            position: fixed;
            top: 24px;
            left: 24px;
            z-index: 9999;
            padding: 14px 20px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-family: 'DM Sans', sans-serif;
            max-width: 320px;
            box-shadow: 0 8px 24px rgba(26, 35, 50, 0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateX(-120%);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .toast.show { transform: translateX(0); }
        .toast.hide { transform: translateX(-120%); transition: transform 0.3s ease-in; }
        .toast-success { background-color: #ecfdf5; border: 1.5px solid #6ee7b7; color: #065f46; }
        .toast-error   { background-color: #fef2f2; border: 1.5px solid #fca5a5; color: #991b1b; }
        .toast-icon    { width: 18px; height: 18px; flex-shrink: 0; }
    </style>

    {{-- toast --}}
    <div id="toast" class="toast toast-success">
        <svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" id="toast-icon">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
        <span id="toast-message"></span>
    </div>

    <div class="page-bg py-10 px-4">
        <div style="max-width: 960px; margin: 0 auto;">

            <div style="margin-bottom: 28px;">
                <h1 class="section-title">Emprunts en cours</h1>
                <p class="subtitle">Validez les retours de livres rendus par les clients</p>
            </div>

            <div class="stats-bar">
                <div>
                    <div class="stat-number" id="stat-total">{{ $emprunts->count() }}</div>
                    <div class="stat-label">Emprunts actifs</div>
                </div>
                <div>
                    <div class="stat-number" id="stat-retard">{{ $emprunts->where('status', 'en_retard')->count() }}</div>
                    <div class="stat-label">En retard</div>
                </div>
                <div>
                    <div class="stat-number" id="stat-cours">{{ $emprunts->where('status', 'en_cours')->count() }}</div>
                    <div class="stat-label">Dans les délais</div>
                </div>
            </div>

            @if($emprunts->isEmpty())
                <div class="empty-state">
                    <p>Aucun emprunt en cours pour le moment.</p>
                </div>
            @else
                <div id="emprunts-list">
                @foreach($emprunts as $emprunt)
                    <div class="emprunt-card {{ $emprunt->status == 'en_retard' ? 'en-retard' : '' }}" id="card-{{ $emprunt->id }}">

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
                                <div class="retard-label">
                                    En retard de {{ \Carbon\Carbon::parse($emprunt->due_date)->diffInDays(\Carbon\Carbon::today()) }} jour(s)
                                </div>
                            @endif
                        </div>

                        <div class="right-block">
                            @if($emprunt->status == 'en_cours')
                                <span class="badge badge-en-cours">
                                    <span class="dot dot-blue"></span>En cours
                                </span>
                            @else
                                <span class="badge badge-en-retard">
                                    <span class="dot dot-red"></span>En retard
                                </span>
                            @endif

                            <button
                                class="btn-retour"
                                data-id="{{ $emprunt->id }}"
                                data-url="{{ route('admin.emprunts.retour', $emprunt->id) }}"
                                data-status="{{ $emprunt->status }}"
                                onclick="validerRetour(this)"
                            >
                                Valider le retour
                            </button>
                        </div>

                    </div>
                @endforeach
                </div>
            @endif

        </div>
    </div>

    <script>
        let toastTimer = null;

        function showToast(message, type) {
            const toast = document.getElementById('toast');
            const msg   = document.getElementById('toast-message');
            const icon  = document.getElementById('toast-icon');

            msg.textContent = message;
            toast.className = 'toast ' + (type === 'success' ? 'toast-success' : 'toast-error');

            if (type === 'success') {
                icon.innerHTML = '<polyline points="20 6 9 17 4 12"/>';
            } else {
                icon.innerHTML = '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>';
            }

            if (toastTimer) clearTimeout(toastTimer);
            toast.classList.remove('hide');
            toast.classList.add('show');

            toastTimer = setTimeout(() => {
                toast.classList.remove('show');
                toast.classList.add('hide');
            }, 3000);
        }

        function validerRetour(btn) {
            demanderConfirmation('Valider le retour de ce livre ?', 'Valider', function() {

                btn.disabled = true;
                btn.textContent = '...';

                const url    = btn.getAttribute('data-url');
                const id     = btn.getAttribute('data-id');
                const status = btn.getAttribute('data-status');

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');

                        const card = document.getElementById('card-' + id);
                        card.classList.add('suppression');

                        setTimeout(() => {
                            card.remove();

                            const total  = document.getElementById('stat-total');
                            const retard = document.getElementById('stat-retard');
                            const cours  = document.getElementById('stat-cours');

                            total.textContent = Math.max(0, parseInt(total.textContent) - 1);

                            if (status === 'en_retard') {
                                retard.textContent = Math.max(0, parseInt(retard.textContent) - 1);
                            } else {
                                cours.textContent = Math.max(0, parseInt(cours.textContent) - 1);
                            }
                        }, 380);
                    } else {
                        showToast(data.message, 'error');
                        btn.disabled = false;
                        btn.textContent = 'Valider le retour';
                    }
                })
                .catch(() => {
                    showToast('Une erreur est survenue.', 'error');
                    btn.disabled = false;
                    btn.textContent = 'Valider le retour';
                });

            }); // fin demanderConfirmation
        }
    </script>

</x-app-layout>