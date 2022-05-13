<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LicenseResource;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TrackResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tracks = Track::all();
        return response(['tracks' => TrackResource::collection($tracks), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    //TODO:: store data accordingly
    public function store(Request $request)
    {
        $user = JWTAuth::user();
        if ($user === null) {
            return response(['error' => 'please sign in'], 301);
        }
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'artist_id' => 'required',
            'genre_id' => 'required',
            'type_id' => 'required',
            'licenses' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $track = Track::create($data);
        if ($request->exists("licenses")) {
        foreach ($request->input("licenses") as $license) {
            $track->licenses()->attach($license['id'], ['price' => $license['price']]);
        }
            $track->save();
        }
        return response(['track_data' => new TrackResource($track),
            'message' => 'Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Track $track
     * @return Response
     */
    public function show(Track $track)
    {
        return response(['track' => new TrackResource($track), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Track $track
     * @return Response
     */
    public function update(Request $request, Track $track)
    {
        $track->update($request->all());

        return response(['track' => new TrackResource($track), 'message' => 'Update successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Track $track
     * @return Response
     */
    public function destroy(Track $track)
    {
        $track->delete();

        return response(['message' => 'Deleted']);
    }
}
