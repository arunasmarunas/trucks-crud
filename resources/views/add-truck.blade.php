<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Trucks CRUD</title>
</head>
<body>
    <div>
        <h1>Trucks CRUD - Add new Truck</h1>
        <p>
            <ul>
                <li><a href="/">Back to Home</a></li>
            </ul>
        </p>

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

        <!-- Add Truck Form -->
        <form action="{{ route('trucks.store') }}" method="POST">
            @csrf <!-- Include the CSRF token for form security -->

            <div>
                <label for="unit_number">Unit Number:</label>
                <input type="text" id="unit_number" name="unit_number" value="{{ old('unit_number') }}" required>
            </div>

            <div>
                <label for="year">Year:</label>
                <input type="number" id="year" name="year" min="1900" max="{{ date('Y') + 5 }}" value="{{ old('year') }}" required>
            </div>

            <div>
                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
            </div>

            <div>
                <button type="submit">Add Truck</button>
            </div>
        </form>
    </div>
</body>
</html>
