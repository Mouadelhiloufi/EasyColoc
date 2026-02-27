<?php

namespace App\Http\Controllers;
use App\Models\Colocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $colocations = $user->colocations()
        ->withPivot('role', 'balance', 'score', 'left_at')
        ->orderByDesc('colocations.created_at')
        ->get();

    return view('colocations.index', compact('colocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('colocations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> ['required','string','max:300'],
        ]);

        $user= Auth::user();

        $hasActive=$user->colocations()
        ->wherePivotNull('left_at')
        ->exists();

        if($hasActive){
            return back();
            }

        $colocation = Colocation::create([
            'name'=>$user->name,
            'status'=>'active',
        ]);

        $colocation->users()->attach($user->id, [
            'role'=>'owner',
            'balance'=>0,
            'score'=>0,
            'left_at'=>null
        ]);

        return redirect()->route('colocations.show',$colocation);
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request,Colocation $colocation)
    {
        $year=$request->get('year');
        $month=$request->get('month');
        $user_id=Auth::id();
        $isMember = $colocation->users()->where('users.id',$user_id)->exists();

        abort_unless($isMember, 403);
        $colocation->load(['users','Invitations']);
        if($year && $month){
            $expenses=$colocation->expenses()->with('category')->whereYear('date',$year)->whereMonth('date',$month)->get();
        }else{
            $expenses=$colocation->expenses()->with('category')->get();
        }

        $debts = $colocation->debts()->where('status','unpaid')
        ->with(['debiteurUser','crediteurUser'])
        ->get();


        
     
              return view('colocations.show',compact('colocation','expenses','debts'));
              
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colocation $colocation)
    {
        return view('colocations.edit',compact('colocation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colocation $colocation)
    {
        $request->validate([
            'name' => ['required','string','max:300'],
        ]);

        $user_id=Auth::id();
        $isOwner=$colocation->users()
        ->where('users.id','$user_id')
        ->wherePivot('role','owner')
        ->wherePivotNull('left_at')
        ->exists();

        abort_unless($isOwner, 403);

        $colocation->update(['name' =>$request->name]);
        
        return redirect()->route('colocation.show','$colocation');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colocation $colocation)
    {
        $user_id=Auth::id();
        $isOwner=$colocation->users()
        ->wherePivot('role','owner')
        ->wherePivotNull('left_at')
        ->exists();

        abort_unless($isOwner, 403);

        $colocation->update([
            'status'=>'cancelled',
            'cancelled_at'=>now(),
        ]);

        return redirect()->route('colocations.index');
    }
}
