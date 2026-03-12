<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestion des Membres</h2>
    </x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .page-bg { background-color: #f5f0eb; min-height: 100vh; }
        .section-title { font-family: 'Playfair Display', serif; font-size: 2.2rem; color: #1a2332; letter-spacing: -0.5px; }
        .subtitle { color: #6b7280; font-size: 0.95rem; margin-top: 4px; }

        .row-card {
            background: #fff;
            border-radius: 12px;
            border: 1.5px solid #e5ddd4;
            padding: 18px 24px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: box-shadow 0.2s, opacity 0.35s;
        }
        .row-card:hover { box-shadow: 0 6px 20px rgba(26,35,50,0.08); }
        .row-card.suspended { border-color: #fca5a5; background: #fff8f8; }

        .row-name { font-family: 'Playfair Display', serif; font-size: 1rem; color: #1a2332; font-weight: 600; }
        .row-sub { color: #6b7280; font-size: 0.83rem; margin-top: 3px; }

        .badge-actif   { background: #ecfdf5; color: #065f46; border: 1px solid #6ee7b7; font-size: 0.78rem; font-weight: 600; padding: 3px 12px; border-radius: 20px; }
        .badge-suspendu { background: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; font-size: 0.78rem; font-weight: 600; padding: 3px 12px; border-radius: 20px; }
        .badge-emprunts { background: #f0ebe4; color: #7c6a55; font-size: 0.78rem; font-weight: 500; padding: 3px 12px; border-radius: 20px; }

        .right-block { display: flex; align-items: center; gap: 12px; }

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

        .btn-toggle {
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.82rem;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: background 0.2s, opacity 0.2s;
            font-weight: 500;
        }
        .btn-suspendre  { background: #1a2332; color: #fff; }
        .btn-suspendre:hover { background: #ef4444; }
        .btn-reactiver  { background: #065f46; color: #fff; }
        .btn-reactiver:hover { background: #047857; }
        .btn-toggle:disabled { opacity: 0.4; cursor: not-allowed; }

        .empty-state { text-align: center; padding: 60px 20px; color: #9ca3af; }

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
            box-shadow: 0 8px 24px rgba(26,35,50,0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateX(calc(-100% - 24px));
            opacity: 0;
            visibility: hidden;
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.4s, visibility 0.4s;
        }
        .toast.show { transform: translateX(0); opacity: 1; visibility: visible; }
        .toast.hide { transform: translateX(calc(-100% - 24px)); opacity: 0; visibility: hidden; transition: transform 0.3s ease-in, opacity 0.3s, visibility 0.3s; }
        .toast-success { background: #ecfdf5; border: 1.5px solid #6ee7b7; color: #065f46; }
        .toast-error   { background: #fef2f2; border: 1.5px solid #fca5a5; color: #991b1b; }
        .toast-icon    { width: 18px; height: 18px; flex-shrink: 0; }
    </style>

    <div id="toast" class="toast toast-success">
        <svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" id="toast-icon">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
        <span id="toast-message"></span>
    </div>

    <div class="page-bg py-10 px-4">
        <div style="max-width: 860px; margin: 0 auto;">

            <div style="margin-bottom: 28px; display: flex; justify-content: space-between; align-items: flex-end;">
                <div>
                    <h1 class="section-title">Membres</h1>
                    <p class="subtitle" id="subtitle">{{ $membres->count() }} membre(s) inscrit(s)</p>
                </div>
                <button class="btn-refresh" onclick="actualiser(this)">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                    </svg>
                    Actualiser
                </button>
            </div>

            @if($membres->isEmpty())
                <div class="empty-state"><p>Aucun membre inscrit pour le moment.</p></div>
            @else
                <div id="membres-list">
                @foreach($membres as $membre)
                    <div class="row-card {{ $membre->is_active ? '' : 'suspended' }}" id="card-{{ $membre->id }}">
                        <div>
                            <div class="row-name">{{ $membre->name }}</div>
                            <div class="row-sub">
                                {{ $membre->email }}
                                @if($membre->phone)
                                    &nbsp;—&nbsp; {{ $membre->phone }}
                                @endif
                            </div>
                        </div>
                        <div class="right-block">
                            <span class="badge-emprunts">
                                {{ $membre->current_borrowings }} emprunt(s) en cours
                            </span>
                            <span id="badge-{{ $membre->id }}" class="{{ $membre->is_active ? 'badge-actif' : 'badge-suspendu' }}">
                                {{ $membre->is_active ? 'Actif' : 'Suspendu' }}
                            </span>
                            <button
                                id="btn-{{ $membre->id }}"
                                class="btn-toggle {{ $membre->is_active ? 'btn-suspendre' : 'btn-reactiver' }}"
                                data-id="{{ $membre->id }}"
                                data-url="{{ route('admin.membres.toggle', $membre->id) }}"
                                data-actif="{{ $membre->is_active }}"
                                onclick="toggleMembre(this)"
                            >
                                {{ $membre->is_active ? 'Suspendre' : 'Réactiver' }}
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

        function actualiser(btn) {
            btn.classList.add('spinning');
            setTimeout(() => window.location.reload(), 500);
        }

        function toggleMembre(btn) {
            btn.disabled = true;
            const id  = btn.getAttribute('data-id');
            const url = btn.getAttribute('data-url');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
            .then(r => r.json())
            .then(data => {
                if (data.ok) {
                    const card  = document.getElementById('card-' + id);
                    const badge = document.getElementById('badge-' + id);

                    if (data.is_active) {
                        // compte réactivé
                        card.classList.remove('suspended');
                        badge.className = 'badge-actif';
                        badge.textContent = 'Actif';
                        btn.className = 'btn-toggle btn-suspendre';
                        btn.textContent = 'Suspendre';
                    } else {
                        // compte suspendu
                        card.classList.add('suspended');
                        badge.className = 'badge-suspendu';
                        badge.textContent = 'Suspendu';
                        btn.className = 'btn-toggle btn-reactiver';
                        btn.textContent = 'Réactiver';
                    }

                    showToast(data.message, 'success');
                } else {
                    showToast('Une erreur est survenue.', 'error');
                }
                btn.disabled = false;
            })
            .catch(() => {
                showToast('Une erreur est survenue.', 'error');
                btn.disabled = false;
            });
        }
    </script>

</x-app-layout>