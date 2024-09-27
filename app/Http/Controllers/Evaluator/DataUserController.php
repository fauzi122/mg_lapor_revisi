<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class DataUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_bu()
    {
        $user_bu=User::where('role','BU')->get();
        return view('evaluator.user.bu.index',compact('user_bu'));
    }

    public function index_adm()
    {
        $user_adm=User::where('role','ADM')->get();
        return view('evaluator.user.evaluator.index',compact('user_adm'));
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
    public function store(Request $request)
    {
        //
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
