<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{

    protected $fillable = [
    'name',
    'status',
    'cancelled_at',
];


    public function users()
{
    return $this->belongsToMany(User::class)
        ->withPivot('role', 'balance', 'score', 'left_at')
        ->withTimestamps();
}

    public function expenses()
{
    return $this->hasMany(Expense::class);
}

    public function invitations()
{
    return $this->hasMany(Invitation::class);
}

public function categories()
{
    return $this->hasMany(Category::class);
}


}
