@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1 class="fw-bold mb-4 text-primary">✏️ Modifier la commande #{{ $commande->id }}</h1>

        <form action="{{ route('commandes.update', $commande->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Client selection -->
            <div class="mb-4">
                <label for="client_id" class="form-label">👤 Client</label>
                <select name="client_id" id="client_id" class="form-select">
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ $client->id == $commande->client_id ? 'selected' : '' }}>
                            {{ $client->prenom }} {{ $client->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Produits et quantités -->
            <div class="mb-4">
                <label class="form-label">📚 Produits commandés</label>
                @foreach($livres as $livre)
                    <div class="d-flex align-items-center mb-2">
                        <input type="checkbox" name="produit_id[]" value="{{ $livre->id }}"
                               {{ in_array($livre->id, $commande->elements->pluck('livre_id')->toArray()) ? 'checked' : '' }} class="form-check-input me-2">
                        <span class="me-3">{{ $livre->titre }} ({{ number_format($livre->prix, 0, ',', ' ') }} XOF)</span>
                        <input type="number" name="quantite[{{ $livre->id }}]" min="1" max="{{ $livre->stock + ($commande->elements->firstWhere('livre_id', $livre->id)?->quantite ?? 0) }}" class="form-control form-control-sm w-auto ms-auto" placeholder="Quantité"
                               value="{{ $commande->elements->firstWhere('livre_id', $livre->id)?->quantite ?? '' }}">
                    </div>
                @endforeach
            </div>

            <!-- Statut de la commande -->
            <div class="mb-4">
                <label for="statut" class="form-label">📦 Statut de la commande</label>
                <select name="statut" id="statut" class="form-select">
                    <option value="en_attente" {{ $commande->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="en_preparation" {{ $commande->statut == 'en_preparation' ? 'selected' : '' }}>En préparation</option>
                    <option value="expediee" {{ $commande->statut == 'expediee' ? 'selected' : '' }}>Expédiée</option>
                    <option value="payee" {{ $commande->statut == 'payee' ? 'selected' : '' }}>Payée</option>
                </select>
            </div>

            <!-- Boutons d'action -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
                <a href="{{ route('commandes.show', $commande->id) }}" class="btn btn-outline-secondary">↩ Retour</a>
            </div>
        </form>
    </div>
@endsection
