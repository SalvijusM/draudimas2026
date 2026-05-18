@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>{{ __('messages.add_new_owner') }}</h2>
        <a href="{{ route('owners.index') }}" class="btn btn-secondary mb-3">{{ __('messages.back') }}</a>

        <form action="{{ route('owners.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ __('messages.first_name') }}</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('messages.last_name') }}</label>
                <input type="text" name="surname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('messages.phone') }}</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('messages.email') }}</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('messages.address') }}</label>
                <textarea name="address" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">{{ __('messages.save') }}</button>
        </form>
    </div>
@endsection
