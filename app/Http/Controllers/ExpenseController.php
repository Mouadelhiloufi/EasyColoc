<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request ,Colocation $colocation)
    {
        $request->validate([
            'title'=>['required','string','max:300'],
            'amount'=>['required','numeric','min:0'],
            'date'=>['required','date'],
            'category_id'=>['nullable']
        ]);

        $expense=Expense::create([
            'title'=>$request->title,
            'amount'=>$request->amount,
            'date'=>$request->date,
            'colocation_id'=>$colocation->id,
            'category_id'=>$request->category_id,
            'payer_id'=>Auth::id(),

        ]);
        $array = $expense->colocation->users()
        ->wherePivot('status', 'accepted') // si status est pivot
        ->pluck('users.id')
        ->all(); 

        $count=$colocation->users()->count();
        
        $members_credit=$colocation->users()->where('users.id','!=',Auth::id())->get();
        $calc=$expense->amount/$count;
        $debuteur=Auth::id();
        $member=$expense->colocation->users()->where('users.id',$debuteur)->firstOrFail();

        
        

    $members=$expense->colocation->users()->get();
        foreach($members_credit as $m){
        if($m->id != $debuteur){
            $colocation->users()->updateExistingPivot($m->id, [
            'balance' => $m->pivot->balance - $calc,
        ]);

             $colocation->users()->updateExistingPivot($member->id, [
            'balance' => $member->pivot->balance + $calc,
        ]);
            $member->pivot->balance = $member->pivot->balance + $calc;
        }
        }
        $member->save();

        foreach($array as $id){
            if($member->id!=$id){
                $debut = $member->debtsAsCrediteur()
                ->where('debuteur', $id)
                ->where('status', 'unpaid')
                ->first();
                // ana likantsal
                $credit = $member->debtsAsDebiteur()->where('crediteur', $id)->where('status', 'unpaid')->first();
                // ana likhasni nkhls

                if($debut){
                    $debut->amount+=$calc;
                    $debut->save();
                }else if($credit){
                    $temp=$credit->amount-$calc;
                    if($temp<0){
                        $credit->crediteur=$member->id;
                        $credit->debuteur=$id;
                        $credit->amount=(-$temp);
                    }else{
                        $credit->amount=$credit->amount-$calc;
                    }
                    $credit->save();
                }
                else{
                    $expense->colocation->debts()->create([
                        'amount'=>$calc,
                        'debuteur'=>$id,
                        'crediteur'=>$member->id,
                        'status'=>'unpaid',
                    ]);
                }
            }
        }




    return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
