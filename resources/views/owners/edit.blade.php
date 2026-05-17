@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Redaguoti savininką</h2>
    <a href="{{ route('owners.index') }}" class="btn btn-secondary mb-3">Atgal</a>

    <form action="{{ route('owners.update', $owner->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Vardas</label>
            <input type="text" name="name" value="{{ $owner->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Pavardė</label>
            <input type="text" name="surname" value="{{ $owner->surname }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Telefonas</label>
            <input type="text" name="phone" value="{{ $owner->phone }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">El. paštas</label>
            <input type="email" name="email" value="{{ $owner->email }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Adresas</label>
            <textarea name="address" class="form-control" rows="3" required>{{ $owner->address }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Atnaujinti</button>
    </form>
</div>
@endsection
