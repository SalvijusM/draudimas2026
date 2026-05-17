@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Redaguoti automobilį</h2>
        <a href="{{ route('cars.index') }}" class="btn btn-secondary mb-3">Atgal</a>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cars.update', $car->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Valstybinis numeris</label>
                <input type="text" name="reg_number" value="{{ $car->reg_number }}" class="form-control text-uppercase" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Markė (Brand)</label>
                <input type="text" name="brand" value="{{ $car->brand }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Modelis</label>
                <input type="text" name="model" value="{{ $car->model }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Savininkas</label>
                <select name="owner_id" class="form-select" required>
                    @foreach($owners as $owner)
                        <option value="{{ $owner->id }}" {{ $car->owner_id == $owner->id ? 'selected' : '' }}>
                            {{ $owner->name }} {{ $owner->surname }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Atnaujinti</button>
        </form>
    </div>
@endsection
