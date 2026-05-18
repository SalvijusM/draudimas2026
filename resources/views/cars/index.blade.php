@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Automobilių sąrašas</h2>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('cars.create') }}" class="btn btn-primary">Pridėti naują</a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Valstybinis Nr.</th>
                <th>Markė (Brand)</th>
                <th>Modelis</th>
                <th>Savininkas</th>
                <th>Veiksmai</th>
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
                            <span class="text-muted">Savininkas nepriskirtas</span>
                        @endif
                    </td>
                    <td>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-sm btn-warning">Redaguoti</a>

                            <form action="{{ route('cars.destroy', $car->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Ar tikrai norite ištrinti šį automobilį?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Trinti</button>
                            </form>
                        @else
                            <span class="text-muted small">Veiksmai negalimi</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
