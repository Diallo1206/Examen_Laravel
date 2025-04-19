@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4 text-center">📊 Tableau de bord - Statistiques du jour</h1>

        <div class="row g-4">
            <!-- ✅ Recettes -->
            <div class="col-md-4">
                <div class="card text-white bg-success shadow">
                    <div class="card-body">
                        <h5 class="card-title">💰 Recettes du jour</h5>
                        <p class="display-6">{{ number_format($recettes, 2, ',', ' ') }} XOF</p>
                    </div>
                </div>
            </div>

            <!-- 📦 Commandes en cours -->
            <div class="col-md-4">
                <div class="card bg-warning text-dark shadow">
                    <div class="card-body">
                        <h5 class="card-title">📦 Commandes en cours</h5>
                        <p class="display-6">{{ count($commandesEnCours) }}</p>
                    </div>
                </div>
            </div>

            <!-- ✅ Commandes payées -->
            <div class="col-md-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        <h5 class="card-title">✅ Commandes payées</h5>
                        <p class="display-6">{{ count($commandesPayees) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🔍 Détails commandes -->
        <div class="row mt-5">
            <div class="col-md-6">
                <h4>✅ Détail des commandes payées</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Heure</th>
                            <th>Montant (€)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($commandesPayees as $commande)
                            <tr>
                                <td>#{{ $commande->id }}</td>
                                <td>{{ $commande->created_at->format('H:i') }}</td>
                                <td>{{ number_format($commande->montant_total, 2, ',', ' ') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3">Aucune commande payée.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-6">
                <h4>📦 Détail des commandes en cours</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Statut</th>
                            <th>Heure</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($commandesEnCours as $commande)
                            <tr>
                                <td>#{{ $commande->id }}</td>
                                <td>{{ ucfirst($commande->statut) }}</td>
                                <td>{{ $commande->created_at->format('H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3">Aucune commande en cours.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 📈 Graphiques -->
        <div class="row mt-5">
            <div class="col-md-6">
                <h4>📈 Commandes par mois</h4>
                <canvas id="chartCommandes" height="200"></canvas>
            </div>

            <div class="col-md-6">
                <h4>📚 Top 5 livres vendus ce mois</h4>
                <canvas id="chartLivres" height="200"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const commandesCtx = document.getElementById('chartCommandes').getContext('2d');
        new Chart(commandesCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($moisLabels) !!},
                datasets: [{
                    label: 'Commandes',
                    data: {!! json_encode($commandesParMois) !!},
                    backgroundColor: '#0d6efd',
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        const livresCtx = document.getElementById('chartLivres').getContext('2d');
        new Chart(livresCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($titres) !!},
                datasets: [{
                    data: {!! json_encode($quantites) !!},
                    backgroundColor: ['#198754', '#0d6efd', '#ffc107', '#dc3545', '#6f42c1'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection
