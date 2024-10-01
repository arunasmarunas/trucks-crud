<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    /**
     * Display a list of trucks
     */
    public function index()
    {
        // Retrieve all trucks from the database
        $trucks = Truck::all(); // Fetch all truck records

        // Return the view with the trucks data
        return view('trucks', compact('trucks'));
    }

    /**
     * Show the create new resource/truck form
     */
    public function create()
    {
        return view('/add-truck'); // Return the form view for creating a new truck
    }

    /**
     * Insert a new resource/truck into DB
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'unit_number' => 'required|string|max:255|unique:trucks,unit_number',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'notes' => 'nullable|string',
        ]);

        // Create a new truck record in the database
        Truck::create([
            'unit_number' => $request->unit_number,
            'year' => $request->year,
            'notes' => $request->notes,
        ]);

        // Redirect to the index route with a success message
        return redirect()->route('trucks.index')->with('success', 'Truck created successfully!');
    }

    /**
     * Display the specified resource/truck
     */
    public function show(Truck $truck)
    {
        return view('update_truck', compact('truck')); // Return the view for displaying a specific truck
    }

    /**
     * Show the update form for editing the specified resource/truck
     */
    public function edit(Truck $truck)
    {
        return view('update-truck', compact('truck')); // Return the form view for editing a truck
    }

    /**
     * Update the specified resource/truck in DB
     */
    public function update(Request $request, Truck $truck)
    {
        // Validate the incoming request data
        $request->validate([
            'unit_number' => 'required|string|max:255|unique:trucks,unit_number,' . $truck->id,
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'notes' => 'nullable|string',
        ]);

        // Update the truck record in the database
        $truck->update([
            'unit_number' => $request->unit_number,
            'year' => $request->year,
            'notes' => $request->notes,
        ]);

        // Redirect to the index route with a success message
        return redirect()->route('trucks.index')->with('success', 'Truck updated successfully!');
    }

    /**
     * Delete truck
     */
    public function destroy(Truck $truck)
    {
        $truck->delete(); // Delete the truck record

        // Redirect to the index route with a success message
        return redirect()->route('trucks.index')->with('success', 'Truck deleted successfully!');
    }
}