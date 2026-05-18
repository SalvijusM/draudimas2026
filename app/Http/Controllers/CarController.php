<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Owner;
use App\Http\Requests\StoreCarRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CarController extends Controller
{
    public function index(): View
    {
        $cars = Car::with('owner')->get();

        return view('cars.index', compact('cars'));
    }
    public function create(): View
    {
        $owners = Owner::all();

        return view('cars.create', compact('owners'));
    }
    public function store(StoreCarRequest $request): RedirectResponse
    {
        Car::create($request->validated());

        return redirect()->route('cars.index')
            ->with('success', __('messages.car_created_success'));
    }
    public function edit(Car $car): View
    {
        $owners = Owner::all();

        return view('cars.edit', compact('car', 'owners'));
    }
    public function update(StoreCarRequest $request, Car $car): RedirectResponse
    {
        $car->update($request->validated());

        return redirect()->route('cars.index')
            ->with('success', __('messages.car_updated_success'));
    }

    public function destroy(Car $car): RedirectResponse
    {
        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', __('messages.car_deleted_success'));
    }
}
