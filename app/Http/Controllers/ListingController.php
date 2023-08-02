<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\House;
use App\Models\Booking;
use App\Models\Reviews;


class ListingController extends Controller
{
    public function index()
    {
        $houses = House::where(['status' => 'vacant'])->paginate(6);
        $locations = array();
        foreach($houses as $house) {
            array_push($locations, ["id" => $house->id, "lng" => $house->apartment->longitude, 'lat' => $house->apartment->latitude]);
        }
        return view("users.posts.index", ["rooms" => $houses, "mapData" => $locations]);
    }
    private function getReviews($house_id) {
        $reviews_ids = DB::table("reviews")
            ->SELECT("reviews.id")
            ->join('bookings', 'bookings.id', '=', 'reviews.booking_id')
            ->join('houses', 'houses.id', '=', 'bookings.house_id')
            ->where('houses.id', '=', $house_id)
            ->pluck('id');
        $reviews = Reviews::whereIn("id", $reviews_ids)->get();

        return $reviews;
    }
    public function show(House $house)
    {
        $reviews = $this->getReviews($house->id);
        return view("users.posts.details", ["room" => $house, 'reviews' => $reviews]);
    }

    // public function houseListingsData() {
    //     return json_encode();
    // }
    public function book(Request $request, House $room)
    {
        if ($room->status != "vacant")
            return redirect(route('list.index'))->with('error', "room no available for viewing.");

        //house_id, user_id, $requested_date
        $user_id = Auth::user()->id;
        $created = $room->bookings()->create([
            'user_id' => $user_id
        ]);
        if ($created)
            return redirect(route('bookings'))->with('success', "Booking request sent to Landlord/House manager.");
        else
            return redirect(route('list.show', $room->id))->with('error', 'Failed to save booking request.');
    }
    public function bookings()
    {
        $bookings = Booking::where(['user_id'=> Auth::user()->id])->get();
        return view("users.schedules.index", ['bookings' => $bookings]);
    }
    public function booking_show(Booking $booking)
    {
        if ($booking->user_id != Auth::user()->id)
            return redirect(route("bookings"))->with('error', "Action not allowed.");
        return view("users.schedules.details", ["booking" => $booking]);
    }
    public function search(Request $request) {
        $q = strtoupper($request->query('q'));
        $searched = DB::table("houses")
            ->join("apartments", "apartments.id", "=", "houses.apartment_id")
            ->select("houses.id")
            ->where('apartments.location', 'LIKE', '%'.$q.'%')->pluck('id');
        $houses = House::whereIn("id", $searched)->paginate(12);
        return view("users.posts.index", ["rooms" => $houses]);
    }
}
