<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture #{{ $commande->id }}</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .invoice-box {
            max-width: 850px;
            margin: auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }

        .top-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .top-section .logo img {
            max-height: 50px;
        }

        .top-section .info {
            text-align: right;
        }

        h1 {
            font-size: 28px;
            color: #2b2d42;
            margin-bottom: 10px;
        }

        .details {
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .details strong {
            color: #2b2d42;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 15px;
        }

        table thead {
            background-color: #2b2d42;
            color: #fff;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
        }

        table tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .total-section {
            margin-top: 25px;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }

        .total-section span {
            color: #27ae60;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: #999;
        }

        .footer a {
            color: #3498db;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="invoice-box">
    <!-- En-tête -->
    <div class="top-section">
        <div class="logo">
            <img src="https://via.placeholder.com/150x50.png?text=Logo" alt="Logo">
        </div>
        <div class="info">
            <h1>Facture #{{ $commande->id }}</h1>
            <div>Date : {{ $commande->created_at->format('d M Y, H:i') }}</div>
        </div>
    </div>

    <!-- Informations client -->
    <div class="details">
        <p><strong>Client :</strong> {{ App\Models\User::find($commande->utilisateur_id)->prenom }} {{ App\Models\User::find($commande->utilisateur_id)->nom }}</p>
        <p><strong>Statut :</strong> {{ ucfirst($commande->statut) }}</p>
        <p><strong>Email :</strong> {{ App\Models\User::find($commande->utilisateur_id)->email ?? 'Non renseigné' }}</p>
    </div>

    <!-- Détail des livres -->
    <h3>Livres Commandés</h3>
    <table>
        <thead>
        <tr>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Quantité</th>
            <th>Prix Unitaire</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($commande->elements as $element)
            <tr>
                <td>{{ $element->livre->titre }}</td>
                <td>{{ $element->livre->auteur }}</td>
                <td>{{ $element->quantite }}</td>
                <td>{{ number_format($element->prix, 2, ',', ' ') }} XOF</td>
                <td>{{ number_format($element->prix * $element->quantite, 2, ',', ' ') }} XOF</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Total -->
    <div class="total-section">
        Total à payer : <span>{{ number_format($commande->montant_total, 2, ',', ' ') }} XOF</span>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Merci pour votre achat !</p>
        <p>Contact : <a href="mailto:contact@exemple.com">contact@exemple.com</a> | Site : <a href="https://www.exemple.com">www.exemple.com</a></p>
    </div>
</div>
</body>
</html>
