@extends('layouts.app')

@section('content')
    <div class="container py-5" style="background: linear-gradient(to bottom right, #ffffff, #edf2fa); border-radius: 15px;">
        <h1 class="fw-bold text-primary mb-4">💳 Détails du Paiement</h1>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <p><strong>🆔 ID :</strong> {{ $paiement->id }}</p>
                <p><strong>📦 Commande liée :</strong> #{{ $paiement->commande->id }}</p>
                <p><strong>💰 Montant :</strong> <span class="text-success fw-semibold">{{ number_format($paiement->montant, 2, ',', ' ') }} €</span></p>
                <p><strong>📌 Statut :</strong>
                    <span class="badge
                    @if($paiement->statut === 'validé') bg-success
                    @elseif($paiement->statut === 'en_attente') bg-warning text-dark
                    @else bg-secondary
                    @endif">
                    {{ ucfirst($paiement->statut) }}
                </span>
                </p>
                <a href="{{ route('paiements.index') }}" class="btn btn-outline-primary rounded-pill mt-3">↩ Retour à la liste</a>
            </div>
        </div>
    </div>
@endsection
