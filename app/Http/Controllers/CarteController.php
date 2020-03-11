<?php

namespace App\Http\Controllers;

use App\Carte;
use App\Repositories\CarteRepository;
use Illuminate\Http\Request;

class CarteController extends Controller
{
    protected $carte;

    public function __construct(CarteRepository $carte)
    {
        $this->carte = $carte;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Carte  $carte
     * @return \Illuminate\Http\Response
     */
    public function show(Carte $carte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Carte  $carte
     * @return \Illuminate\Http\Response
     */
    public function edit(Carte $carte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Carte  $carte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carte $carte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Carte  $carte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carte $carte)
    {
        //
    }
}
