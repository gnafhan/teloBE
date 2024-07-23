<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CharacterController extends Controller
{
    public function index()
    {
        $characters = Character::all();
        return view('pages/character/index', compact('characters'));
    }

    public function show($id)
    {
        $character = Character::find($id);
        if (!$character) {
            return redirect()->route('characters.index')->with('error', 'Character not found');
        }
        return view('characters.show', compact('character'));
    }

    public function create()
    {
        return view('pages/character/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'age' => 'required|integer',
            'filepath' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        if (Character::where('name', $request->name)->where('age', $request->age)->exists()) {
            return redirect()->back()->withErrors(['name' => 'Character with the same name and age already exists.'])->withInput();
        }

        $file = $request->file('filepath');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/characters'), $filename);

        Character::create([
            'name' => $request->name,
            'role' => $request->role,
            'age' => $request->age,
            'filepath' => 'images/characters/' . $filename,
        ]);

        return redirect()->route('character.home')->with('success', 'Character created successfully');
    }

    public function edit($id)
    {
        $character = Character::find($id);
        if (!$character) {
            return redirect()->route('characters.index')->with('error', 'Character not found');
        }
        return view('pages/character/edit', compact('character'));
    }

    public function update(Request $request, $id)
    {
        $character = Character::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'age' => 'required|integer',
            'filepath' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ], [
            'name.required' => 'Name is required.',
            'role.required' => 'Role is required.',
            'age.required' => 'Age is required.',
            'filepath.image' => 'File must be an image.',
            'filepath.mimes' => 'File must be a type of: jpeg, png, jpg, gif, svg.',
            'filepath.max' => 'File may not be greater than 10240 kilobytes.',
        ]);

        if (Character::where('name', $request->name)->where('age', $request->age)->where('id', '!=', $id)->exists()) {
            return redirect()->back()->withErrors(['name' => 'Character with the same name and age already exists.'])->withInput();
        }

        if ($request->hasFile('filepath')) {
            // Delete old file
            if ($character->filepath) {
                Storage::delete($character->filepath);
            }

            // Store new file
            $imagePath = $request->file('filepath')->store('public/images/characters');
            $character->filepath = Storage::url($imagePath);
        }

        // Update other attributes
        $character->name = $request->name;
        $character->role = $request->role;
        $character->age = $request->age;
        $character->save();

        return redirect()->route('character.home')->with('success', 'Character updated successfully');
    }

    public function destroy($id)
    {
        $character = Character::findOrFail($id);

        // Delete the associated image if it exists
        if ($character->filepath) {
            Storage::delete($character->filepath);
        }

        // Delete the character record
        $character->delete();

        return redirect()->route('character.home')->with('success', 'Character deleted successfully');
    }
}
