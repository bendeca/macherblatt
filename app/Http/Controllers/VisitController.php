<?php

namespace App\Http\Controllers;

use \Datetime;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //
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
    public function checkin(Request $request)
    {
        $visit = new Visit();
        $visit->setAttribute('webling_user_id', $request->get('webling_user_id'));
        // $visit->setAttribute('workshops', json_encode($request->get('workshops')));
        $visit->setAttribute('checkin', date('Y-m-d H:i:s'));
        $visit->save();
        return true;
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request)
    {
        $visit = Visit::where('webling_user_id', $request->get('webling_user_id'))->orderBy('id', 'desc')->first();
        if($visit && $this->wasToday($visit->checkin)) {
            $visit->setAttribute('workshops', json_encode($request->get('workshops')));
            $visit->setAttribute('checkout', date('Y-m-d H:i:s'));
            $visit->save();
            return true;
        }
        return 'false';
    }


    private function wasToday($date) {
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        $now = new DateTime();
        return $date->getTimestamp() < $now->getTimestamp() && $date->format('Y-m-d') === $now->format('Y-m-d');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visit = Visit::where('id', $id)->first();
        return json_decode($visit->workshops);
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
}
