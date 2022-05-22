<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LicenseResource;
use App\Models\Genre;
use App\Models\License;
use App\Models\Track;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TrackResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class TrackController extends Controller
{

    public function getTracksByGenre($genre)
    {
        try {
            $genre = Genre::findOrFail($genre);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'this genre doesn\'t exist'], 404);
        }

        $tracks = $genre->tracks;

        if ($tracks->count() === 0) {
            return response(['error' => 'No tracks yet in this genre'], 404);
        }
        return response(['tracks' => TrackResource::collection($tracks), 'message' => 'Retrieved successfully'], 200);
    }

    public function getTracksByUser(User $user)
    {
        $tracks = $user->tracks;
        if ($tracks->count() === 0) {
            return response(['error' => 'No tracks for this user yet'], 404);
        }
        return response(['tracks' => TrackResource::collection($tracks), 'message' => 'Retrieved successfully'], 200);
    }

    public function getCurrentUserTracks()
    {
        $user = JWTAuth::user();
        if ($user === null) {
            return response(['error' => 'please sign in, your token has expired'], 401);
        }
        return $this->getTracksByUser($user);
    }

    public function addToCurrentUserTracks(Request $request)
    {
        $user = JWTAuth::user();
        if ($user === null) {
            return response(['error' => 'please sign in, your token has expired'], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'type' => 'required|integer',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
            'licenses' => 'required|array',
            'licenses.*.id' => 'exists:licenses,id',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        $track = new Track;
        $track->name = $request->name;
        $track->description = $request->description;
        $track->type_id = $request->type;
        $track->user_id = $user->id;
        $track->save();
        $track->genres()->attach($request->genres);

        foreach ($request->input("licenses") as $license) {
            try {
                $track->licenses()->attach($license['id'], ['price' => $license['price']]);
            } catch (QueryException $exception) {
                return response(['error' => 'this license id doesn\'t seem to exist'], 404);
            }
        }

        return response(['track_data' => new TrackResource($track),
            'message' => 'Created successfully'], 201);
    }

    public function editTrack(Request $request, Track $track)
    {
        $user = JWTAuth::user();
        if ($user === null) {
            return response(['error' => 'please sign in, your token has expired'], 401);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'description' => 'string',
            'type' => 'integer',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
            'licenses' => 'array',
            'licenses.*.id' => 'exists:licenses,id',
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        $track = $user->tracks()->where([['user_id', '=', $user->id], ['id', '=', $track->id]])->first();
        if ($request->exists("licenses")) {
            foreach ($request->input("licenses") as $license) {
                $track->licenses()->syncWithoutDetaching([$license['id'] => ['price' => $license['price']]]);
            }
            $track->save();
        }
        if ($request->exists("type")) {
            $track->type_id = $request->type;
        }
        if ($request->exists("genres")) {
            $track->genres()->syncWithoutDetaching($request->genres);
        }
        $track->update($request->all());

        $track->save();
        return response(['updated_track' => new TrackResource($track),
            'message' => 'Updated successfully'], 200);
    }

    public function removeTrack(Track $track)
    {
        $user = JWTAuth::user();
        if ($user === null) {
            return response(['error' => 'please sign in, your token has expired'], 401);
        }
        $track = $user->tracks()->where([['user_id', '=', $user->id], ['id', '=', $track->id]])->first();
        $track->delete();
        return response(['message' => 'Deleted']);
    }

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
