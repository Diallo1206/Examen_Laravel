@extends('layouts.app')

@section('content')
    <div class="container py-5" style="background: linear-gradient(135deg, #ffffff, #f0f4f8); border-radius: 15px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary fw-bold">📦 Commandes</h1>
            @auth
                @if(Auth::user()->role == 'client')
                    <a href="{{ route('commandes.create') }}" class="btn btn-outline-primary rounded-pill px-4">➕ Nouvelle Commande</a>
                @endif
            @endauth
        </div>

        @auth
            @foreach($commandes->groupBy('utilisateur_id') as $utilisateurId => $userCommandes)
                @php $client = $userCommandes->first()->client; @endphp

                @if(Auth::user()->role == 'gestionnaire' || Auth::user()->id == $client->id)
                    <div class="mb-5">
                        <h4 class="mb-3">🧑‍💼 Commandes de <strong>{{ $client->prenom }} {{ $client->nom }}</strong></h4>
                        <div class="row g-4">
                            @foreach($userCommandes as $commande)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 shadow-sm border-0 rounded-4">
                                        <div class="card-body">
                                            <h5 class="card-title text-secondary-emphasis">🧾 Commande #{{ $commande->id }}</h5>
                                            <p class="mb-1"><strong>Client :</strong> {{ $commande->client->prenom }} {{ $commande->client->nom }}</p>
                                            <p class="mb-2">
                                                <strong>Statut :</strong>
                                                <span class="badge
                                                @if($commande->statut == 'En cours') bg-warning text-dark
                                                @elseif($commande->statut == 'Livrée') bg-success
                                                @else bg-secondary
                                                @endif">
                                                {{ $commande->statut }}
                                            </span>
                                            </p>
                                            <div class="text-end">
                                                <a href="{{ route('commandes.show', $commande->id) }}" class="btn btn-outline-info btn-sm rounded-pill">🔍 Voir</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <div class="alert alert-warning text-center">
                ⚠️ Veuillez vous connecter pour consulter vos commandes.
            </div>
        @endauth
    </div>
@endsection
