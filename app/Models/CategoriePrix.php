<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriePrix extends Model
{
    use HasFactory;

    protected $table = "categorie_prix";

    protected $fillable = ["categorie_id", "montant", "user_id"];

    public $timestamps = false;
}
