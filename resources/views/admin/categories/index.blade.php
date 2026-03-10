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
        .flash-success { background-color: #ecfdf5; border: 1.5px solid #6ee7b7; color: #065f46; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; }
        .flash-error { background-color: #fef2f2; border: 1.5px solid #fca5a5; color: #991b1b; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; }
        .row-card { background: #fff; border-radius: 12px; border: 1.5px solid #e5ddd4; padding: 18px 24px; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center; transition: box-shadow 0.2s; }
        .row-card:hover { box-shadow: 0 6px 20px rgba(26,35,50,0.08); }
        .row-name { font-family: 'Playfair Display', serif; font-size: 1rem; color: #1a2332; font-weight: 600; }
        .row-sub { color: #6b7280; font-size: 0.83rem; margin-top: 3px; }
        .badge-count { background-color: #f0ebe4; color: #7c6a55; font-size: 0.78rem; font-weight: 500; padding: 3px 12px; border-radius: 20px; }
        .btn-primary { background-color: #1a2332; color: #fff; border: none; border-radius: 8px; padding: 9px 20px; font-size: 0.88rem; font-family: 'DM Sans', sans-serif; cursor: pointer; text-decoration: none; display: inline-block; transition: background 0.2s; }
        .btn-primary:hover { background-color: #2c3e55; }
        .btn-danger { background-color: transparent; color: #9ca3af; border: 1.5px solid #e5e7eb; border-radius: 7px; padding: 5px 14px; font-size: 0.8rem; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: border-color 0.2s, color 0.2s; }
        .btn-danger:hover { border-color: #ef4444; color: #ef4444; }
        .empty-state { text-align: center; padding: 60px 20px; color: #9ca3af; }
        .right-block { display: flex; align-items: center; gap: 16px; }
    </style>

    <div class="page-bg py-10 px-4">
        <div style="max-width: 860px; margin: 0 auto;">

            @if(session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="flash-error">{{ session('error') }}</div>
            @endif

            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px;">
                <div>
                    <h1 class="section-title">Catégories</h1>
                    <p class="subtitle">{{ $categories->count() }} catégorie(s) enregistrée(s)</p>
                </div>
                <a href="{{ route('admin.categories.create') }}" class="btn-primary">+ Ajouter une catégorie</a>
            </div>

            @if($categories->isEmpty())
                <div class="empty-state"><p>Aucune catégorie enregistrée pour le moment.</p></div>
            @else
                @foreach($categories as $category)
                    <div class="row-card">
                        <div>
                            <div class="row-name">{{ $category->name }}</div>
                            @if($category->description)
                                <div class="row-sub">{{ $category->description }}</div>
                            @endif
                        </div>
                        <div class="right-block">
                            <span class="badge-count">{{ $category->books_count }} livre(s)</span>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</x-app-layout>