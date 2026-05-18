<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Owner;
use App\Models\CarPhoto;
use App\Http\Requests\StoreCarRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index(): View
    {
        $cars = Car::with(['owner', 'photos'])->get();

        return view('cars.index', compact('cars'));
    }

    public function create(): View
    {
        $owners = Owner::all();

        return view('cars.create', compact('owners'));
    }

    public function store(StoreCarRequest $request): RedirectResponse
    {
        $car = Car::create($request->validated());

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('cars', 'public');
                $car->photos()->create([
                    'folder_path' => $path
                ]);
            }
        }

        return redirect()->route('cars.index')
            ->with('success', __('messages.car_created_success'));
    }

    public function edit(Car $car): View
    {
        $owners = Owner::all();

        $car->load('photos');

        return view('cars.edit', compact('car', 'owners'));
    }

    public function update(StoreCarRequest $request, Car $car): RedirectResponse
    {
        $car->update($request->validated());

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('cars', 'public');
                $car->photos()->create([
                    'folder_path' => $path
                ]);
            }
        }

        return redirect()->route('cars.index')
            ->with('success', __('messages.car_updated_success'));
    }

    public function destroy(Car $car): RedirectResponse
    {
        foreach ($car->photos as $photo) {
            if (Storage::disk('public')->exists($photo->folder_path)) {
                Storage::disk('public')->delete($photo->folder_path);
            }
        }

        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', __('messages.car_deleted_success'));
    }

    public function deletePhoto(CarPhoto $photo): RedirectResponse
    {
        if (Storage::disk('public')->exists($photo->folder_path)) {
            Storage::disk('public')->delete($photo->folder_path);
        }

        $photo->delete();

        return redirect()->back()
            ->with('success', __('messages.photo_deleted_success'));
    }
}
