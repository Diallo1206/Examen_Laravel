@extends('layouts.app')

@section('content')
    <h1>Modifier la Commande</h1>
    <form action="{{ route('commandes.update', $commande->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="client_id">Client</label>
            <select name="client_id" id="client_id" class="form-control">
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" @if($client->id == $commande->client_id) selected @endif>{{ $client->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="produit_id">Produit</label>
            <select name="produit_id[]" id="produit_id" class="form-control" multiple>
                @foreach($livres as $livre)
                    <option value="{{ $livre->id }}" @if(in_array($livre->id, $commande->produits->pluck('id')->toArray())) selected @endif>{{ $livre->titre }} - {{ $livre->prix }}XOF</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="statut">Statut de la commande</label>
            <select name="statut" id="statut" class="form-control">
                <option value="en_attente" @if($commande->statut == 'en_attente') selected @endif>En Attente</option>
                <option value="en_preparation" @if($commande->statut == 'en_preparation') selected @endif>En Préparation</option>
                <option value="expediee" @if($commande->statut == 'expediee') selected @endif>Expédiée</option>
                <option value="payee" @if($commande->statut == 'payee') selected @endif>Payée</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour la Commande</button>
    </form>
@endsection
