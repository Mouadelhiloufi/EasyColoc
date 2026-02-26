<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
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
        $member=$colocation->users()
        ->where('users.id',$user->id)
        ->wherePivotNull('left_at')
        ->firstOrFail();
    
        if($member->pivot->role=='owner'){
            abort(403);
        }

        $score=$member->pivot->score;
        $balance=$member->pivot->balance;
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
