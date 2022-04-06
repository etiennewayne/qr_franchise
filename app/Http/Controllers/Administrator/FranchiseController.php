<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Franchise;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $user = Auth::user();

        $req->validate([
            'franchise_reference' => ['required', 'unique:franchises'],
        ]);

        Franchise::create([
            'franchise_reference' => $req->franchise_reference,
            'description' => strtoupper($req->description),
            'sysuser' => strtoupper($user->username)
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
