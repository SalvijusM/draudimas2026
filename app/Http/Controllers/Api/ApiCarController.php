<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiCarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin' || $user->role === 'viewer') {
            return response()->json(Car::with('owner')->get(), 200);
        }
        return response()->json(Car::whereHas('owner', fn($q) => $q->where('user_id', $user->id))->get(), 200);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'viewer') return response()->json(['error' => 'Forbidden'], 403);

        $validated = $request->validate([
            'reg_number' => 'required|unique:cars,reg_number',
            'brand' => 'required',
            'model' => 'required',
            'owner_id' => 'required|exists:owners,id'
        ]);

        return response()->json(Car::create($validated), 201);
    }

    public function show(string $id)
    {
        $car = Car::with('owner')->findOrFail($id);
        if (Auth::user()->role === 'regular' && $car->owner->user_id !== Auth::id()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        return response()->json($car, 200);
    }

    public function update(Request $request, string $id)
    {
        $car = Car::findOrFail($id);
        if (Auth::user()->role === 'viewer' || (Auth::user()->role === 'regular' && $car->owner->user_id !== Auth::id())) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        $car->update($request->all());
        return response()->json($car, 200);
    }

    public function destroy(string $id)
    {
        $car = Car::findOrFail($id);
        if (Auth::user()->role === 'viewer' || (Auth::user()->role === 'regular' && $car->owner->user_id !== Auth::id())) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        $car->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }
}
