@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('messages.cars_list') }}</h2>
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'regular')
                <a href="{{ route('cars.create') }}" class="btn btn-primary">{{ __('messages.add_new') }}</a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>{{ __('messages.reg_number') }}</th>
                <th>{{ __('messages.brand') }}</th>
                <th>{{ __('messages.model') }}</th>
                <th>{{ __('messages.owner') }}</th>
                <th>{{ __('messages.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cars as $car)
                <tr>
                    <td><span class="badge bg-secondary text-uppercase fs-6">{{ $car->reg_number }}</span></td>
                    <td>{{ $car->brand }}</td>
                    <td>{{ $car->model }}</td>
                    <td>
                        @if($car->owner)
                            {{ $car->owner->name }} {{ $car->owner->surname }}
                        @else
                            <span class="text-muted">{{ __('messages.no_owner_assigned') }}</span>
                        @endif
                    </td>
                    <td>
                        @if(auth()->user()->role === 'admin' || ($car->owner && $car->owner->user_id === auth()->id()))
                            <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-sm btn-warning">{{ __('messages.edit') }}</a>

                            <form action="{{ route('cars.destroy', $car->id) }}" method=\"POST\" class="d-inline" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('messages.delete') }}</button>
                            </form>
                        @else
                            <span class="text-muted small">{{ __('messages.actions_disabled') }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
