@extends('layouts.app')

@section('content')
    <div class="container py-5" style="background: linear-gradient(to bottom right, #ffffff, #e9f1f7); border-radius: 15px;">
        <h1 class="fw-bold text-primary mb-4">🛠 Modifier le client : {{ $client->nom }}</h1>

        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <form action="{{ route('clients.update', $client->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="prenom" class="form-label fw-semibold">👤 Prénom</label>
                        <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $client->prenom) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="nom" class="form-label fw-semibold">👨 Nom</label>
                        <input type="text" name="nom" class="form-control" value="{{ old('nom', $client->nom) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">📧 Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $client->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="telephone" class="form-label fw-semibold">📞 Téléphone</label>
                        <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $client->telephone) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="adresse" class="form-label fw-semibold">🏠 Adresse</label>
                        <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $client->adresse) }}" required>
                    </div>

                    <button type="submit" class="btn btn-outline-primary rounded-pill">💾 Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
@endsection
