<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    /**
     * Užtikriname, kad tik prisijungę vartotojai gali pasiekti šį valdiklį.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Rodo savininkų sąrašą priklausomai nuo rolės.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin' || $user->role === 'viewer') {
            $owners = Owner::all();
        }
        elseif ($user->role === 'regular') {
            $owners = Owner::where('user_id', $user->id)->get();
        } else {
            abort(403, 'Neatpažinta vartotojo rolė.');
        }

        return view('owners.index', compact('owners'));
    }

    /**
     * Rodo naujo savininko kūrimo formą.
     */
    public function create()
    {
        // Tik Administratorius gali kurti naujus savininkus
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Jūs neturite teisės kurti naujų savininkų.');
        }

        return view('owners.create');
    }

    /**
     * Išsaugo naują savininką duomenų bazėje.
     */
    public function store(Request $request)
    {
        // Papildoma apsauga kontroleryje
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Jūs neturite teisės atlikti šio veiksmo.');
        }

        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'user_id' => 'nullable|exists:users,id|unique:owners,user_id', // Užtikrina saugų susiejimą su User
        ]);

        Owner::create($request->all());

        return redirect()->route('owners.index')->with('success', 'Savininkas pridėtas');
    }

    /**
     * Rodo savininko redagavimo formą.
     */
    public function edit(Owner $owner)
    {
        $user = Auth::user();

        if ($user->role === 'viewer') {
            abort(403, 'Jums leidžiama tik peržiūra.');
        }

        if ($user->role === 'regular' && $owner->user_id !== $user->id) {
            abort(403, 'Jūs neturite teisės redaguoti šio profilio.');
        }

        return view('owners.edit', compact('owner'));
    }

    /**
     * Atnaujina savininko duomenis.
     */
    public function update(Request $request, Owner $owner)
    {
        $user = Auth::user();

        // Saugumo patikros prieš atliekant pakeitimus duomenų bazėje
        if ($user->role === 'viewer') {
            abort(403, 'Jums leidžiama tik peržiūra.');
        }

        if ($user->role === 'regular' && $owner->user_id !== $user->id) {
            abort(403, 'Jūs neturite teisės atnaujinti šio profilio.');
        }

        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        $owner->update($request->all());

        return redirect()->route('owners.index')->with('success', 'Informacija atnaujinta');
    }

    /**
     * Ištrina savininką.
     */
    public function destroy(Owner $owner)
    {
        $user = Auth::user();
        if ($user->role === 'viewer') {
            abort(403, 'Jums leidžiama tik peržiūra.');
        }

        if ($user->role === 'regular' && $owner->user_id !== $user->id) {
            abort(403, 'Jūs neturite teisės ištrinti šio profilio.');
        }

        $owner->delete();

        return redirect()->route('owners.index')->with('success', 'Savininkas ištrintas');
    }
}
