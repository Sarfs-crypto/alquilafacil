<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::where('client_id', Auth::id())->latest()->get();
        return view('rentals.index', compact('rentals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Lógica de negocio central: verificar disponibilidad
        $overlap = Rental::where('property_id', $validated['property_id'])
            ->where('status', '!=', 'cancelled')
            ->where(function($q) use ($validated) {
                $q->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                  ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
            })->exists();

        if ($overlap) {
            return back()->withErrors(['dates' => 'Fechas no disponibles.']);
        }

        $property = Property::findOrFail($validated['property_id']);
        $days = Carbon::parse($validated['end_date'])->diffInDays(Carbon::parse($validated['start_date']));

        $validated['client_id'] = Auth::id();
        $validated['status'] = 'pending';
        $validated['total_price'] = $property->price_per_night * $days;

        Rental::create($validated);

        return redirect()->route('rentals.index')->with('success', 'Reserva creada exitosamente');
    }

    // Agrega más métodos según necesites
}