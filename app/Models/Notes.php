<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;
    //NomeTabela
    protected $table = 'notes';
        //Campos que aceitam dados em massa
        protected $fillable = ['title', 'content', 'id_user'];
}
