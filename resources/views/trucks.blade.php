<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Trucks CRUD</title>

    </head>
    <body>
        <div>
            <h1>Trucks CRUD - List of Trucks</h1>
            <p>
                <ul>
                    <li><a href='/'>Back to Home</a></li>
                </ul>
            </p>

            <p>
                <table>
                    <thead>
                        <tr>
                            <th>Unit Number</th>
                            <th>Year</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trucks as $truck)
                            <tr>
                                <td>{{ $truck->unit_number }}</td>
                                <td>{{ $truck->year }}</td>
                                <td>{{ $truck->notes }}</td>
                                <td>
                                    <a href="{{ route('update-truck-subunit.edit', $truck->id) }}">Add subunit</a>
                                    <a href="{{ route('trucks.edit', $truck->id) }}">Edit truck</a>
                                    <form action="{{ route('trucks.destroy', $truck->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete truck</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </p>
        </div>
    </body>
</html>
