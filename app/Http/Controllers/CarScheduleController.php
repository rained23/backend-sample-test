<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CarSchedule;
use App\Car;

class CarScheduleController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {            
            $request->user()->authorizeRoles(['admin']);
            return $next($request);
        });   
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'car_id' => ['required', 'exists:Cars,id'],
            'start' => ['required','date'],
            'end' =>['required','date']
        ]);
            
        $car = Car::find($data['car_id']);

        $schedule = new CarSchedule;
        $schedule->start = $data['start'];
        $schedule->end = $data['end'];
        
        $car->schedules()->save($schedule);

        return redirect()->route('cars.edit',$car->id)->with('status','Resource has been created.');
            
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,CarSchedule $schedule)
    {
        $data = request()->validate([            
            'start' => ['required','date'],
            'end' =>['required','date']
        ]);

        $schedule->update($data);

        return redirect()->route('cars.edit',$schedule->car->id)->with('status','Resource has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarSchedule $schedule)
    {
        $car = $schedule->car;        
        $schedule->delete();

        return redirect()->route('cars.edit', $car->id)->with('status','Resource has been deleted.');
    }
}
