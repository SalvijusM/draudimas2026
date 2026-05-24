<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiOwnerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin' || $user->role === 'viewer') {
            return response()->json(Owner::with('cars')->get(), 200);
        }
        return response()->json(Owner::where('user_id', $user->id)->with('cars')->get(), 200);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role === 'viewer') return response()->json(['error' => 'Forbidden'], 403);

        $validated = $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $validated['user_id'] = ($user->role === 'regular') ? $user->id : $request->user_id;

        return response()->json(Owner::create($validated), 201);
    }

    public function show(string $id)
    {
        $owner = Owner::with('cars')->findOrFail($id);
        if (Auth::user()->role === 'regular' && $owner->user_id !== Auth::id()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        return response()->json($owner, 200);
    }

    public function update(Request $request, string $id)
    {
        $owner = Owner::findOrFail($id);
        if (Auth::user()->role === 'viewer' || (Auth::user()->role === 'regular' && $owner->user_id !== Auth::id())) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        $owner->update($request->all());
        return response()->json($owner, 200);
    }

    public function destroy(string $id)
    {
        $owner = Owner::findOrFail($id);
        if (Auth::user()->role === 'viewer' || (Auth::user()->role === 'regular' && $owner->user_id !== Auth::id())) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        $owner->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }
}
