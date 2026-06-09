<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RentalController extends Controller
{
    public function myRentals()
    {
        $rentals = auth()->user()->rentals()->latest()->get();
        return view('rentals.my', compact('rentals'));
    }

    public function create()
    {
        $equipment = Equipment::where('status', 'available')->get();
        return view('rentals.create', compact('equipment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'items' => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $days = Carbon::parse($request->end_date)->diffInDays(Carbon::parse($request->start_date));
            $total = 0;

            $rental = Rental::create([
                'client_id' => auth()->id(),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => 'pending',
                'total_price' => 0,
            ]);

            foreach ($request->items as $itemId) {
                $equip = Equipment::findOrFail($itemId);
                
                if ($equip->status !== 'available') {
                    throw new \Exception('Equipo no disponible: ' . $equip->name);
                }

                $subtotal = $equip->daily_price * $days;

                RentalItem::create([
                    'rental_id' => $rental->id,
                    'equipment_id' => $equip->id,
                    'daily_price' => $equip->daily_price,
                    'days' => $days,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
                $equip->update(['status' => 'rented']);
            }

            $rental->update(['total_price' => $total]);
        });

        return redirect()->route('rentals.my')->with('success', 'Solicitud de alquiler creada');
    }
}