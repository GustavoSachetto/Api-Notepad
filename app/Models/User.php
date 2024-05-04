<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = 'users';
    
    /** 
     * Campos que aceitam dados em massa
    */
    protected $fillable = ['name', 'email', 'password'];
}
