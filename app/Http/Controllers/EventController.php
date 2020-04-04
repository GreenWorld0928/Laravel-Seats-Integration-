<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    private $key;

    public function __construct()
    {
        $this->key = env("SEATS_KEY");
    }


    /**
     * Create new chart
     * 
     * @return Illuminate\Http\Response
     */
    public function createChart(Request $request){

        // Validating the request
        $result = Validator::make($request->all(), [
            "name" => "required"
        ]);

        if($result->fails()){
            return response()->json([
                // Response data
            ], 400);
        }

        $name = $request->name;


        $seatsio = new \Seatsio\SeatsioClient($this->key); // can be found on https://app.seats.io/settings

        // Craete new chart
        $chart = $seatsio->charts->create($name);
        
        // Craete new event
        $event = $seatsio->events->create($chart->key);
        
        return response()->json([
            "success"   => true,
            "chart" => $chart, 
            "event" => $event 
        ]);
    }


    /**
     * Book a chair
     * 
     * @return Illuminate\Http\Response
     */
    public function booking(Request $request){
        // Validating the request
        $result = Validator::make($request->all(), [
            "event" => "required",
            "seats" => "required|array"
        ]);

        if($result->fails()){
            return response()->json([
                // Response error data
            ], 400);
        }

        $eventKey = $request->event;
        $seats = $request->seats;

        $seatsio = new \Seatsio\SeatsioClient($this->key);

        try{
            $r = $seatsio->events->book($eventKey, $seats);

        } catch (Exception $e){ // Booking error
            return response()->json([
                "error" => $e
            ], 400); 
        }

        return response()->json([
            "result"    => $r
        ], 201);
    }


    /**
     * Return all charts
     * 
     * @return Illuminate\Http\Response
     */
    public function allCharts(){
        $seatsio = new \Seatsio\SeatsioClient($this->key);

        $charts = $seatsio->charts->listAll();
        
        $newCharts = [];

        foreach($charts as $chart) {
            $newCharts[] = $chart;
        }
        

        return response()->json([
            "charts"    => $newCharts
        ]);
    }


}
