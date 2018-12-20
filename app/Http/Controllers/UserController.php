<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Role;
use App\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class UserController extends Controller
{

    protected $user;

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
        
        $roles= Role::all();
        $tags = Tag::all();
        //specify filterable column
        $filters = ['type'];
        $filterRelations = ['roles','tags'];
        
        //searchable and filterable    
        $query = User::query();
        if($request->has('search'))
        {  
            $columns = Schema::getColumnListing('Users');
            
            foreach($columns as $column){
                $query->orWhere($column, 'LIKE', '%' . $request->input('search') . '%');
            }

            foreach($filterRelations as $filter)
            {
                
                    $value = $request->input('search');
                    $foreignKey = str_singular($filter).'_id';
                    $query->orWhereHas($filter, function($query) use ($foreignKey,$value){
                        $query->where('name','LIKE','%'.$value.'%');
                    });                
            }
        }        
        
        //can refactor
        if($request->has('type') || $request->has('roles') || $request->has('tags')) {
            foreach($filters as $filter)
            {
                if($request->has($filter) && $request->input($filter) != "")
                {                    
                    $query->where($filter,'=',$request->input($filter));
                }
            }

            foreach($filterRelations as $filter)
            {
                if($request->has($filter) && $request->input($filter) != "")
                {
                    $value = $request->input($filter);
                    $foreignKey = str_singular($filter).'_id';
                    $query->whereHas($filter, function($query) use ($foreignKey,$value){
                        $query->where($foreignKey,'=',$value);
                    });
                }
            }
        }
        
        $users = $query->get();
        
        return view('users.index',['users' => $users,'roles'=>$roles, 'tags'=>$tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles= Role::all();
        $tags = Tag::all();
        
        return view('users.create', ['roles'=>$roles,'tags'=>$tags]);
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:Users'],
            'phone' => ['required', 'string','min:7', 'max:255', 'unique:Users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'type' => ['required', 'in:Business,Product'],
            'roles.*' => ['distinct','exists:Roles,id'],
            'tags.*' => ['distinct', 'exists:Tags,id']
        ]);

        $user = User::create([
            'type' => $data['type'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],            
            'password' => Hash::make($data['password']),
        ]);
        
        $roles = $tags = [];
        if(request()->has('roles')){
            $roles= $data['roles'];
        }

        if(request()->has('tags')) {
            $tags = $data['tags'];
        }

        $user->roles()->sync($roles);
        $user->tags()->sync($tags);

        return redirect()->route('users.edit',$user->id)->with('status','Resource has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show',['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $tags = Tag::all();
        $roles = Role::all();
        $userRoles = $user->roles()->allRelatedIds()->toArray();
        $userTags = $user->tags()->allRelatedIds()->toArray();
        return view('users.edit',['user'=>$user,'roles'=>$roles,'tags'=>$tags,'userRoles'=>$userRoles,'userTags'=>$userTags]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required_without:phone', 'string', 'email', 'max:255',   Rule::unique('Users')->ignore($user->id)],
            'phone' => ['required','string','min:7','max:255', Rule::unique('Users')->ignore($user->id)],
            'password' => ['nullable','string', 'min:6'],
            'type' => ['required', 'in:Business,Product'],
            'roles.*' => ['distinct','exists:Roles,id'],
            'tags.*' => ['distinct', 'exists:Tags,id']
        ]);

        if($data['password']) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update(array_filter($data));        
        $roles= $tags = [];
        if(request()->has('roles')){
            $roles= $data['roles'];
        }
        if(request()->has('tags')){
            $tags= $data['tags'];
        }

        $user->roles()->sync($roles);
        $user->tags()->sync($tags);

        return redirect()->route('users.edit',$user->id)->with('status','Resource has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {        
        $user->delete();

        return response()->json(['status'=>'Resource has been deleted.']);
    }    

    public function tag()
    {
        $data = request()->validate([
            'ids' => ['required'],
            'ids.*'=> ['distinct', 'exists:Users,id'],
            'tag_name' => ['required']
        ]);
                    
        $status = Artisan::call('user:tags', [
            'users'=> $data['ids'],
            '-T'=> $data['tag_name']
            ]);

        return response()->json(['status'=>!$status]);
    }
    
}
