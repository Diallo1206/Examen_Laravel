@extends('layouts.app')

@section('content')
    <div class="container py-5" style="background: linear-gradient(135deg, #f8f9fa, #e3f2fd); border-radius: 20px;">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="fw-bold text-primary-emphasis">📚 Catalogue des livres</h1>
            @if(Auth::user()->role == 'gestionnaire')
            <a href="{{ route('livres.create') }}" class="btn btn-outline-success rounded-pill px-4 py-2 shadow-sm">➕ Nouveau</a>
            @endif
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-5">
            @foreach($livres as $livre)
                <div class="col">
                    <div class="card h-100 border-0 shadow-lg rounded-5 position-relative bg-white">
                        <img src="{{ asset('storage/' . $livre->image) }}" class="card-img-top rounded-top-5" alt="{{ $livre->titre }}" style="height: 260px; object-fit: cover;">

                        @if($livre->stock < 5)
                            <span class="position-absolute top-0 end-0 m-3 badge rounded-pill bg-danger shadow">🔴 Faible stock</span>
                        @endif

                        <div class="card-body text-center">
                            <h4 class="card-title fw-bold text-dark">📖 {{ $livre->titre }}</h4>
                            <p class="card-text text-muted">✒️ <strong>Auteur :</strong> {{ $livre->auteur }}</p>
                            <p class="text-success fw-semibold fs-5">💵 {{ $livre->prix }} XOF</p>
                            <p class="text-secondary">📦 <strong>Stock :</strong> {{ $livre->stock }}</p>
                        </div>

                        <div class="card-footer d-flex justify-content-around bg-light border-top-0 rounded-bottom-5 py-3">
                            <a href="{{ route('livres.show', $livre) }}" class="btn btn-outline-primary btn-sm rounded-pill">🔍 Détails</a>

                            @if(Auth::user()->role !== 'client')
                                <a href="{{ route('livres.edit', $livre) }}" class="btn btn-outline-warning btn-sm rounded-pill">🖊 Modifier</a>
                                <form action="{{ route('livres.destroy', $livre) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">🗑️ Retirer</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
