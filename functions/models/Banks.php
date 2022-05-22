<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{
    use HasFactory;
    protected $table = "banks";

    protected $fillable = [
        'name',
        'user_id',
    ];

    // public function client_role() {
    //     return $this->hasOne(Clientrole::class, 'id', 'client_role');
    // }

    // public function user() {
    //     return $this->hasOne(User::class,  'user_id', 'id');
    // }

}
