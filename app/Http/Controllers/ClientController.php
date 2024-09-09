<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_clients=Client::with('user')->paginate(20);
        $roles=Role::all();
        return view('clients.index',compact('all_clients','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $user= User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        $role = Role::find($request->role);
        $user->assignRole($role->name);
        $client= Client::create([
            'user_id'=>$user->id,
            'address'=>$request->address,
            'phone'=>$request->phone,
        ]);
        toastr()->success('Data has been saved successfully!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client ,$id)
    {
        if (request()->ajax()) {
            $Client = Client::with('user')->findOrFail($id);
            return response()->json($Client);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $client= Client::findOrFail($request->id);
        $client->update([
        'address'=>$request->address,
        'phone'=>$request->phone,
    ]);

        $user= User::findOrFail($client->user_id);
            $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        $user  = User::find($user->id);
        $getroles = $user->getRoleNames();
       foreach($getroles as $getrole){
         $user->removeRole($getrole);
          };
        $role = Role::find($request->role);
        $user->assignRole($role->name);
        toastr()->success('Data has been saved successfully!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Client=  Client::findOrFail($id);
        $Client->delete();
        toastr()->success('Data has been Deleted successfully!');
        return redirect()->back();
    }
}
