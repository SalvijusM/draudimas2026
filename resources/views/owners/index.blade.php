@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Automobilių savininkai</h2>
        <a href="{{ route('owners.create') }}" class="btn btn-primary">Pridėti naują</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Vardas Pavardė</th>
                <th>Telefonas</th>
                <th>El. paštas</th>
                <th>Adresas</th>
                <th>Veiksmai</th>
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
                    <a href="{{ route('owners.edit', $owner->id) }}" class="btn btn-sm btn-warning">Redaguoti</a>

                    <form action="{{ route('owners.destroy', $owner->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Ar tikrai norite ištrinti?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Trinti</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
