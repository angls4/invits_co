<?php

namespace App\Http\Controllers\ApiControllers;

use App\Models\WeddingGallery;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// Models
use App\Models\Guest;
use App\Models\Order;
use App\Models\Wedding;
use App\Models\WeddingLoveStory;

class WeddingController extends Controller
{
    public function index()
    {
        try {
            $weddings = Wedding::all();

            $data = [
                'weddings' => $weddings,
            ];

            return $this->jsonResponse($data, 'Weddings retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve weddings', [$e->getMessage()], false, 500);
        }
    }

    public function show($id)
    {
        try {
            $wedding = Wedding::find($id);

            if (!$wedding) {
                return $this->jsonResponse(null, 'Wedding not found', [], false, 404);
            }

            $data = [
                'wedding' => $wedding,
            ];

            return $this->jsonResponse($data, 'Wedding retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve the wedding', [$e->getMessage()], false, 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable',
            'location' => 'nullable',
            'location_gmap' => 'nullable',
            'rekening_gift' => 'nullable',
            'invitation_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $wedding = Wedding::create($request->all());

            $data = [
                'wedding' => $wedding,
            ];

            return $this->jsonResponse($data, 'Wedding created successfully', [], true, 201);
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to create the wedding', [$e->getMessage()], false, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $wedding = Wedding::find($id);

        if (!$wedding) {
            return $this->jsonResponse(null, 'Wedding not found', [], false, 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'nullable',
            'location' => 'nullable',
            'location_gmap' => 'nullable',
            'rekening_gift' => 'nullable',
            'invitation_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $wedding->update($request->all());

            $data = [
                'wedding' => $wedding,
            ];

            return $this->jsonResponse($data, 'Wedding updated successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to update the wedding', [$e->getMessage()], false, 500);
        }
    }

    public function destroy($id)
    {
        $wedding = Wedding::find($id);

        if (!$wedding) {
            return $this->jsonResponse(null, 'Wedding not found', [], false, 404);
        }

        try {
            $wedding->delete();
            return $this->jsonResponse(null, 'Wedding deleted successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to delete the wedding', [$e->getMessage()], false, 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Wedding - Order
    |--------------------------------------------------------------------------
    */
    public function get_by_order_id($order_id)
    {
        try {
            $order = Order::with(
                'user', 
                'package', 
                'theme',
                'payment', 
                'invitation',
                'invitation.type', 
                'invitation.wedding', 
                'invitation.wedding.groom',
                'invitation.wedding.bride',
                'invitation.wedding.wish',
                'invitation.wedding.gift',
                'invitation.wedding.event',
                'invitation.wedding.love_story',
                'invitation.wedding.gallery',
            )->find($order_id);
            
            if (!$order) {
                return $this->jsonResponse(null, 'Order not found', [], false, 404);
            }

            $guests = Guest::where('invitation_id', $order->invitation->id)->orderBy('id', 'desc')->limit(10)->get();
            $guests_count = Guest::where('invitation_id', $order->invitation->id)->count();


            $data = [
                'order' => $order,
                'guests' => $guests,
                'guests_count' => $guests_count,
            ];

            return $this->jsonResponse($data, 'Wedding retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve the wedding', [$e->getMessage()], false, 500);
        }
    }

    public function update_by_order_id(Request $request, $order_id)
    {
        // return $this->jsonResponse($request->all(), 'Wedding updated successfully');
       
        $order = Order::with('invitation.wedding')->find($order_id);
            
        if (!$order) {
            return $this->jsonResponse(null, 'Order not found', [], false, 404);
        }

        try {
            /*
            |==============================
            |  Variable Declaration
            |==============================
            */
            $invitation = $order->invitation;
            $wedding = $invitation->wedding;
            $groom = $wedding->groom;
            $bride = $wedding->bride;
            $events = $wedding->event;
            $love_stories = $wedding->love_story;
            $galleries = $wedding->gallery;
            
            DB::beginTransaction();

            /*
            |==============================
            |  Invitation
            |==============================
            */
            $invitation->status = 'ACTIVE';
            $invitation->slug = $request->slug;

            /*
            |==============================
            |  Wedding
            |==============================
            */
            $wedding->title = $request->title;
            $wedding->location = $request->location;
            $wedding->location_gmap = $request->location_gmap;
            $wedding->rekening_gift = $request->rekening_gift;

            /*
            |==============================
            |  Groom
            |==============================
            */
            $groom->name = $request->groom_name;
            $groom->father = $request->groom_father;
            $groom->mother = $request->groom_mother;
            $groom->address = $request->groom_address;
            $groom->instagram = $request->groom_instagram;
            $groom->image = $request->groom_image;

            /*
            |==============================
            |  Bride
            |==============================
            */
            $bride->name = $request->bride_name;
            $bride->father = $request->bride_father;
            $bride->mother = $request->bride_mother;
            $bride->address = $request->bride_address;
            $bride->instagram = $request->bride_instagram;
            $bride->image = $request->bride_image;

            /*
            |==============================
            |  Events
            |==============================
            */
            // Akad
            $events[0]->date = Carbon::parse($request->date_akad)->format('Y-m-d H:i:s');
            $events[0]->start_time = $request->start_time_akad;
            $events[0]->end_time = $request->end_time_akad;
            $events[0]->place = $request->place_akad;

            // Resepsi
            $events[1]->date = Carbon::parse($request->date_resepsi)->format('Y-m-d H:i:s');
            $events[1]->start_time = $request->start_time_resepsi;
            $events[1]->end_time = $request->end_time_resepsi;
            $events[1]->place = $request->place_resepsi;

            // Unduh Mantu
            $events[2]->date = Carbon::parse($request->date_unduh_mantu)->format('Y-m-d H:i:s');
            $events[2]->start_time = $request->start_time_unduh_mantu;
            $events[2]->end_time = $request->end_time_unduh_mantu;
            $events[2]->place = $request->place_unduh_mantu;

            /*
            |==============================
            |  Love Stories
            |==============================
            */
            WeddingLoveStory::update_or_create($wedding, $request);
            WeddingLoveStory::delete_not_in_request($love_stories, $request);

            /*
            |==============================
            |  Gallery
            |==============================
            */
            WeddingGallery::update_or_create($wedding, $request);
            WeddingGallery::delete_not_in_request($galleries, $request);

            /*
            |==============================
            |  Save Changes
            |==============================
            */
            $invitation->save();
            $wedding->save();
            $groom->save();
            $bride->save();
            foreach ($events as $event) {
                $event->save();
            }

            DB::commit();

            $order = Order::with(
                'invitation.wedding',
                'invitation.wedding.groom',
                'invitation.wedding.bride',
                'invitation.wedding.event',
                'invitation.wedding.love_story',
                'invitation.wedding.gallery',
            )->find($order_id);

            $data = [
                'order' => $order,
            ];

            return $this->jsonResponse($data, 'Wedding updated successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to update the wedding', [$e->getMessage()], false, 500);
        }
    }
}