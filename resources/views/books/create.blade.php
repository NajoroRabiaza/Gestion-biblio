<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajouter un livre
        </h2>
    </x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'DM Sans', sans-serif; }

        .page-bg {
            background-color: #f5f0eb;
            min-height: 100vh;
            padding: 40px 16px;
        }

        .form-card {
            background: #fff;
            border-radius: 12px;
            border: 1.5px solid #e5ddd4;
            padding: 36px;
            max-width: 600px;
            margin: 0 auto;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: #1a2332;
            margin-bottom: 6px;
        }

        .page-subtitle {
            color: #9ca3af;
            font-size: 0.9rem;
            margin-bottom: 28px;
        }

        .form-label {
            display: block;
            font-size: 0.88rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            border: 1.5px solid #d1c9be;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.93rem;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border 0.2s;
            box-sizing: border-box;
        }

        .form-input:focus {
            border-color: #1a2332;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-submit {
            background-color: #1a2332;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 28px;
            font-size: 0.95rem;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background-color: #2d3f57;
        }

        .btn-back {
            color: #6b7280;
            font-size: 0.88rem;
            text-decoration: none;
            margin-left: 16px;
        }

        .btn-back:hover {
            color: #1a2332;
        }

        .error-msg {
            color: #dc2626;
            font-size: 0.82rem;
            margin-top: 4px;
        }

        .success-msg {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #6ee7b7;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
    </style>

    <div class="page-bg">
        <div class="form-card">
            <h1 class="page-title">Nouveau livre</h1>
            <p class="page-subtitle">Remplissez les infos du livre à ajouter dans le catalogue</p>
            {{-- message de succès --}}
            @if(session('success'))
                <div class="success-msg">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('books.store') }}">
                @csrf
                {{-- titre --}}
                <div class="form-group">
                    <label class="form-label">titre *</label>
                    <input type="text" name="title" class="form-input" value="{{ old('title') }}" placeholder="ex: Les Misérables">
                    @error('title')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- isbn --}}
                <div class="form-group">
                    <label class="form-label">ISBN (optionnel)</label>
                    <input type="text" name="isbn" class="form-input" value="{{ old('isbn') }}" placeholder="ex: 978-3-16-148410-0">
                </div>
                {{-- auteur --}}
                <div class="form-group">
                    <label class="form-label">auteur *</label>
                    <select name="author_id" class="form-input">
                        <option value="">qui est l'auteur ?</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('author_id')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- categorie --}}
                <div class="form-group">
                    <label class="form-label">catégorie *</label>
                    <select name="category_id" class="form-input">
                        <option value="">quel catégorie?</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- nombre d'exemplaires --}}
                <div class="form-group">
                    <label class="form-label">combien d'exemplaires ?</label>
                    <input type="number" name="total_copies" class="form-input" value="{{ old('total_copies', 1) }}" min="1">
                    @error('total_copies')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                <div style="margin-top: 28px;">
                    <button type="submit" class="btn-submit">ajouter le livre</button>
                    <a href="{{ route('books.index') }}" class="btn-back">annuler</a>
                </div>

            </form>
        </div>
    </div>

</x-app-layout>