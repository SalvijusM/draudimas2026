@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>{{ __('messages.add_new_car') }}</h2>
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

        <form action="{{ route('cars.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="reg_number" class="form-label">{{ __('messages.reg_number') }}</label>
                <input type="text"
                       name="reg_number"
                       id="reg_number"
                       value="{{ old('reg_number') }}"
                       class="form-control text-uppercase @error('reg_number') is-invalid @enderror"
                       placeholder="E.g. ABC123">
                @error('reg_number')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="brand" class="form-label">{{ __('messages.brand') }}</label>
                <input type="text"
                       name="brand"
                       id="brand"
                       value="{{ old('brand') }}"
                       class="form-control @error('brand') is-invalid @enderror"
                       placeholder="E.g. Audi">
                @error('brand')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">{{ __('messages.model') }}</label>
                <input type="text"
                       name="model"
                       id="model"
                       value="{{ old('model') }}"
                       class="form-control @error('model') is-invalid @enderror"
                       placeholder="E.g. A6">
                @error('model')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="owner_id" class="form-label">{{ __('messages.owner') }}</label>
                <select name="owner_id" id="owner_id" class="form-select @error('owner_id') is-invalid @enderror">
                    <option value="" selected disabled>{{ __('messages.select_owner') }}</option>
                    @foreach($owners as $owner)
                        <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                            {{ $owner->name }} {{ $owner->surname }}
                        </option>
                    @endforeach
                </select>
                @error('owner_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">{{ __('messages.save') }}</button>
        </form>
    </div>
@endsection
