<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ColocationInvitationMail;

class InvitationController extends Controller
{
    // public function invite(Request $request,Colocation $colocation){
    //     $request->validate([
    //         'user_id' => ['required','exists:users,id']
    //     ]);

    //     $invited=User::findOrFail($request->user_id);
    //     $inv=Invitation::create([
    //         'colocation_id' => $colocation->id,
    //         'email' => $invited->email,
    //         'token' => Str::random(50),
    //         'status' => 'pending'
    //     ]);

    //     $urlToSend = route('invitation.page', $inv->token) . '?email=' . urlencode($inv->email);

    
    // Mail::to($invited->email)->send(new \App\Mail\ColocationInvitationMail($urlToSend));

    // return redirect()->back()->with('success', 'Invitation envoyée');
    // }



     public function create(Colocation $colocation)
    {
        return view('invitations.create', compact('colocation'));
    }

     public function store(Request $request, Colocation $colocation)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $inv = Invitation::create([
            'colocation_id' => $colocation->id,
            'email' => $data['email'],
            'token' => Str::random(50),
            'status' => 'pending',
        ]);

        $urlToSend = route('invitation.page', $inv->token) . '?email=' . urlencode($inv->email);

        Mail::to($inv->email)->send(new ColocationInvitationMail($urlToSend));

        return redirect()->route('colocations.show', $colocation)
            ->with('success', 'Invitation envoyée');
    }





    public function page(Request $request,$token){

    $inv=Invitation::where('token',$token)->firstOrFail();
    return view('invitations.page',compact('inv'));

    }

    public function accept($token){
       
        $inv = Invitation::where('token', $token)->firstOrFail();

        $colocation=$inv->colocation;

        $colocation->users()->attach(Auth::id(),[
            'role'=>'member',
            'balance'=>0,
            'score'=>0,
            'left_at'=>null,
        ]);

        $inv->update(['status'=>'accepted']);

        return redirect()->route('colocations.show',$colocation);

    }

    public function refuse($token){
        
        $inv=Invitation::where('token',$token)->firstOrFail();

        $inv->update(['status'=>'refused']);
        return redirect()->route('colocations.index');
    }


}
