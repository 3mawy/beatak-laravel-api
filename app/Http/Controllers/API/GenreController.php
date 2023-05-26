<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\GenreResource;
class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $genres = Genre::all();
        return response(['genres' => GenreResource::collection($genres), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $genre = Genre::create($data);

        return response(['genre' => new GenreResource($genre), 'message' => 'Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Genre $genre
     * @return Response
     */
    public function show(Genre $genre)
    {
        return response(['genre' => new GenreResource($genre), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Genre $genre
     * @return Response
     */
    public function update(Request $request, Genre $genre)
    {
        $genre->update($request->all());

        return response(['genre' => new GenreResource($genre), 'message' => 'Update successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Genre $genre
     * @return Response
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();

        return response(['message' => 'Deleted']);
    }
}
