<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use Validator;
use PDF;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $mechanics = Mechanic::all();

        if ($request->s) {
            $trucks = Truck::where('maker', 'like', '%'.$request->s.'%')
            ->orWhere('mechanic_notices', 'like', '%'.$request->s.'%')
            ->paginate(10)->withQueryString();
            // PHP kolekcijos metodas
            // $trucks = $trucks->sortBy('maker'); 
        }
        else {

            if ($request->mechanic_id == 'all') {
                if ($request->sort_by == 'plate') {
                    if ($request->sort_dir == 'desc') {
                        $trucks = Truck::orderBy('plate', 'desc')->paginate(10)->withQueryString();
                    }
                    else {
                        $trucks = Truck::orderBy('plate')->paginate(10)->withQueryString();
                    }
                
                } 
                elseif ($request->sort_by == 'maker') {
                    if ($request->sort_dir == 'desc') {
                        $trucks = Truck::orderBy('maker', 'desc')->paginate(10)->withQueryString();
                    } else {
                        $trucks = Truck::orderBy('maker')->paginate(10)->withQueryString();
                    }
                }
                else {
                    $trucks = Truck::paginate(10)->withQueryString();
                }
            }
            elseif ($request->mechanic_id) {
                if ($request->sort_by == 'plate') {
                    if ($request->sort_dir == 'desc') {
                        $trucks = Truck::where('mechanic_id', $request->mechanic_id)->orderBy('plate', 'desc')->paginate(10)->withQueryString();
                    }
                    else {
                        $trucks = Truck::where('mechanic_id', $request->mechanic_id)->orderBy('plate')->paginate(10)->withQueryString();
                    }
                
                } 
                elseif ($request->sort_by == 'maker') {
                    if ($request->sort_dir == 'desc') {
                        $trucks = Truck::where('mechanic_id', $request->mechanic_id)->orderBy('maker', 'desc')->paginate(10)->withQueryString();
                    } else {
                        $trucks = Truck::where('mechanic_id', $request->mechanic_id)->orderBy('maker')->paginate(10)->withQueryString();
                    }
                } 
                else {
                    $trucks = Truck::paginate(10)->withQueryString();
                }
            }
            else {
                $trucks = Truck::paginate(10)->withQueryString();
            }
        }

        return view('truck.index', [
            'trucks' => $trucks,
            'sort_by' => $request->sort_by ?? 'none',
            'sort_dir' => $request->sort_dir ?? 'none',
            'mechanic_id' => $request->mechanic_id ?? 'all',
            's' => $request->s ?? '',
            'mechanics' => $mechanics,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mechanics = Mechanic::all();
        return view('truck.create', ['mechanics' => $mechanics]);

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
        'truck_maker' => ['required', 'min:3', 'max:64', 'regex:/^\D+$/'],
        'truck_plate' => ['required', 'min:7', 'max:7', 'regex:/^[A-Z]{3}-[0-9]{3}$/'],
        'truck_make_year' => ['integer', 'min:1980', 'max:2021'],
        'truck_mechanic_notices' => ['required'],
        'mechanic_id' => ['required' , 'integer']
        ],
  
        );

        if ($validator->fails()) {
        $request->flash();
        return redirect()->back()->withErrors($validator);
        }


        $truck = new Truck;
        $truck->maker = $request->truck_maker;
        $truck->plate = $request->truck_plate;
        $truck->make_year = $request->truck_make_year;
        $truck->mechanic_notices = $request->truck_mechanic_notices;
        $truck->mechanic_id = $request->mechanic_id;
        $truck->save();
        return redirect()->route('truck.index')->with('success_message', 'New truck has arrived');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function show(Truck $truck)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function edit(Truck $truck)
    {
        $mechanics = Mechanic::all();
        return view('truck.edit', ['truck' => $truck, 'mechanics' => $mechanics]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Truck $truck)
    {

        $validator = Validator::make($request->all(),
        [
        'truck_maker' => ['required', 'min:3', 'max:64', 'regex:/^\D+$/'],
        'truck_plate' => ['required', 'min:7', 'max:7', 'regex:/^[A-Z]{3}-[0-9]{3}$/'],
        'truck_make_year' => ['integer', 'min:1980', 'max:2021'],
        'truck_mechanic_notices' => ['required'],
        'mechanic_id' => ['required' , 'integer']
        ],
  
        );

        if ($validator->fails()) {
        $request->flash();
        return redirect()->back()->withErrors($validator);
        }

        $truck->maker = $request->truck_maker;
        $truck->plate = $request->truck_plate;
        $truck->make_year = $request->truck_make_year;
        $truck->mechanic_notices = $request->truck_mechanic_notices;
        $truck->mechanic_id = $request->mechanic_id;
        $truck->save();
        return redirect()->route('truck.index')->with('success_message', 'Truck was eddited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function destroy(Truck $truck)
    {
        $truck->delete();
        return redirect()->route('truck.index')->with('success_message', 'Truck was deleted');
    }

    public function pdf (Truck $truck) {

        $pdf = PDF::loadView('truck.pdf', ['truck' => $truck]);
        return $pdf->download('Truck-'.$truck->id.'.pdf');
    }
}
