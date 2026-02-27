<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $fillable = [
        'colocation_id',
        'debuteur',
        'crediteur',
        'amount',
        'status',
    ];

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    // débiteur (celui qui doit)
    public function debiteurUser()
    {
        return $this->belongsTo(User::class, 'debuteur');
    }

    // créditeur (celui qui reçoit)
    public function crediteurUser()
    {
        return $this->belongsTo(User::class, 'crediteur');
    }
}
