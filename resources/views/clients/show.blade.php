@extends('layouts.app')

@section('content')
    <div class="container py-5" style="background: linear-gradient(to right, #ffffff, #eef2f7); border-radius: 15px;">
        <div class="row mb-4">
            <div class="col-md-12">
                <h1 class="fw-bold text-primary">👤 Détails du Client</h1>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-body">
                <p><strong>🆔 ID :</strong> {{ $client->id }}</p>
                <p><strong>👨 Nom :</strong> {{ $client->nom }}</p>
                <p><strong>👩 Prénom :</strong> {{ $client->prenom }}</p>
                <p><strong>📞 Téléphone :</strong> {{ $client->telephone }}</p>
                <p><strong>🏠 Adresse :</strong> {{ $client->adresse }}</p>
                <p><strong>📧 Email :</strong> {{ $client->email }}</p>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">📦 Commandes associées</h5>
            </div>
            <div class="card-body">
                @if($client->commandes->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($client->commandes as $commande)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>🧾 Commande #{{ $commande->id }}</span>
                                <span class="badge
                                @if($commande->statut == 'en_attente') bg-warning text-dark
                                @elseif($commande->statut == 'payee') bg-success
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($commande->statut) }}
                            </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Ce client n'a effectué aucune commande.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
