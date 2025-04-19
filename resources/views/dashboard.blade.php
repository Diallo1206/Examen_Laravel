@extends('layouts.app')

@section('content')
    <div class="bg-gradient-to-r from-teal-50 to-blue-50 py-10">
        <div class="max-w-6xl mx-auto px-5">

            <header class="text-center mb-8">
                <h1 class="text-3xl font-bold text-teal-600">✨ Bienvenue à votre espace personnalisé !</h1>
                <p class="text-gray-500">Découvrez, gérez et analysez facilement votre contenu.</p>
            </header>

            <section class="mb-12">
                <h2 class="text-xl font-semibold text-teal-500 mb-5">📚 Lectures recommandées</h2>
                <div class="flex overflow-x-auto space-x-4 pb-4">
                    @foreach($livres as $livre)
                        <div class="flex-none w-60 bg-white shadow rounded-lg transform hover:-translate-y-2 transition duration-300">
                            <img src="{{ asset('storage/' . $livre->image) }}" class="h-40 w-full object-cover rounded-t-lg">
                            <div class="p-4">
                                <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $livre->titre }}</h3>
                                <p class="text-xs text-gray-400 mb-2">{{ $livre->auteur }}</p>
                                <span class="text-teal-500 font-semibold">{{ $livre->prix }} €</span>
                                <a href="{{ route('livres.show', $livre) }}" class="text-xs text-blue-500 hover:underline block mt-2">Voir détails →</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="grid gap-6 md:grid-cols-2">
                <div class="bg-white rounded-lg shadow p-5">
                    <h3 class="text-lg font-semibold text-teal-600">🛍️ Gestion de vos activités</h3>
                    <p class="text-sm text-gray-500">Accédez rapidement à votre historique personnel.</p>
                    <a href="{{ route('commandes.index') }}" class="text-blue-500 hover:text-blue-700 font-medium mt-3 block">Accéder →</a>
                </div>

                @if(Auth::user()->role == 'gestionnaire')
                    <div class="bg-white rounded-lg shadow p-5">
                        <h3 class="text-lg font-semibold text-teal-600">📊 Analyses & Statistiques</h3>
                        <p class="text-sm text-gray-500">Des outils performants pour piloter efficacement.</p>
                        <a href="{{ route('statistiques.index') }}" class="text-blue-500 hover:text-blue-700 font-medium mt-3 block">Explorer →</a>
                    </div>
                @endif
            </section>

        </div>
    </div>
@endsection
