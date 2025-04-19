<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Mail\ConfirmationCommandeMail;
use App\Models\Client;
use App\Models\CommandeElement;
use App\Models\Livre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\FactureMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;          // ← Importer DB

class CommandeController extends Controller
{
    // Afficher la liste des commandes
    public function index()
    {
        $livres = Livre::all();
        $commandes = commande::all();
        return view('commandes.index', compact('commandes', 'livres'));
    }

    // Afficher le formulaire de création d'une commande
    public function create()
    {

        $clients = Client::all();
        $livres = Livre::all();
        return view('commandes.create', compact('clients', 'livres'));
    }

    public function add(Request $request){

    }
    // Enregistrer une nouvelle commande
    // Enregistrer une nouvelle commande
    public function store(Request $request)
    {

        $request->validate([
            'client_id'       => 'required|exists:clients,id',
            'produit_id'      => 'required|array|min:1',
            'produit_id.*'    => 'exists:livres,id',
            'quantite'        => 'required|array|min:1',
            'quantite.*'      => 'integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {


                $commande = new Commande();
                $commande->client_id      = $request->client_id;
                $commande->utilisateur_id = Auth::id();
                $commande->statut         = $request->has('statut') ? $request->statut : 'en_attente';
                $commande->montant_total  = 0;
                $commande->save();


                $fusionProduits = [];
                foreach ($request->produit_id as $i => $produitId) {
                    $quantite = (int) $request->quantite[$i];
                    if (isset($fusionProduits[$produitId])) {
                        $fusionProduits[$produitId] += $quantite;
                    } else {
                        $fusionProduits[$produitId] = $quantite;
                    }
                }

                $total = 0;
                $elements = [];


                foreach ($fusionProduits as $produitId => $quantite) {
                    $livre = Livre::findOrFail($produitId);

                    if ($livre->stock < $quantite) {
                        throw new \Exception("Stock insuffisant pour le livre « {$livre->titre} » (stock dispo : {$livre->stock}).");
                    }

                    $livre->decrement('stock', $quantite);

                    $elements[] = new CommandeElement([
                        'livre_id'  => $livre->id,
                        'quantite'  => $quantite,
                        'prix'      => $livre->prix, // ✅ PRIX UNITAIRE
                    ]);

                    $total += $livre->prix * $quantite;
                }


                $commande->elements()->saveMany($elements);
                $commande->update(['montant_total' => $total]);


                Mail::to($commande->client->email)->send(new ConfirmationCommandeMail($commande));
            });

            return redirect()->route('commandes.index')->with('success', 'Commande enregistrée avec succès !');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erreur : ' . $e->getMessage());
        }
    }












    // Afficher les détails d'une commande
// CommandeController.php
    public function show($id)
    {
        $commande = Commande::with('elements.livre')->findOrFail($id);
        return view('commandes.show', compact('commande'));
    }


    // Afficher le formulaire de modification d'une commande
    public function edit($id)
    {
        $commande = Commande::with('client')->findOrFail($id); // ← fix ici
        $clients = Client::all();
        $livres = Livre::all();
        return view('commandes.edit', compact('commande', 'clients', 'livres'));
    }


    // Mettre à jour les informations d'une commande
    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'statut' => 'required|in:en_attente,en_preparation,expediee,payee',
            'produit_id' => 'required|array',
        ]);


        $commande = Commande::findOrFail($id);
        $commande->client_id = $request->client_id;
        $commande->statut = $request->statut;
        $commande->save();

        // Mettre à jour les produits de la commande
        $commande->produits()->detach();
        foreach ($request->produit_id as $produitId) {
            $commande->produits()->attach($produitId, ['quantite' => 1, 'prix' => Livre::find($produitId)->prix]);
        }

        return redirect()->route('commandes.index')->with('success', 'Commande mise à jour avec succès!');
    }

    public function destroy($id)
    {
        $commande = Commande::with('elements.livre')->findOrFail($id);

        // Restituer les quantités au stock
        foreach ($commande->elements as $element) {
            $livre = $element->livre;
            $livre->stock += $element->quantite; // on restitue la quantité
            $livre->save();
        }

        // Supprimer la commande (et potentiellement ses éléments, selon ton modèle)
        $commande->delete();

        return redirect()->route('commandes.index')->with('success', 'Commande annulée et stock mis à jour avec succès!');
    }


    public function updateStatut(Request $request, $id)
    {
        // Valider l'entrée
        $request->validate([
            'statut' => 'required|in:en_attente,en_preparation,expediee,payee',
        ]);

        // Récupérer la commande
        $commande = Commande::findOrFail($id);

        // Modifier le statut
        $commande->statut = $request->statut;
        $commande->save();

        // Rediriger avec un message de succès
        return redirect()->route('commandes.show', $commande->id)->with('success', 'Statut de la commande mis à jour avec succès!');
    }
    public function envoyerFacture($commandeId)
    {
        $commande = Commande::findOrFail($commandeId);

        // Envoi de la facture par e-mail au client
        Mail::to($commande->utilisateur->email)->send(new FactureMail($commande));

        return redirect()->route('commandes.show', $commandeId)->with('success', 'La facture a été envoyée au client.');
    }

}

