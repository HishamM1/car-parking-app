<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ParkingResource;
use App\Models\Parking;
use App\Services\ParkingPriceService;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    public function index()
    {
        $activeParkings = Parking::with('vehicle','zone')->active()->latest('start_time')->get();
        return ParkingResource::collection($activeParkings);
    }
    public function history()
    {
        $stoppedParkings = Parking::with('vehicle','zone')->stopped()->latest('start_time')->get();
        return ParkingResource::collection($stoppedParkings);
    }
    public function show(Parking $parking)
    {
        $parking->load('vehicle','zone');
        return ParkingResource::make($parking);
    }
    public function start(Request $request)
    {
        $parkingData = $request->validate([
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'zone_id' => ['required', 'integer', 'exists:zones,id'],
        ]);

        if(Parking::active()->where('vehicle_id', $request->vehicle_id)->exists()) {
            return response()->json([
                'errors' => ['general' =>['Vehicle is already parked']],
            ], 422);
        }

        $parking = Parking::create($parkingData);

        $parking->load('vehicle', 'zone');

        return ParkingResource::make($parking);
    }

    public function stop(Parking $parking)
    {
        $parking->update([
            'stop_time' => now(),
            'total_price' => ParkingPriceService::calculatePrice($parking->zone_id, $parking->start_time)
        ]);

        return ParkingResource::make($parking);
    }
}