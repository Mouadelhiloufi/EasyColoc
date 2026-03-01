<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Debt;
use Illuminate\Support\Facades\Auth;


class PayementController extends Controller
{
    public function pay(Debt $debt){
        if($debt->status !='unpaid'){
            return back();
        }
        $debt->update([
            'status'=>'payé'
        ]);

        $colocation=$debt->colocation;

        $debuteur_id=$debt->debuteur;
        $crediteur_id=$debt->crediteur;
        $amount=$debt->amount;

        $debUser=$colocation->users()->where('users.id',$debuteur_id)->first();
        $creUser=$colocation->users()->where('users.id',$crediteur_id)->first();

        if ($debUser && $creUser) {
            $colocation->users()->updateExistingPivot($debuteur_id, [
                'balance' => $debUser->pivot->balance + $amount,
            ]);

            $colocation->users()->updateExistingPivot($crediteur_id, [
                'balance' => $creUser->pivot->balance - $amount,
            ]);
        }

        return back()->with('success', 'Paiement marqué comme payé');

    }
}
