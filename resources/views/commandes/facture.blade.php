<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $commande->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: auto; }
        .header { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        .total { font-size: 20px; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Facture #{{ $commande->id }}</h2>
        <p>Date: {{ $commande->created_at->format('d M Y') }}</p>
    </div>

    <h3>Informations Client</h3>
    <p><strong>Nom:</strong> {{ $commande->utilisateur->prenom }} {{ $commande->utilisateur->nom }}</p>
    <p><strong>Email:</strong> {{ $commande->utilisateur->email }}</p>

    <h3>Détails de la commande</h3>
    <table>
        <thead>
        <tr>
            <th>Livre</th>
            <th>Quantité</th>
            <th>Prix Unitaire</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($commande->elements as $element)
            <tr>
                <td>{{ $element->livre->titre }}</td>
                <td>{{ $element->quantite }}</td>
                <td>{{ number_format($element->prix, 2, ',', ' ') }}€</td>
                <td>{{ number_format($element->prix * $element->quantite, 2, ',', ' ') }}XOF</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h3>Paiements</h3>
    <ul>
        @foreach($commande->paiement as $paiement)
            <li>{{ $paiement->methode_paiement }} - {{ number_format($paiement->montant, 2, ',', ' ') }}XOF ({{ $paiement->created_at->format('d M Y') }})</li>
        @endforeach
    </ul>

    <p class="total">Montant Total: {{ number_format($commande->montant_total, 2, ',', ' ') }}XOF</p>
</div>
</body>
</html>
