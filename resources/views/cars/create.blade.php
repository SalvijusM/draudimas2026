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
                <label class="form-label">{{ __('messages.reg_number') }}</label>
                <input type="text" name="reg_number" class="form-control text-uppercase" placeholder="E.g. ABC123" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('messages.brand') }}</label>
                <input type="text" name="brand" class="form-control" placeholder="E.g. Audi" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('messages.model') }}</label>
                <input type="text" name="model" class="form-control" placeholder="E.g. A6" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('messages.owner') }}</label>
                <select name="owner_id" class="form-select" required>
                    <option value="" selected disabled>{{ __('messages.select_owner') }}</option>
                    @foreach($owners as $owner)
                        <option value="{{ $owner->id }}">{{ $owner->name }} {{ $owner->surname }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">{{ __('messages.save') }}</button>
        </form>
    </div>
@endsection
