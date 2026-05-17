@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Pridėti naują savininką</h2>
    <a href="{{ route('owners.index') }}" class="btn btn-secondary mb-3">Atgal</a>

    <form action="{{ route('owners.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Vardas</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Pavardė</label>
            <input type="text" name="surname" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Telefonas</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">El. paštas</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Adresas</label>
            <textarea name="address" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Išsaugoti</button>
    </form>
</div>
@endsection
