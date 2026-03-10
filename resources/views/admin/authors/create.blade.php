<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ajouter un Auteur</h2>
    </x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .page-bg { background-color: #f5f0eb; min-height: 100vh; }
        .form-card { background: #fff; border-radius: 14px; border: 1.5px solid #e5ddd4; padding: 36px 40px; max-width: 520px; margin: 0 auto; }
        .form-title { font-family: 'Playfair Display', serif; font-size: 1.7rem; color: #1a2332; margin-bottom: 6px; }
        .form-subtitle { color: #9ca3af; font-size: 0.88rem; margin-bottom: 28px; }
        .form-label { display: block; font-size: 0.88rem; font-weight: 500; color: #374151; margin-bottom: 6px; }
        .form-input, .form-textarea { width: 100%; border: 1.5px solid #d1c9be; border-radius: 8px; padding: 10px 14px; font-size: 0.95rem; font-family: 'DM Sans', sans-serif; color: #1a2332; background: #faf8f5; outline: none; transition: border 0.2s; box-sizing: border-box; }
        .form-input:focus, .form-textarea:focus { border-color: #1a2332; background: #fff; }
        .form-textarea { resize: vertical; min-height: 90px; }
        .form-group { margin-bottom: 18px; }
        .error-msg { color: #c81e1e; font-size: 0.82rem; margin-top: 5px; }
        .btn-submit { background-color: #1a2332; color: #fff; border: none; border-radius: 8px; padding: 12px 28px; font-size: 0.95rem; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: background 0.2s; }
        .btn-submit:hover { background-color: #2c3e55; }
        .btn-cancel { color: #6b7280; font-size: 0.9rem; text-decoration: none; margin-left: 16px; }
        .btn-cancel:hover { color: #1a2332; }
    </style>

    <div class="page-bg py-10 px-4">
        <div class="form-card">
            <div class="form-title">Nouvel auteur</div>
            <div class="form-subtitle">Remplissez les informations de l'auteur</div>

            <form method="POST" action="{{ route('admin.authors.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nom *</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name') }}">
                    @error('name') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Nationalité</label>
                    <input type="text" name="nationality" class="form-input" value="{{ old('nationality') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Date de naissance</label>
                    <input type="date" name="birth_date" class="form-input" value="{{ old('birth_date') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Biographie</label>
                    <textarea name="biography" class="form-textarea">{{ old('biography') }}</textarea>
                </div>

                <div style="margin-top: 28px;">
                    <button type="submit" class="btn-submit">Ajouter l'auteur</button>
                    <a href="{{ route('admin.authors.index') }}" class="btn-cancel">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>