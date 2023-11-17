<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\Wish;
use App\Models\Wedding;
use Illuminate\Support\Facades\Validator;

class WishController extends Controller
{
    public function index()
    {
        try {
            $wishes = Wish::all();

            $data = [
                'wishes' => $wishes,
            ];

            return $this->jsonResponse($data, 'Wishes retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve wishes', [$e->getMessage()], false, 500);
        }
    }

    public function show($id)
    {
        try {
            $wish = Wish::find($id);

            if (!$wish) {
                return $this->jsonResponse(null, 'Wish not found', [], false, 404);
            }

            $data = [
                'wish' => $wish,
            ];

            return $this->jsonResponse($data, 'Wish retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve the wish', [$e->getMessage()], false, 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|filled',
            'from' => 'nullable|string|filled',
            'wish' => 'required|string|filled',
            'wedding_id' => 'required|exists:weddings,id',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $name = $request->name;
            $from = $request->from;
            $wish = $request->wish;
            $wedding_id = $request->wedding_id;


            if($request->anonymous){
                $name = 'Anonim';
                $from = null;
            };

            DB::beginTransaction();
            
            // Create RSVP
            $wish = Wish::create([
                'name' => $name,
                'from' => $from,
                'wish' => $wish,
                'wedding_id' => $wedding_id,
            ]);
            
            DB::commit();

            $data = [
                'wish' => $wish,
            ];

            return $this->jsonResponse($data, 'Wish created successfully', null, true, 201);
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to create the wish', [$e->getMessage()], false, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $wish = Wish::find($id);

        if (!$wish) {
            return $this->jsonResponse(null, 'Wish not found', [], false, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string',
            'from' => 'nullable|string',
            'wish' => 'required|string',
            'wedding_id' => 'required|exists:weddings,id',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $wish->update($request->all());

            $data = [
                'wish' => $wish,
            ];

            return $this->jsonResponse($data, 'Wish updated successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to update the wish', [$e->getMessage()], false, 500);
        }
    }

    public function destroy($id)
    {
        $wish = Wish::find($id);

        if (!$wish) {
            return $this->jsonResponse(null, 'Wish not found', [], false, 404);
        }

        try {
            $wish->delete();
            return $this->jsonResponse(null, 'Wish deleted successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to delete the wish', [$e->getMessage()], false, 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Wish - Wedding
    |--------------------------------------------------------------------------
    */
    public function get_by_wedding_id($wedding_id)
    {
        try {
            $wedding= Wedding::where('id', $wedding_id)->first();

            if (!$wedding) {
                return $this->jsonResponse(null, 'Wedding not found', [], false, 404);
            }

            $wishes = Wish::where('wedding_id', $wedding_id)->get();

            $data = [
                'wishes' => $wishes,
            ];

            return $this->jsonResponse($data, 'Wishes by wedding id retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve wishes by wedding id', [$e->getMessage()], false, 500);
        }
    }
}
