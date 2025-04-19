@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.js"></script>

    <div class="container py-5" style="background: linear-gradient(to top right, #ffffff, #f0f4f8); border-radius: 20px;">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="fw-bold text-primary">🧾 Commande #{{ $commande->id }}</h1>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('commandes.index') }}" class="btn btn-outline-secondary rounded-pill">↩ Retour</a>
            </div>
        </div>

        <div class="card shadow border-0 rounded-4 mb-5">
            <div class="card-body">
                <h4 class="mb-3">
                    👤 <strong>{{ App\Models\User::find($commande->utilisateur_id)->prenom }} {{ App\Models\User::find($commande->utilisateur_id)->nom }}</strong>
                </h4>
                <p><strong>Statut :</strong> <span class="badge bg-info text-dark">{{ ucfirst($commande->statut) }}</span></p>
                <p><strong>Date :</strong> {{ $commande->created_at->format('d M Y, H:i') }}</p>
                <p><strong>Total :</strong> <span class="h5 text-success">{{ number_format($commande->montant_total, 2, ',', ' ') }} XOF</span></p>

                @if(Auth::user()->role === 'gestionnaire')
                    <form action="{{ route('commandes.updateStatut', $commande->id) }}" method="POST" class="mb-4">
                        @csrf
                        @method('PUT')
                        <label class="fw-bold mb-1" for="statut">🛠 Modifier le statut :</label>
                        <div class="input-group">
                            <select name="statut" id="statut" class="form-select">
                                <option value="en_attente" {{ $commande->statut == 'en_attente' ? 'selected' : '' }}>En Attente</option>
                                <option value="en_preparation" {{ $commande->statut == 'en_preparation' ? 'selected' : '' }}>En Préparation</option>
                                <option value="expediee" {{ $commande->statut == 'expediee' ? 'selected' : '' }}>Expédiée</option>
                                <option value="payee" {{ $commande->statut == 'payee' ? 'selected' : '' }}>Payée</option>
                            </select>
                            <button type="submit" class="btn btn-outline-primary">✔ Confirmer</button>
                        </div>
                    </form>

                    @if($commande->statut != 'payee')
                        <form action="{{ route('paiements.store', $commande->id) }}" method="POST" class="mb-4">
                            @csrf
                            <input type="hidden" name="commande_id" value="{{ $commande->id }}">
                            <div class="mb-3">
                                <label class="fw-bold">💳 Méthode de paiement :</label>
                                <input type="text" name="methode_paiement" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">💰 Montant :</label>
                                <input type="number" name="montant" class="form-control" step="0.01" required>
                            </div>
                            <button type="submit" class="btn btn-outline-success rounded-pill">💾 Enregistrer le Paiement</button>
                        </form>
                    @else
                        <p><span class="badge bg-success">✅ Paiement effectué</span></p>
                    @endif
                @endif
            </div>
        </div>

        <h3 class="fw-bold text-secondary mb-4">📚 Livres de la commande</h3>
        <div class="row">
            @foreach($commande->elements as $element)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0 rounded-4 text-center">
                        <div class="card-body">
                            <img src="{{ asset('storage/' . $element->livre->image) }}" alt="{{ $element->livre->titre }}" class="img-fluid rounded mb-3" style="max-height: 180px; object-fit: cover;">
                            <h5 class="card-title">{{ $element->livre->titre }}</h5>
                            <p class="text-muted">{{ $element->livre->auteur }}</p>
                            <p class="fw-bold">🧮 Quantité : {{ $element->quantite }}</p>
                            <p>💵 Prix unitaire : {{ number_format($element->prix, 2, ',', ' ') }} XOF</p>
                            <p><strong>Total :</strong>
                                <span class="text-success">
                            {{ number_format($element->prix * $element->quantite, 2, ',', ' ') }} XOF
                        </span>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>

        @if(Auth::user()->role == 'client' && $commande->statut == 'en_attente')
            <div class="d-flex justify-content-between mt-5">
                <a href="{{ route('commandes.edit', $commande->id) }}" class="btn btn-warning">✏️ Modifier</a>
                <form action="{{ route('commandes.destroy', $commande->id) }}" method="POST" id="delete-form-{{ $commande->id }}" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button type="button" class="btn btn-danger" onclick="confirmDeletion(event, {{ $commande->id }})">🗑️ Annuler</button>
            </div>
        @endif

        @if(Auth::user()->role == 'gestionnaire')
            <div class="d-flex justify-content-between mt-5">
                <a href="{{ route('commandes.edit', $commande->id) }}" class="btn btn-warning">✏️ Modifier</a>
                <form action="{{ route('commandes.destroy', $commande->id) }}" method="POST" id="delete-form-{{ $commande->id }}" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button type="button" class="btn btn-danger" onclick="confirmDeletion(event, {{ $commande->id }})">🗑️ Annuler</button>
            </div>
        @endif
    </div>

    @if(session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Succès', text: "{{ session('success') }}", confirmButtonColor: '#28a745' });
        </script>
    @elseif(session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Erreur', text: "{{ session('error') }}", confirmButtonColor: '#d33' });
        </script>
    @endif

    <script>
        function confirmDeletion(event, id) {
            event.preventDefault();
            Swal.fire({
                title: "Êtes-vous sûr ?",
                text: "Cette action est irréversible !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Oui, supprimer",
                cancelButtonText: "Annuler"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
