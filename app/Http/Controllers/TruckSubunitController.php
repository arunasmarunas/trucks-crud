<?php

namespace App\Http\Controllers;


use App\Models\Truck;
use App\Models\TruckSubunit;
use Illuminate\Http\Request;

class TruckSubunitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TruckSubunit $truckSubunit)
    {
        //
    }

    /**
     * Display truck's subunits.
     */
    public function edit($truckId)
    {
        // Fetch the main truck using the truckId
        $truck = Truck::findOrFail($truckId);

        // Fetch all trucks (including the current truck)
        $availableTrucks = Truck::all();

        // Retrieve all subunits associated with the truck
        $subunits = TruckSubunit::where('main_truck', $truck->id)->get();

        // Return the edit view with the truck and its subunits
        return view('update-truck-subunit', compact('truck', 'subunits', 'availableTrucks'));
    }

    /**
     * Update the truck and insert a new subunit (if provided).
     */
    public function update(Request $request, $truckId)
    {
        // Fetch the truck record from the database
        $truck = Truck::findOrFail($truckId);

        // Validate the incoming request data, focusing only on subunit validation
        $request->validate([
            'subunit' => [
                'required', // Subunit must be provided
                'exists:trucks,id', // The subunit must be a valid truck ID
            ],
            'start_date' => 'required|date|after_or_equal:today', // Start date must be today or later
            'end_date' => 'required|date|after_or_equal:start_date', // End date must be after or equal to start date
        ]);

        // Custom Validation: Prevent assigning a truck as its own subunit
        if ($request->subunit == $truck->id) {
            return back()->withErrors(['subunit' => 'The truck cannot be assigned as its own subunit.']);
        }

        // Custom Validation: Check that the subunit is not assigned to another truck during the same period
        $subunitId = $request->input('subunit');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // 1. Check if the subunit is already assigned to another truck during the given period
        $isSubunitAssigned = TruckSubunit::where('subunit', $subunitId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
            })
            ->exists();

        if ($isSubunitAssigned) {
            return back()->withErrors(['subunit' => 'This subunit is already assigned to another truck during the given period.']);
        }

        // 2. Check if the main truck has an overlapping subunit period
        $hasOverlappingSubunit = TruckSubunit::where('main_truck', $truck->id)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
            })
            ->exists();

        if ($hasOverlappingSubunit) {
            return back()->withErrors(['subunit' => 'There is an overlapping subunit period for the main truck during the given dates.']);
        }

        // 3. Check if this truck is a subunit for another truck during the same period
        $isMainTruckSubunit = TruckSubunit::where('subunit', $truck->id)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
            })
            ->exists();

        if ($isMainTruckSubunit) {
            return back()->withErrors(['subunit' => 'The main truck is already a subunit for another truck during this period and cannot have its own subunit.']);
        }

        // Create a new subunit entry
        TruckSubunit::create([
            'main_truck' => $truck->id,
            'subunit' => $subunitId,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        // Redirect back to the truck list or any other desired route
        return redirect()->route('trucks.index')->with('success', 'Subunit added successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TruckSubunit $truckSubunit)
    {
        //
    }
}
