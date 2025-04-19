@extends('layouts.app')

@section('content')
    <div class="container py-5" style="background: linear-gradient(to top left, #fefefe, #e8f0fe); border-radius: 15px;">
        <h1 class="fw-bold text-primary mb-4">💳 Liste des Paiements</h1>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body">
                <table class="table table-striped table-hover align-middle text-center">
                    <thead class="table-light text-uppercase">
                    <tr>
                        <th>ID</th>
                        <th>Commande</th>
                        <th>Montant (€)</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($paiements as $paiement)
                        <tr>
                            <td><span class="badge bg-primary">{{ $paiement->id }}</span></td>
                            <td>#{{ $paiement->commande->id }}</td>
                            <td class="text-success fw-semibold">{{ number_format($paiement->montant, 2, ',', ' ') }}</td>
                            <td>
                                <span class="badge
                                    @if($paiement->statut === 'validé') bg-success
                                    @elseif($paiement->statut === 'en_attente') bg-warning text-dark
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($paiement->statut) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('paiements.show', $paiement->id) }}" class="btn btn-outline-info btn-sm rounded-pill">🔍 Voir</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
