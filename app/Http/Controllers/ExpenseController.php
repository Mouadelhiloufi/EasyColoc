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

        Expense::create([
            'title'=>$request->title,
            'amount'=>$request->amount,
            'date'=>$request->date,
            'colocation_id'=>$colocation->id,
            'category_id'=>$request->category_id,
            'payer_id'=>Auth::id(),

        ]);
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
