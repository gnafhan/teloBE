<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seasons = Season::all();
        return view('pages/season/index', compact('seasons'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages/season/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Season::create([
            'title' => $request->title,
            'city' => $request->city,
            'province' => $request->province,
            'description' => $request->description,
        ]);

        return redirect()->route('seasons.index')->with('success', 'Season created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Season $season)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Season $season)
    {
        $seasonFound = Season::find($season->id);
        if (!$seasonFound) {
            return redirect()->route('seasons.index')->with('error', 'Season not found');
        }
        return view('pages/season/edit', compact('seasonFound'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Season $season)
    {
        $seasonFound = Season::find($season->id);
        if (!$seasonFound) {
            return redirect()->route('seasons.index')->with('error', 'Season not found');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $seasonFound->update([
            'title' => $request->title,
            'city' => $request->city,
            'province' => $request->province,
            'description' => $request->description,
        ]);

        return redirect()->route('seasons.index')->with('success', 'Season updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Season $season)
    {
        $seasonFound = Season::find($season->id);
        if (!$seasonFound) {
            return redirect()->route('seasons.index')->with('error', 'Season not found');
        }

        $seasonFound->delete();
        return redirect()->route('seasons.index')->with('success', 'Season deleted successfully');
    }
}
