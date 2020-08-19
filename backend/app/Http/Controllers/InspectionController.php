<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use DB;
use Carbon\Carbon;
use App\Inspection;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inspections = Inspection::where('status', 1)->orderby('id', 'desc')->paginate(10);

        if (!$inspections) {
            throw new NotFoundHttpException();
        } else {
        }



        $inspectionData = $inspections->toArray();
        $inspection_data = $inspectionData['data'];
        $inspection_temp = array();
        $i =0 ;
        foreach ($inspection_data as $inspection) {
            $inspection_temp[$i]['id'] = $inspection['id'];
            $inspection_temp[$i]['first_name'] = $inspection['first_name'];
            $inspection_temp[$i]['last_name'] = $inspection['last_name'];
            $inspection_temp[$i]['email'] = $inspection['email'];
            $inspection_temp[$i]['phone'] = $inspection['phone'];
            $inspection_temp[$i]['address'] = $inspection['address'];
            $inspection_temp[$i]['type'] = $inspection['type'];
            $inspection_temp[$i]['brand'] = $inspection['brand'];
            $inspection_temp[$i]['model'] = $inspection['model'];
            $inspection_temp[$i]['year_made'] = $inspection['year_made'];
            $inspection_temp[$i]['mileage'] = $inspection['mileage'];
            $inspection_temp[$i]['booking_date'] = date('Y-m-d h:i A', strtotime($inspection['booking_date']));
            $inspection_temp[$i]['inspection_slot'] = $inspection['inspection_slot'];

            $i++;
        }
        $inspectionData['data'] = $inspection_temp;

        return $inspectionData;
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
        $validator = Validator::make($request->all(), [
          'booking_date' => 'required',
          'booking_time' => 'required',
          'inspection_slot' => 'required',
          'first_name' => 'required',
          'email' => 'required',
          'phone' => 'required',
          'address' => 'required',
          'type' => 'required',
          'brand' => 'required',
          'model' => 'required',
          'year_made' => 'required',
          'mileage' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
            'status' => 0,
            'message' => 'Missing required fields'
          ]);
        }

        $datetime = $request->input('booking_date').' '.$request->input('booking_time');
        $dayName = date("l", strtotime($datetime));

        $inspections = Inspection::where('status', 1)->where('booking_date', $datetime)->where('inspection_slot', $request->input('inspection_slot'))->first();
        if ($inspections) {
            return response()->json([
            'status' => 0,
            'message' => 'Sorry inspection slot already occupied. Please check another date or time or inspection slot'
          ]);
        }


        $inspection = new Inspection;
        $inspection->first_name =  $request->input('first_name');
        $inspection->last_name =  $request->input('last_name');
        $inspection->email =  $request->input('email');
        $inspection->phone =  $request->input('phone');
        $inspection->address =  $request->input('address');
        $inspection->type =  $request->input('type');
        $inspection->brand =  $request->input('brand');
        $inspection->model =  $request->input('model');
        $inspection->year_made =  $request->input('year_made');
        $inspection->mileage =  $request->input('mileage');
        $inspection->booking_date = $request->input('booking_date').' '.$request->input('booking_time');
        $inspection->inspection_slot =  $request->input('inspection_slot');
        $inspection->status = 1;
        $inspection->created_at = Carbon::now();
        $inspection->updated_at = Carbon::now();

        if ($inspection->save()) {
            return response()->json([
              'status' => 1,
              'message' => 'Booking saved'
            ]);
        } else {
            return response()->json([
              'status' => 0,
              'message' => 'Booking not saved. Please try again'
              ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inspection = Inspection::find($id);
        return response()
        ->json([
          'status' => 'ok',
          'data' => $inspection
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function checkAvailable(Request $request)
    {
        $datetime = $request->get('datetime');
        $inspection_slot = $request->get('slot');
        $dayName = date("l", strtotime($datetime));
        $inspections = Inspection::where('status', 1)->where('booking_date', $datetime)->where('inspection_slot', $inspection_slot)->first();

        $limit = 0; // limit available
        $message = 'Booking inspection slot available';
        if ($inspections) {
            $limit = 1; // limit available
            $message = 'Sorry inspection slot already occupied. Please check another date or time or Inspection Slot';
        }

        return response()
        ->json([
          'status' => 'ok',
          'limit' => $limit,
          'message' => $message
        ]);
    }
}
