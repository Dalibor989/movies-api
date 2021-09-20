<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $title = $request->query('title');
        $per_page = $request->query('per_page', 10);

        $movies = Movie::search_by_title($title)->with('comments')
            ->paginate($per_page);

        return response()->json($movies);
    }

    public function show(Movie $movie)
    {
        return response()->json($movie);
    }

    public function store(CreateMovieRequest $request)
    {
        $data = $request->validated();
        $movie = Movie::create($data);
        return response()->json($movie, 201);
    }

    public function update(Movie $movie, UpdateMovieRequest $request)
    {
        $data = $request->validated();

        if (
            $request->get('title') &&
            $request->get('release_date') &&
            Movie::where('title', $request->get('title'))
            ->where('release_date', $request->get('release_date'))
            ->where('id', '!=', $movie->id)
            ->exists()
        ) {
            return response()->json([
                'message' => "Movie with the same title and release_date already exists"
            ], 400);
        }
        $movie->update($data);

        return response()->json($movie);
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response()->noContent();
    }
}
