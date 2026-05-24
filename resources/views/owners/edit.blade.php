@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>{{ __('messages.edit_owner') }}</h2>
        <a href="{{ route('owners.index') }}" class="btn btn-secondary mb-3">{{ __('messages.back') }}</a>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('owners.update', $owner->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">{{ __('messages.first_name') }}</label>
                <input type="text" name="name" value="{{ old('name', $owner->name) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('messages.last_name') }}</label>
                <input type="text" name="surname" value="{{ old('surname', $owner->surname) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('messages.phone') }}</label>
                <input type="text" name="phone" value="{{ old('phone', $owner->phone) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('messages.email') }}</label>
                <input type="email" name="email" value="{{ old('email', $owner->email) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('messages.address') }}</label>
                <textarea name="address" class="form-control" rows="3" required>{{ old('address', $owner->address) }}</textarea>
            </div>

            <input type="hidden" name="user_id" value="{{ $owner->user_id ?? auth()->id() }}">

            <button type="submit" class="btn btn-primary">{{ __('messages.update') }}</button>
        </form>
    </div>
@endsection
