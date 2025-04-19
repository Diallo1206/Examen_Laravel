<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SUNU Bibliothèque</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            margin: 0;
        }

        .header {
            background-color: #1e293b;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 1.6rem;
            font-weight: 800;
            color: #38bdf8;
        }

        .nav {
            display: flex;
            gap: 1.5rem;
        }

        .nav a {
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav a:hover {
            color: #38bdf8;
        }

        .hero {
            padding: 6rem 2rem;
            text-align: center;
            background-color: #e2e8f0;
        }

        .hero h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: #0f172a;
        }

        .hero p {
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto 2rem auto;
            color: #475569;
        }

        .hero a {
            background-color: #38bdf8;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 9999px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .hero a:hover {
            background-color: #0ea5e9;
        }

        .footer {
            text-align: center;
            padding: 2rem;
            background-color: #1e293b;
            color: #cbd5e1;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

<header class="header">
    <h1>📚 SUNU Bibliothèque</h1>
    <nav class="nav">
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

<main class="hero">
    <h2>Bienvenue dans l'univers du savoir</h2>
    <p>Explorez notre bibliothèque numérique, découvrez des ouvrages captivants, et vivez une nouvelle expérience de lecture.</p>
    <a href="{{ route('catalogue') }}">Découvrir le catalogue</a>
</main>

{{--<footer class="footer">--}}
{{--    &copy; {{ date('Y') }} SUNU Bibliothèque. Tous droits réservés.--}}
{{--</footer>--}}

</body>
</html>
