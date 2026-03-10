<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier un livre
        </h2>
    </x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'DM Sans', sans-serif; }

        .page-bg {
            background-color: #f5f0eb;
            min-height: 100vh;
        }

        .form-card {
            background: #fff;
            border-radius: 14px;
            border: 1.5px solid #e5ddd4;
            padding: 36px 40px;
            max-width: 560px;
            margin: 0 auto;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.7rem;
            color: #1a2332;
            margin-bottom: 6px;
        }

        .form-subtitle {
            color: #9ca3af;
            font-size: 0.88rem;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.88rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-input, .form-select {
            width: 100%;
            border: 1.5px solid #d1c9be;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.95rem;
            font-family: 'DM Sans', sans-serif;
            color: #1a2332;
            background: #faf8f5;
            outline: none;
            transition: border 0.2s;
            box-sizing: border-box;
        }

        .form-input:focus, .form-select:focus {
            border-color: #1a2332;
            background: #fff;
        }

        .error-msg {
            color: #c81e1e;
            font-size: 0.82rem;
            margin-top: 5px;
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
            background-color: #2c3e55;
        }

        .btn-cancel {
            color: #6b7280;
            font-size: 0.9rem;
            text-decoration: none;
            margin-left: 16px;
        }

        .btn-cancel:hover {
            color: #1a2332;
        }
    </style>

    <div class="page-bg py-10 px-4">
        <div class="form-card">

            <div class="form-title">Modifier le livre</div>
            <div class="form-subtitle">Modifiez les informations du livre ci-dessous</div>

            <form method="POST" action="{{ route('books.update', $book->id) }}">
                @csrf
                @method('PUT')

                {{-- titre --}}
                <div class="form-group">
                    <label class="form-label">Titre *</label>
                    <input type="text" name="title" class="form-input" value="{{ old('title', $book->title) }}">
                    @error('title')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- isbn --}}
                <div class="form-group">
                    <label class="form-label">ISBN (optionnel)</label>
                    <input type="text" name="isbn" class="form-input" value="{{ old('isbn', $book->isbn) }}">
                </div>

                {{-- auteur --}}
                <div class="form-group">
                    <label class="form-label">Auteur *</label>
                    <select name="author_id" class="form-select">
                        <option value="">-- Choisir un auteur --</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('author_id')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- catégorie --}}
                <div class="form-group">
                    <label class="form-label">Catégorie *</label>
                    <select name="category_id" class="form-select">
                        <option value="">-- Choisir une catégorie --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
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
                    <label class="form-label">Nombre d'exemplaires *</label>
                    <input type="number" name="total_copies" class="form-input" min="1" value="{{ old('total_copies', $book->total_copies) }}">
                    @error('total_copies')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-top: 28px;">
                    <button type="submit" class="btn-submit">Enregistrer les modifications</button>
                    <a href="{{ route('books.index') }}" class="btn-cancel">Annuler</a>
                </div>

            </form>
        </div>
    </div>

</x-app-layout>