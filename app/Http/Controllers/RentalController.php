<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Equipment;
use App\Models\RentalItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    // Cliente: ver mis alquileres
    public function index()
    {
        $rentals = Rental::where('client_id', auth()->id())
            ->with('items.equipment')
            ->latest()
            ->get();
        return view('mis-alquileres', compact('rentals'));
    }

    // Cliente: formulario de creación
    public function create()
    {
        $equipment = Equipment::where('status', 'available')->get();
        return view('rentals.create', compact('equipment'));
    }

    // Cliente: guardar solicitud
    public function store(Request $request)
    {
        $request->validate([
            'equipment_ids' => 'required|array|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        DB::transaction(function () use ($request) {
            $days = Carbon::parse($request->start_date)
                ->diffInDays(Carbon::parse($request->end_date));

            $rental = Rental::create([
                'client_id' => auth()->id(),
                'status' => 'pending',
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_price' => 0,
                'notes' => $request->notes
            ]);

            $total = 0;
            foreach ($request->equipment_ids as $equipId) {
                $equip = Equipment::findOrFail($equipId);
                if ($equip->status !== 'available') {
                    throw new \Exception("El equipo {$equip->name} no está disponible.");
                }
                $subtotal = $equip->daily_price * $days;
                RentalItem::create([
                    'rental_id' => $rental->id,
                    'equipment_id' => $equipId,
                    'daily_price' => $equip->daily_price,
                    'days' => $days,
                    'subtotal' => $subtotal
                ]);
                $total += $subtotal;
            }
            $rental->update(['total_price' => $total]);
        });

        return redirect()->route('rentals.index')
            ->with('success', 'Solicitud creada exitosamente.');
    }

    // Cliente: cancelar alquiler pendiente
    public function cancel($id)
    {
        $rental = Rental::where('client_id', auth()->id())->findOrFail($id);
        if ($rental->status !== 'pending') {
            return back()->withErrors('Solo se pueden cancelar alquileres pendientes.');
        }
        $rental->update(['status' => 'cancelled']);
        return back()->with('success', 'Alquiler cancelado.');
    }

    // Admin: ver todas las solicitudes
    public function adminIndex()
    {
        $rentals = Rental::with('client', 'items.equipment')->latest()->get();
        return view('admin.solicitudes', compact('rentals'));
    }

    // Admin: aprobar solicitud
    public function approve($id)
    {
        $rental = Rental::findOrFail($id);
        if ($rental->status !== 'pending') {
            return back()->withErrors('La solicitud no está pendiente.');
        }

        foreach ($rental->items as $item) {
            $equip = $item->equipment;
            if ($equip->status !== 'available') {
                return back()->withErrors("El equipo {$equip->name} ya no está disponible.");
            }
            $equip->update(['status' => 'rented']);
        }

        $rental->update(['status' => 'active']);
        return back()->with('success', 'Alquiler aprobado.');
    }

    // Admin: registrar devolución
    public function return($id)
    {
        $rental = Rental::findOrFail($id);
        if ($rental->status !== 'active') {
            return back()->withErrors('Solo se pueden devolver alquileres activos.');
        }

        foreach ($rental->items as $item) {
            $item->equipment->update(['status' => 'available']);
        }

        $rental->update(['status' => 'returned']);
        return back()->with('success', 'Devolución registrada.');
    }
}