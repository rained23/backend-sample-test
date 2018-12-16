<?php

namespace App\Http\Controllers;

use App\Car;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\User;

class CarController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = ['is_featured'];
        //searchable and filterable        
        $query = Car::query();
        
        if($request->has('search'))
        {  
            $search = $request->input('search');
            
            $columns = Schema::getColumnListing('Cars');
            
            foreach($columns as $column){
                $query->orWhere($column, 'LIKE', '%' . $search . '%');
            }

        }
        
        
        //can refactor        
        foreach($filters as $filter)
        {
            if($request->has($filter) && $request->input($filter) != "")
            {                
                $query->where($filter,'=',(bool) $request->input($filter));
            }
        }
            
        

        $cars = $query->get();        
        
        return view('cars.index',['cars' => $cars]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        
        return view('cars.create',['users'=>$users]);
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
            'user_id' => ['required','exists:Users,id'],
            'build' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:255'],
            'registration_no' => ['required', 'string', 'max:255'],
            'location' => ['string','nullable','json']            
        ]);

        $car = new Car;
        $car->user_id = $data['user_id'];
        $car->build = $data['build'];
        $car->model = $data['model'];
        $car->year = $data['year'];
        $car->registration_no = $data['registration_no'];
        $car->location = $data['location'];
        if($request->has('is_featured')) {
            $car->is_featured = true;
        }

        $car->save();
        


        return redirect()->route('cars.edit',$car->id)->with('status','Resource has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        $car->load(['user','schedules'=>function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        return view('cars.show',['car'=>$car]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        $users = User::all();

        return view('cars.edit',['car'=>$car, 'users'=>$users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        $data = request()->validate([
            'user_id' => ['required','exists:Users,id'],
            'build' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:255'],
            'registration_no' => ['required', 'string', 'max:255'],
            'location' => ['string','nullable','json']            
        ]);
        
        $car->user_id = $data['user_id'];
        $car->build = $data['build'];
        $car->model = $data['model'];
        $car->year = $data['year'];
        $car->registration_no = $data['registration_no'];
        $car->location = $data['location'];
        if($request->has('is_featured')) {
            $car->is_featured = true;
        }

        $car->save();   

        return redirect()->route('cars.edit',$car->id)->with('status','Resource has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {        
        $car->delete();

        return redirect()->route('cars.index')->with('status','Resource has been deleted.');
    }
}