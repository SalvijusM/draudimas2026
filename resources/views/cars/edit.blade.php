@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>{{ __('messages.edit_car') }}</h2>
        <a href="{{ route('cars.index') }}" class="btn btn-secondary mb-3">{{ __('messages.back') }}</a>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="reg_number" class="form-label">{{ __('messages.reg_number') }}</label>
                <input type="text"
                       name="reg_number"
                       id="reg_number"
                       value="{{ old('reg_number', $car->reg_number) }}"
                       class="form-control text-uppercase @error('reg_number') is-invalid @enderror">
                @error('reg_number')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="brand" class="form-label">{{ __('messages.brand') }}</label>
                <input type="text"
                       name="brand"
                       id="brand"
                       value="{{ old('brand', $car->brand) }}"
                       class="form-control @error('brand') is-invalid @enderror">
                @error('brand')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">{{ __('messages.model') }}</label>
                <input type="text"
                       name="model"
                       id="model"
                       value="{{ old('model', $car->model) }}"
                       class="form-control @error('model') is-invalid @enderror">
                @error('model')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="owner_id" class="form-label">{{ __('messages.owner') }}</label>
                <select name="owner_id" id="owner_id" class="form-select @error('owner_id') is-invalid @enderror">
                    @foreach($owners as $owner)
                        <option value="{{ $owner->id }}" {{ (old('owner_id', $car->owner_id) == $owner->id) ? 'selected' : '' }}>
                            {{ $owner->name }} {{ $owner->surname }}
                        </option>
                    @endforeach
                </select>
                @error('owner_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @if($car->photos && $car->photos->count() > 0)
                <div class="mb-3">
                    <label class="form-label d-block fw-bold">{{ __('messages.current_photos') ?? 'Esamos nuotraukos:' }}</label>
                    <div class="row">
                        @foreach($car->photos as $photo)
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card h-100 position-relative">
                                    <img src="{{ asset('storage/' . $photo->folder_path) }}" class="card-img-top img-fluid rounded" style="height: 150px; object-fit: cover;" alt="Car photo">

                                    @if(auth()->user()->role === 'admin' || ($car->owner && $car->owner->user_id === auth()->id()))
                                        <button type="button"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"
                                                onclick="if(confirm('{{ __('messages.confirm_delete_photo') ?? 'Ar tikrai norite ištrinti šią nuotrauką?' }}')) { document.getElementById('delete-photo-{{ $photo->id }}').submit(); }">
                                            &times;
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mb-4">
                <label for="photos" class="form-label fw-bold">{{ __('messages.upload_photos') ?? 'Įkelti naujas nuotraukas' }}</label>
                <input type="file"
                       name="photos[]"
                       id="photos"
                       class="form-control @error('photos') is-invalid @enderror @error('photos.*') is-invalid @enderror"
                       multiple
                       accept="image/*">
                <div class="form-text text-muted">Galite pasirinkti kelias nuotraukas iš karto (JPEG, PNG, JPG, GIF). Maks. 2MB.</div>
                @error('photos')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                @error('photos.*')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <hr>

            <button type="submit" class="btn btn-primary">{{ __('messages.update') }}</button>
        </form>

        @if($car->photos && $car->photos->count() > 0)
            @foreach($car->photos as $photo)
                <form id="delete-photo-{{ $photo->id }}" action="{{ route('cars.deletePhoto', $photo->id) }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
        @endif
    </div>
@endsection
