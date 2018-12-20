<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CarSchedule;
use App\Car;
use Carbon\Carbon;

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
    

    public function index(Request $request)
    {
        $filterRelations = ['car'];

        $query = CarSchedule::query();
        
        if($request->has('search'))
        {  
            $search = $request->input('search');
            
            if(strpos($search,'date'))
            {                         
                $date = trim(str_replace_array($date,['date:','date :']));                
                $query->orWhereBetween('start',[Carbon::parse($search)->startOfDay(),Carbon::parse($search)->endOfDay()]);
                $query->orWhereBetween('end',[Carbon::parse($search)->startOfDay(),Carbon::parse($search)->endOfDay()]);

            }

            foreach($filterRelations as $filter)
            {
                
                    $value = $request->input('search');
                    $foreignKey = str_singular($filter).'_id';
                    $query->orWhereHas($filter, function($query) use ($foreignKey,$value){
                        $query->where('registration_no','LIKE','%'.$value.'%');
                    });                
            }

        }

        $schedules = $query->get();
        
        return view('schedules.index',['schedules'=>$schedules]);
    }

    public function create()
    {
        $cars = Car::all();
        
        return view('schedules.create',['cars'=>$cars]);
    }

    public function show(CarSchedule $schedule)
    {
        $schedule->load('car');
        $cars = Car::all();

        return view('schedules.show',['cars'=>$cars, 'schedule'=>$schedule]);
    }

    public function edit(CarSchedule $schedule)
    {
        $schedule->load('car');
        $cars = Car::all();

        return view('schedules.edit',['cars'=>$cars, 'schedule'=>$schedule]);
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
            'end' =>['required','date','after:start']
        ]);
            
        $car = Car::find($data['car_id']);        
        $schedule = new CarSchedule;
        $schedule->start = Carbon::parse($data['start']);
        $schedule->end = Carbon::parse($data['end']);
        
        $car->schedules()->save($schedule);

        return redirect()->route('schedules.edit',$schedule->id)->with('status','Resource has been created.');
            
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
            'car_id' => ['required', 'exists:Cars,id'],
            'start' => ['required','date'],
            'end' =>['required','date','after:start']
        ]);

        $data['start'] = Carbon::parse($data['start']);
        $data['end'] = Carbon::parse($data['end']);

        $schedule->update($data);

        return redirect()->route('schedules.edit',$schedule->id)->with('status','Resource has been updated.');
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

        return redirect()->route('schedules.index')->with('status','Resource has been deleted.');
    }
}
