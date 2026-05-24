@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('messages.owners_list') }}</h2>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('owners.create') }}" class="btn btn-primary">{{ __('messages.add_new') }}</a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>{{ __('messages.full_name') }}</th>
                <th>{{ __('messages.phone') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.address') }}</th>
                <th>{{ __('messages.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($owners as $owner)
                <tr>
                    <td>{{ $owner->name }} {{ $owner->surname }}</td>
                    <td>{{ $owner->phone }}</td>
                    <td>{{ $owner->email }}</td>
                    <td>{{ $owner->address }}</td>
                    <td>
                        @if(auth()->user()->role === 'admin' || (auth()->user()->role === 'regular' && $owner->user_id === auth()->id()))
                            <a href="{{ route('owners.edit', $owner->id) }}" class="btn btn-sm btn-warning">{{ __('messages.edit') }}</a>

                            <form action="{{ route('owners.destroy', $owner->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('messages.confirm_delete_owner') }}')">
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
