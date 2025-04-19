@php
    use Illuminate\Support\Str;
@endphp

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SUNU Bibliothèque</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #f1f5f9;
            margin: 0;
        }

        header {
            background: #0f172a;
            padding: 1.5rem 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        header h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #38bdf8;
        }

        nav a {
            margin-left: 1.5rem;
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #38bdf8;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1);
        }

        .carousel-item {
            padding: 2rem 0;
        }

        .book-card {
            background: #1e293b;
            color: #f1f5f9;
        }

        .book-card h5 {
            color: #38bdf8;
        }

        .btn-action {
            color: #94a3b8;
        }

        .btn-action:hover {
            text-decoration: underline;
            color: #38bdf8;
        }

        footer {
            background: #0f172a;
        }
    </style>
</head>

<body>

<!-- HEADER -->
<header class="flex justify-between items-center">
    <h1>📖 SUNU Bibliothèque</h1>
    <nav class="flex items-center">
        <a href="{{ url('/') }}">Accueil</a>
        <a href="{{ route('catalogue') }}">Catalogue</a>
        @auth
            <a href="{{ url('/dashboard') }}">Dashboard</a>
        @else
            <a href="{{ route('login') }}">Connexion</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}">Inscription</a>
            @endif
        @endauth
    </nav>
</header>

<!-- CONTENU PRINCIPAL -->
<div class="mt-5 px-4">
    <h2 class="text-3xl font-bold text-center mb-6 text-blue-400">📖 À la une : Nos auteurs & leurs livres</h2>
    <p class="text-center text-gray-400 max-w-2xl mx-auto mb-8">
        Découvrez une sélection d'auteurs exceptionnels et leurs livres fascinants. Cliquez sur un livre pour en savoir plus ou explorez notre catalogue pour encore plus de découvertes.
    </p>

    <!-- CARROUSEL -->
    <div id="auteurCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($livres->chunk(3) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="flex justify-center gap-6 flex-wrap">
                        @foreach($chunk as $livre)
                            <div class="book-card shadow-lg rounded-lg w-80 overflow-hidden">
                                <img src="{{ asset('storage/' . $livre->image) }}" alt="{{ $livre->titre }}" class="h-64 w-full object-cover">
                                <div class="p-4">
                                    <h5 class="text-lg font-bold">{{ $livre->titre }}</h5>
                                    <p class="text-sm text-gray-400">✍️ <strong>{{ $livre->auteur }}</strong></p>
                                    <p class="text-sm text-gray-300 mt-2">{{ Str::limit($livre->description, 100) }}</p>
                                    <div class="mt-4 flex justify-between items-center">
                                        <a href="{{ route('livres.show', $livre) }}" class="btn-action text-sm">👁 Voir</a>
                                        @auth
                                            @if(Auth::user()->role == 'gestionnaire')
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('livres.edit', $livre) }}" class="btn-action text-sm">✏️ Modifier</a>
                                                    <form action="{{ route('livres.destroy', $livre) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-action text-sm">🗑 Supprimer</button>
                                                    </form>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- CONTRÔLES DU CARROUSEL -->
        <button class="carousel-control-prev" type="button" data-bs-target="#auteurCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#auteurCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
        </button>
    </div>
</div>

<!-- FOOTER -->
<footer class="text-center py-4 mt-10 shadow-inner">
    <p class="text-sm text-gray-500">© 2025 SUNU Bibliothèque. Tous droits réservés.</p>
</footer>

</body>
</html>
