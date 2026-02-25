<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
