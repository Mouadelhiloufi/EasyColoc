<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Debt;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function leave(Colocation $colocation){

    $userId=Auth::id();
    $membre=$colocation->users()
    ->where('users.id',$userId)
    ->wherePivotNull('left_at')
    ->firstOrFail();

    if($membre->pivot->role == 'owner'){
        abort(403);
    }

    $balance=$membre->pivot->balance;
    $score=$membre->pivot->score;

    // jib owner d coloc
    $owner = $colocation->users()
        ->wherePivot('role', 'owner')
        ->wherePivotNull('left_at')
        ->firstOrFail();


        // kathawel tous les dettes a owner as crediteur et debuteur
        Debt::where('colocation_id', $colocation->id)
        ->where('status', 'unpaid')
        ->where('debuteur', $userId)
        ->update(['debuteur' => $owner->id]);

         Debt::where('colocation_id', $colocation->id)
        ->where('status', 'unpaid')
        ->where('crediteur', $userId)
        ->update(['crediteur' => $owner->id]);


        // kat supprimer tous les dettes lifihom owner kitsal owner
        Debt::where('colocation_id', $colocation->id)
        ->where('status', 'unpaid')
        ->whereColumn('debuteur', 'crediteur')
        ->delete();



    
    if($balance>=0){
    $colocation->users()->updateExistingPivot($userId,[
        'left_at'=> now(),
        'score'=>$score+1,
    ]);
    }else{
    $colocation->users()->updateExistingPivot($userId,[
        'left_at'=> now(),
        'score'=>$score-1,
    ]);
    }

    return redirect()->route('colocations.index');


    }


    public function remove(Colocation $colocation,User $user){
        $isOwner=$colocation->users()
        ->where('users.id',Auth::id())
        ->wherePivot('role','owner')
        ->wherePivotNull('left_at')
        ->exists();

        if(!$isOwner){
            abort(403);
        }
        $memberquitt=$colocation->users()
        ->where('users.id',$user->id)
        ->wherePivotNull('left_at')
        ->firstOrFail();
    
        if($memberquitt->pivot->role=='owner'){
            abort(403);
        }




        $owner = $colocation->users()
        ->wherePivot('role', 'owner')
        ->wherePivotNull('left_at')
        ->firstOrFail();


        // kathawel kulchi l owner
        Debt::where('colocation_id', $colocation->id)
        ->where('status', 'unpaid')
        ->where('debuteur', $user->id)
        ->update(['debuteur' => $owner->id]);


         Debt::where('colocation_id', $colocation->id)
        ->where('status', 'unpaid')
        ->where('crediteur', $user->id)
        ->update(['crediteur' => $owner->id]);


        // katm7i ga3 les dettes lifihom owner kitsal raso
         Debt::where('colocation_id', $colocation->id)
        ->where('status', 'unpaid')
        ->whereColumn('debuteur', 'crediteur')
        ->delete();



        $score=$memberquitt->pivot->score;
        $balance=$memberquitt->pivot->balance;
        if($balance>=0){
            $colocation->users()->updateExistingPivot($user->id,[
                'score'=>$score+1,
                'left_at'=>now(),
            ]);
        }else{
            $colocation->users()->updateExistingPivot($user->id,[
                'score'=>$score-1,
                'left_at'=>now()
            ]);
        }
        return back();  
    }

}
