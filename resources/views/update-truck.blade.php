<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trucks CRUD</title>
</head>
<body>
    <div>
        <h1>Trucks CRUD - Update Truck</h1>
        <p>
            <ul>
                <li><a href='/'>Back to Home</a></li>
            </ul>
        </p>

        <!-- Update Truck Form -->
        <form action="{{ route('trucks.update', $truck->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label for="unit_number">Unit Number:</label>
                <input type="text" id="unit_number" name="unit_number" value="{{ old('unit_number', $truck->unit_number) }}" required>
            </div>

            <div>
                <label for="year">Year:</label>
                <input type="number" id="year" name="year" min="1900" max="{{ date('Y') + 5 }}" value="{{ old('year', $truck->year) }}" required>
            </div>

            <div>
                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes">{{ old('notes', $truck->notes) }}</textarea>
            </div>

            <div>
                <button type="submit">Update Truck</button>
            </div>
        </form>

        <h2>Subunits</h2>
        <table>
            <thead>
                <tr>
                    <th>Subunit</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
            </thead>
            <tbody>
                @if ($subunits->isEmpty())
                    <tr>
                        <td colspan="3">No subunits for this truck.</td>
                    </tr>
                @else
                    @foreach ($subunits as $subunit)
                        <tr>
                            <td>{{ $subunit->subunit }}</td>
                            <td>{{ $subunit->start_date }}</td>
                            <td>{{ $subunit->end_date }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Add Subunit Form -->
        <form action="{{ route('trucks.edit', $truck->id) }}" method="POST">
            @csrf
            <input type="hidden" name="add_subunit" value="1">
            <div>
                <label for="subunit">Subunit:</label>
                <select id="subunit" name="subunit" required>
                    <option value="">Select Subunit Truck</option>
                    @foreach ($allTrucks as $subunitTruck)
                        <option value="{{ $subunitTruck->id }}">{{ $subunitTruck->unit_number }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>

            <div>
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>

            <div>
                <button type="submit">Add Subunit</button>
            </div>
        </form>
    </div>
</body>
</html
