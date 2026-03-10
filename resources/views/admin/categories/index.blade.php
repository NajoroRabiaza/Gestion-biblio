<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestion des Catégories</h2>
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
            transition: box-shadow 0.2s, opacity 0.35s, transform 0.35s;
        }
        .row-card:hover { box-shadow: 0 6px 20px rgba(26,35,50,0.08); }
        .row-card.suppression { opacity: 0; transform: translateX(-20px); }

        .row-name { font-family: 'Playfair Display', serif; font-size: 1rem; color: #1a2332; font-weight: 600; }
        .row-sub { color: #6b7280; font-size: 0.83rem; margin-top: 3px; }
        .badge-count { background-color: #f0ebe4; color: #7c6a55; font-size: 0.78rem; font-weight: 500; padding: 3px 12px; border-radius: 20px; }

        .btn-primary { background-color: #1a2332; color: #fff; border: none; border-radius: 8px; padding: 9px 20px; font-size: 0.88rem; font-family: 'DM Sans', sans-serif; cursor: pointer; text-decoration: none; display: inline-block; transition: background 0.2s; }
        .btn-primary:hover { background-color: #2c3e55; }

        .btn-icon-delete {
            background: #1a2332;
            border: none;
            cursor: pointer;
            padding: 7px;
            border-radius: 6px;
            color: #fff;
            transition: background 0.2s;
            display: flex;
            align-items: center;
        }
        .btn-icon-delete:hover { background: #ef4444; }
        .btn-icon-delete:disabled { opacity: 0.4; cursor: not-allowed; }

        .right-block { display: flex; align-items: center; gap: 16px; }
        .empty-state { text-align: center; padding: 60px 20px; color: #9ca3af; }

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
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .toast.show { transform: translateX(0); }
        .toast.hide { transform: translateX(calc(-100% - 24px)); transition: transform 0.3s ease-in; }
        .toast-success { background-color: #ecfdf5; border: 1.5px solid #6ee7b7; color: #065f46; }
        .toast-error   { background-color: #fef2f2; border: 1.5px solid #fca5a5; color: #991b1b; }
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

            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px;">
                <div>
                    <h1 class="section-title">Catégories</h1>
                    <p class="subtitle" id="subtitle">{{ $categories->count() }} catégorie(s) enregistrée(s)</p>
                </div>
                <a href="{{ route('admin.categories.create') }}" class="btn-primary">+ Ajouter une catégorie</a>
            </div>

            @if($categories->isEmpty())
                <div class="empty-state"><p>Aucune catégorie enregistrée pour le moment.</p></div>
            @else
                <div id="categories-list">
                @foreach($categories as $category)
                    <div class="row-card" id="card-{{ $category->id }}">
                        <div>
                            <div class="row-name">{{ $category->name }}</div>
                            @if($category->description)
                                <div class="row-sub">{{ $category->description }}</div>
                            @endif
                        </div>
                        <div class="right-block">
                            <span class="badge-count">{{ $category->books_count }} livre(s)</span>
                            <button
                                class="btn-icon-delete"
                                data-id="{{ $category->id }}"
                                data-url="{{ route('admin.categories.destroy', $category->id) }}"
                                onclick="supprimerCategorie(this)"
                                title="Supprimer"
                            >
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                    <path d="M10 11v6"/>
                                    <path d="M14 11v6"/>
                                    <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                                </svg>
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

        function supprimerCategorie(btn) {
            if (!confirm('Supprimer cette catégorie ?')) return;

            btn.disabled = true;
            const id  = btn.getAttribute('data-id');
            const url = btn.getAttribute('data-url');

            fetch(url, {
                method: 'DELETE',
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
                        const remaining = document.querySelectorAll('[id^="card-"]').length;
                        document.getElementById('subtitle').textContent = remaining + ' catégorie(s) enregistrée(s)';
                    }, 380);
                } else {
                    showToast(data.message, 'error');
                    btn.disabled = false;
                }
            })
            .catch(() => {
                showToast('Une erreur est survenue.', 'error');
                btn.disabled = false;
            });
        }
    </script>

</x-app-layout>