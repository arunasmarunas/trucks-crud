<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use App\Models\TruckSubunit;
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
        // Fetch subunits for the truck
        $subunits = TruckSubunit::where('main_truck', $truck->id)->get(); // Get subunits
        $allTrucks = Truck::all(); // Get all trucks for subunit selection

        // Return the view for editing the truck along with its subunits
        return view('update-truck', compact('truck', 'subunits', 'allTrucks')); 
    }

    /**
     * Update the specified resource/truck in DB, including subunits
     */
    public function update(Request $request, Truck $truck)
    {
        // Validate the incoming request data for truck
        $request->validate([
            'unit_number' => 'required|string|max:255|unique:trucks,unit_number,' . $truck->id,
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'notes' => 'nullable|string',
            'subunit' => 'required|exists:trucks,id|not_in:' . $truck->id, // Validate subunit
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d|after_or_equal:start_date',
        ]);

        // Update the truck record in the database
        $truck->update([
            'unit_number' => $request->unit_number,
            'year' => $request->year,
            'notes' => $request->notes,
        ]);

        // Check for overlapping dates
        $overlap = TruckSubunit::where('main_truck', $truck->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()->withErrors(['overlap' => 'Subunit dates cannot overlap with existing subunits.']);
        }

        // Save the subunit to the database
        TruckSubunit::create([
            'main_truck' => $truck->id,
            'subunit' => $request->subunit,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        // Redirect to the index route with a success message
        return redirect()->route('trucks.index')->with('success', 'Truck updated successfully and subunit added!');
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