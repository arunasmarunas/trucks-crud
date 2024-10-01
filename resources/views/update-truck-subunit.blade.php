<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trucks CRUD</title>
</head>
<body>
    <div>
        <h1>Trucks CRUD - Update Truck Subunit</h1>
        <p>
            <ul>
                <li><a href='/'>Back to Home</a></li>
            </ul>
        </p>

        <h2>Subunits for {{ $truck->unit_number }}</h2>

        <!-- Display Subunits -->
        <table>
            <thead>
                <tr>
                    <th>Subunit</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($subunits as $subunit)
                    <tr>
                        <td>{{ $subunit->subunit }}</td>
                        <td>{{ $subunit->start_date }}</td>
                        <td>{{ $subunit->end_date }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No subunits for this truck.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Update Truck Form -->
        <form action="{{ route('update-truck-subunit.update', $truck->id) }}" method="POST">
            @csrf <!-- CSRF token, form security -->
            @method('PUT') <!-- PUT/update request -->

            <h3>Add Subunit</h3>

            <div>
                <label for="subunit">Subunit Truck:</label>
                <!-- Dropdown menu to select subunit truck -->
                <select id="subunit" name="subunit" required>
                    <option value="">Select a truck</option>
                    @foreach ($availableTrucks as $availableTruck)
                        <option value="{{ $availableTruck->id }}" {{ old('subunit') == $availableTruck->id ? 'selected' : '' }}>
                            {{ $availableTruck->unit_number }} (ID: {{ $availableTruck->id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
            </div>

            <div>
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
            </div>

            <div>
                <button type="submit">Add Subunit</button>
            </div>
        </form>
    </div>
</body>
</html>
