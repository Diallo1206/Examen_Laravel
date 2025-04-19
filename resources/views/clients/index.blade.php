@extends('layouts.app')

@section('content')
    <div class="container py-5" style="background: linear-gradient(to top left, #ffffff, #e3f2fd); border-radius: 15px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-primary">👥 Liste des Clients</h1>
            <a href="{{ route('clients.create') }}" class="btn btn-outline-success rounded-pill">
                <i class="bi bi-person-plus"></i> Ajouter un Client
            </a>
        </div>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light text-uppercase">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clients as $index => $client)
                        <tr>
                            <td><span class="badge bg-primary">{{ $index + 1 }}</span></td>
                            <td>{{ $client->nom }}</td>
                            <td>{{ $client->prenom }}</td>
                            <td>{{ $client->telephone }}</td>
                            <td>{{ $client->adresse }}</td>
                            <td>{{ $client->email }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-outline-warning rounded-pill">
                                        ✏️
                                    </a>
                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
