<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Franchise;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FranchiseController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }


    public function index(){
        return view('administrator.franchise');
    }

    public function getFranchises(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = \DB::table('franchises as a')
            ->where('a.franchise_reference', 'like', $req->franchise_reference . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function show($id){
        return Franchise::find($id);
    }


    public function create(){
        return view('administrator.franchise-create-update');
    }

    public function store(Request $req){
        //return $req;

        $user = Auth::user();

        $req->validate([
            'franchise_reference' => ['required', 'unique:franchises'],
        ]);

        $date =  $req->date_acquired;
        $ndate = date("Y-m-d", strtotime($date)); //convert to date format UNIX

        /*$time = $req->app_time;
        $ntime = date('H:i:s',strtotime($time)); //convert to format time UNIX*/

        Franchise::create([
            'franchise_reference' => $req->franchise_reference,
            'date_acquired' => $ndate,
            'operator_name' => strtoupper($req->operator_name),
            'province' => strtoupper($req->province),
            'city' => strtoupper($req->city),
            'barangay' => strtoupper($req->barangay),
            'street' => strtoupper($req->street),

            'vehicle_reference' => strtoupper($req->vehicle_reference),
            'chassis_reference' => strtoupper($req->chassis_reference),
            'make' => strtoupper($req->make),
            'plate_no' => strtoupper($req->plate_no),

            'route_operation' => strtoupper($req->route_operation),
            'cab_no' => strtoupper($req->cab_no),
            'sysuser' => strtoupper($user->username),

        ]);

        return response()->json([
            'status' => 'saved'
        ],200);
    }

    public function update(Request $req, $id){
        $user = Auth::user();

        $validate = $req->validate([
            'franchise_reference' => ['required','unique:franchises,franchise_reference,' .$id .',franchise_id'],
        ]);

        $data = Franchise::find($id);
        $data->franchise_reference = $req->franchise_reference;
        $data->description = strtoupper($req->description);
        $data->sysuser = strtoupper($user->username);
        $data->save();

        return response()->json([
            'status' => 'updated'
        ],200);
    }

    public function destroy($id){
        Franchise::destroy($id);
    }

}
