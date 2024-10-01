<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Trucks CRUD</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            Trucks CRUD - List of Trucks
            <p>
                <ul>
                    <li><a href='/'>Back to Home</a></li>
                </ul>
            </p>

            <p>
                <table class="table">
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
                                    <a href="{{ route('trucks.edit', $truck->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('trucks.destroy', $truck->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
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
