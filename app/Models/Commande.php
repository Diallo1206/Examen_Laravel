<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;



    protected $fillable = [
        'client_id',
        'date_commande',
        'montant',
        'montant_total',

    ];



public function elements()
    {
        return $this->hasMany(CommandeElement::class, 'commande_id');
    }

    public function livres()
    {
        return $this->hasManyThrough(Livre::class, CommandeElement::class, 'commande_id', 'id', 'id', 'livre_id');
    }



    // Relation avec le client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    // ✅ Relation avec les paiements
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    // Commande.php

    public function produits()
    {
        return $this->belongsToMany(Livre::class, 'commande_livre', 'commande_id', 'livre_id');
    }

}
