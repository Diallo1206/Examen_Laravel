@extends('layouts.app')

@section('content')
    <div class="container py-5" style="background: linear-gradient(to right, #fdfbfb, #ebedee); border-radius: 20px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="row g-0">
                        <div class="col-md-5">
                            <img src="{{ asset('storage/' . $livre->image) }}" alt="{{ $livre->titre }}" class="img-fluid rounded-start-4 h-100 object-fit-cover" style="object-fit: cover;">
                        </div>
                        <div class="col-md-7">
                            <div class="card-body p-4">
                                <h2 class="card-title mb-3 text-primary">📖 {{ $livre->titre }}</h2>
                                <p class="card-text text-muted mb-2">✒️ <strong>Auteur :</strong> {{ $livre->auteur }}</p>
                                <p class="card-text text-success mb-2">💵 <strong>Prix :</strong> {{ $livre->prix }} XOF</p>
                                <p class="card-text text-secondary mb-2">📦 <strong>Stock :</strong> {{ $livre->stock }} disponible(s)</p>
                                <p class="card-text text-dark mt-3"><strong>📝 Description :</strong><br>{{ $livre->description }}</p>

                                <a href="{{ route('livres.index') }}" class="btn btn-outline-primary mt-4 rounded-pill">← Retour au catalogue</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
