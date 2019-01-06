<?php

namespace App\Http\Controllers;

use App\Milestones;
use Illuminate\Http\Request;

class MilestonesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Milestones::all();
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
     * @param  \App\milestones  $milestones
     * @return \Illuminate\Http\Response
     */
    public function show(milestones $milestones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\milestones  $milestones
     * @return \Illuminate\Http\Response
     */
    public function edit(milestones $milestones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\milestones  $milestones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, milestones $milestones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\milestones  $milestones
     * @return \Illuminate\Http\Response
     */
    public function destroy(milestones $milestones)
    {
        //
    }
}
