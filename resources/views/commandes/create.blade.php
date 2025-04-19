@extends('layouts.app')

@section('content')
    <!-- SweetAlert2 CSS et JS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.js"></script>

    <div class="container mt-5">
        <!-- Titre et barre de recherche -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-primary"><i class="fas fa-shopping-cart me-2"></i>Nouvelle Commande</h1>

            <div class="col-md-4 mt-3 mt-md-0">
                <input type="text" id="searchInput" class="form-control border rounded-pill shadow-sm"
                       placeholder="🔍 Rechercher par titre ou auteur...">
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('commandes.store') }}" method="POST">
                    @csrf

                    <!-- Client -->
                    <input type="hidden" name="client_id" value="{{ Auth::user()->id }}">

                    <!-- Produits -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary"><i class="fas fa-box"></i> Sélection des Produits</label>
                        <div class="row">
                            @foreach($livres as $livre)
                                <div class="col-md-6 col-lg-4 mb-4 livre-card"
                                     data-titre="{{ $livre->titre }}"
                                     data-auteur="{{ $livre->auteur }}">
                                    <div class="card h-100 border-0 shadow rounded-3">
                                        <div class="card-body text-center">
                                            <img src="{{ asset('storage/' . $livre->image) }}"
                                                 class="img-fluid rounded-3 mb-2"
                                                 alt="{{ $livre->titre }}"
                                                 style="width: 120px; height: 120px; object-fit: cover;">

                                            <h5 class="card-title fw-semibold text-dark">Titre : {{ $livre->titre }}</h5>
                                            <p class="text-muted mb-0">Auteur : {{ $livre->auteur }}</p>
                                            <p class="text-muted mb-0">Stock restant : {{ $livre->stock }}</p>
                                            <p class="text-success fw-bold mb-2">Prix : {{ number_format($livre->prix, 2, ',', ' ') }} XOF</p>

                                            <div class="form-check mb-2">
                                                <input type="checkbox" name="produit_id[]" value="{{ $livre->id }}"
                                                       class="form-check-input" id="produit_{{ $livre->id }}">
                                                <label class="form-check-label" for="produit_{{ $livre->id }}">Choisir</label>
                                            </div>

                                            <div>
                                                <label for="quantite_{{ $livre->id }}" class="form-label small">Quantité</label>
                                                <input type="number" name="quantite[]" id="quantite_{{ $livre->id }}"
                                                       class="form-control form-control-sm rounded-pill" min="1" value="1" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Statut (si gestionnaire) -->
                    @if(Auth::user()->role == 'gestionnaire')
                        <div class="mb-4">
                            <label for="statut" class="form-label fw-bold text-secondary">Statut de la commande</label>
                            <select name="statut" id="statut" class="form-select">
                                <option value="en_attente">En Attente</option>
                                <option value="en_preparation">En Préparation</option>
                                <option value="expediee">Expédiée</option>
                                <option value="payee">Payée</option>
                            </select>
                        </div>
                    @endif

                    <!-- Bouton -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg px-4 rounded-pill shadow-sm">
                            <i class="fas fa-plus me-2"></i>Créer la Commande
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 pour afficher les messages flash --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: "{{ session('success') }}",
                confirmButtonColor: '#28a745',
            });
        </script>
    @elseif(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d33',
            });
        </script>
    @endif

    {{-- SweetAlert2 pour les erreurs de validation --}}
    @if($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur de saisie',
                text: "{{ $errors->first() }}",
                confirmButtonColor: '#d33',
            });
        </script>
    @endif

    <!-- Script pour activer les quantités et filtrage -->
    <script>
        // Activation/désactivation du champ quantité
        document.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                let quantiteInput = document.getElementById('quantite_' + this.value);
                quantiteInput.disabled = !this.checked;
                if (!this.checked) quantiteInput.value = 1;
            });
        });

        // Filtrage des livres par titre ou auteur
        document.getElementById('searchInput').addEventListener('input', function () {
            let query = this.value.toLowerCase();
            document.querySelectorAll('.livre-card').forEach(function (card) {
                let titre  = card.getAttribute('data-titre').toLowerCase();
                let auteur = card.getAttribute('data-auteur').toLowerCase();
                card.style.display = (titre.includes(query) || auteur.includes(query)) ? 'block' : 'none';
            });
        });
    </script>
@endsection
