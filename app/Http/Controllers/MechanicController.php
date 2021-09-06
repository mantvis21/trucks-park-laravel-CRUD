<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;
use Validator;

class MechanicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mechanics = Mechanic::all();
        return view('mechanic.index', ['mechanics' => $mechanics]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mechanic.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
        'mechanic_name' => ['required', 'min:3', 'max:64'],
        'mechanic_surname' => ['required', 'min:3', 'max:64'],
        'mechanic_photo' => ['sometimes', 'mimes:jpg,png,gif']
        ],
        [
            'mechanic_name.min' => 'Mech name is shorter than 3 symbols'
        ]
        );

        if ($validator->fails()) {
        $request->flash();
        return redirect()->back()->withErrors($validator);
        }


        $mechanic = new Mechanic;

        if ($request->has('mechanic_photo')) {
            $portret = $request->file('mechanic_photo');
            $imageName = 
            $request->mechanic_name. '-' .
            $request->mechanic_surname. '-' .
            time(). '.' .
            $portret->getClientOriginalExtension();
            $path = public_path() . '/img/'; // serverio vidinis kelias
            $url = asset('img/'.$imageName); // url narsyklei (isorinis)
            $portret->move($path, $imageName); // is serverio tmp ===> i public folderi
            $mechanic->photo = $url; // irasome i DB
        }

        $mechanic->name = $request->mechanic_name;
        $mechanic->surname = $request->mechanic_surname;
        $mechanic->save();
        return redirect()->route('mechanic.index')->with('success_message', 'New mech is ON');
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mechanic  $mechanic
     * @return \Illuminate\Http\Response
     */
    public function show(Mechanic $mechanic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mechanic  $mechanic
     * @return \Illuminate\Http\Response
     */
    public function edit(Mechanic $mechanic)
    {
        return view('mechanic.edit', ['mechanic' => $mechanic]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mechanic  $mechanic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mechanic $mechanic)
    {

        $validator = Validator::make($request->all(),
        [
        'mechanic_name' => ['required', 'min:3', 'max:64'],
        'mechanic_surname' => ['required', 'min:3', 'max:64'],
        ],
        [
            'mechanic_name.min' => 'Mech name is shorter than 3 symbols'
        ]
        );

        if ($validator->fails()) {
        $request->flash();
        return redirect()->back()->withErrors($validator);
        }

        if (!$request->mechanic_photo_delete) {
            if ($request->has('mechanic_photo')) {
                if ($mechanic->photo) {
                    $imageName = explode('/', $mechanic->photo);
                    $imageName = array_pop($imageName);
                    $path = public_path() . '/img/'.$imageName;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $portret = $request->file('mechanic_photo');
                $imageName = 
                $request->mechanic_name. '-' .
                $request->mechanic_surname. '-' .
                time(). '.' .
                $portret->getClientOriginalExtension();
                $path = public_path() . '/img/'; // serverio vidinis kelias
                $url = asset('img/'.$imageName); // url narsyklei (isorinis)
                $portret->move($path, $imageName); // is serverio tmp ===> i public folderi
                $mechanic->photo = $url; // irasome i DB
            }
        } 
        else {
            if ($mechanic->photo) {
                $imageName = explode('/', $mechanic->photo);
                $imageName = array_pop($imageName);
                $path = public_path() . '/img/'.$imageName;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $mechanic->photo = null;
        }

        $mechanic->name = $request->mechanic_name;
        $mechanic->surname = $request->mechanic_surname;
        $mechanic->save();
        return redirect()->route('mechanic.index')->with('success_message', 'Mech is updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mechanic  $mechanic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mechanic $mechanic)
    {
       if ($mechanic->mechanicHasTrucks->count() == 0) {
        
        if ($mechanic->photo) {
            $imageName = explode('/', $mechanic->photo);
            $imageName = array_pop($imageName);
            $path = public_path() . '/img/'.$imageName;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $mechanic->delete();
        return redirect()->route('mechanic.index')->with('success_message', 'Mech was deleted');
       }
       return redirect()->back()->with('info_message', 'Cannot delete mech, he is busy');
    }
}
