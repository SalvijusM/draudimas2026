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
    /**
     * Užtikriname, kad tik prisijungę vartotojai pasiekia automobilių valdiklį.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Rodo automobilių sąrašą pagal vaidmenis (rolės tekstinę reikšmę).
     */
    public function index(): View
    {
        $user = auth()->user();

        if ($user->role === 'regular') {
            $cars = Car::whereHas('owner', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['owner', 'photos'])->get();
        }
        elseif ($user->role === 'admin' || $user->role === 'viewer') {
            $cars = Car::with(['owner', 'photos'])->get();
        } else {
            abort(403, 'Neatpažinta vartotojo rolė.');
        }

        return view('cars.index', compact('cars'));
    }

    /**
     * Rodo automobilio kūrimo formą.
     */
    public function create(): View
    {
        $user = auth()->user();

        if ($user->role === 'viewer') {
            abort(403, 'Jums leidžiama tik peržiūra.');
        }

        if ($user->role === 'admin') {
            $owners = Owner::all();
        } else {
            $owners = Owner::where('user_id', $user->id)->get();
        }

        return view('cars.create', compact('owners'));
    }

    /**
     * Išsaugo naują automobilį.
     */
    public function store(StoreCarRequest $request): RedirectResponse
    {
        $user = auth()->user();

        if ($user->role === 'viewer') {
            abort(403, 'Jums leidžiama tik peržiūra.');
        }

        if ($user->role === 'regular') {
            Owner::where('id', $request->input('owner_id'))
                ->where('user_id', $user->id)
                ->firstOrFail();
        }

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

    /**
     * Rodo automobilio redagavimo formą.
     */
    public function edit(Car $car): View
    {
        $user = auth()->user();

        if ($user->role === 'viewer') {
            abort(403, 'Jums leidžiama tik peržiūra.');
        }

        // Griežta patikra nuo rankinio ID spėliojimo adreso juostoje
        if ($user->role === 'regular') {
            if (!$car->owner || $car->owner->user_id !== $user->id) {
                abort(403, 'Šis veiksmas jums neleidžiamas.');
            }
            $owners = Owner::where('user_id', $user->id)->get();
        } else {
            $owners = Owner::all();
        }

        $car->load('photos');

        return view('cars.edit', compact('car', 'owners'));
    }

    /**
     * Atnaujina automobilio informaciją.
     */
    public function update(StoreCarRequest $request, Car $car): RedirectResponse
    {
        $user = auth()->user();

        if ($user->role === 'viewer') {
            abort(403, 'Jums leidžiama tik peržiūra.');
        }

        if ($user->role === 'regular') {
            if (!$car->owner || $car->owner->user_id !== $user->id) {
                abort(403, 'Šis veiksmas jums neleidžiamas.');
            }

            Owner::where('id', $request->input('owner_id'))
                ->where('user_id', $user->id)
                ->firstOrFail();
        }

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

    /**
     * Ištrina automobilį ir jo nuotraukas iš diskų.
     */
    public function destroy(Car $car): RedirectResponse
    {
        $user = auth()->user();

        if ($user->role === 'viewer') {
            abort(403, 'Jums leidžiama tik peržiūra.');
        }

        if ($user->role === 'regular') {
            if (!$car->owner || $car->owner->user_id !== $user->id) {
                abort(403, 'Šis veiksmas jums neleidžiamas.');
            }
        }

        foreach ($car->photos as $photo) {
            if (Storage::disk('public')->exists($photo->folder_path)) {
                Storage::disk('public')->delete($photo->folder_path);
            }
        }

        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', __('messages.car_deleted_success'));
    }

    /**
     * Pašalina konkrečią automobilio nuotrauką.
     */
    public function deletePhoto(CarPhoto $photo): RedirectResponse
    {
        $user = auth()->user();

        if ($user->role === 'viewer') {
            abort(403, 'Jums leidžiama tik peržiūra.');
        }

        if ($user->role === 'regular') {
            if (!$photo->car->owner || $photo->car->owner->user_id !== $user->id) {
                abort(403, 'Šis veiksmas jums neleidžiamas.');
            }
        }

        if (Storage::disk('public')->exists($photo->folder_path)) {
            Storage::disk('public')->delete($photo->folder_path);
        }

        $photo->delete();

        return redirect()->back()
            ->with('success', __('messages.photo_deleted_success'));
    }
}
