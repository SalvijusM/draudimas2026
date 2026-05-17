<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Owner; // Reikės, kad galėtume pasirinkti savininką kuriant automobilį
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Rodo visų automobilių sąrašą.
     */
    public function index()
    {

        $cars = Car::with('owner')->get();

        return view('cars.index', compact('cars'));
    }

    /**
     * Rodo automobilio kūrimo formą.
     */
    public function create()
    {

        $owners = Owner::all();

        return view('cars.create', compact('owners'));
    }

    /**
     * Išsaugoti naują automobilį duomenų bazėje.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reg_number' => 'required|unique:cars,reg_number|max:20',
            'brand' => 'required|string|max:254',
            'model' => 'required|string|max:254',
            'owner_id' => 'required|exists:owners,id', // Tikrina, ar toks savininkas tikrai egzistuoja
        ]);

        Car::create($request->all());

        return redirect()->route('cars.index')->with('success', 'Automobilis sėkmingai pridėtas!');
    }

    /**
     * Rodo automobilio redagavimo formą.
     */
    public function edit(Car $car)
    {
        $owners = Owner::all();
        return view('cars.edit', compact('car', 'owners'));
    }

    /**
     * Atnaujina automobilio duomenis.
     */
    public function update(Request $request, Car $car)
    {
        $request->validate([
            'reg_number' => 'required|max:20|unique:cars,reg_number,' . $car->id, // Leidžia pasilikti tą patį numerį redaguojant
            'brand' => 'required|string|max:254',
            'model' => 'required|string|max:254',
            'owner_id' => 'required|exists:owners,id',
        ]);

        $car->update($request->all());

        return redirect()->route('cars.index')->with('success', 'Automobilio duomenys atnaujinti!');
    }

    /**
     * Ištrina automobilį.
     */
    public function destroy(Car $car)
    {
        $car->delete();

        return redirect()->route('cars.index')->with('success', 'Automobilis pašalintas.');
    }
}
