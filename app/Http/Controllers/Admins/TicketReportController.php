<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TicketReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('hesk_tickets')
        ->leftJoin('departments','hesk_tickets.category','=','departments.id')
        ->leftJoin('priorities','hesk_tickets.priority','=','priorities.id')
        ->leftJoin('users','hesk_tickets.owner','=','users.id')
        ->select(
            'hesk_tickets.*',
            'departments.name_khmer',
            'departments.name_english',
            'priorities.name as priorities_name',
            'users.user as owner',
        )->OrderBy('hesk_tickets.id','DESC')->get();
        return view('reports.ticket',compact('data'));
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
