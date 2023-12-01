<?php

namespace App\Http\Controllers;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MangaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $manga = Manga::all();

        return $manga;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $number)
    {
        $titles = [];

        foreach (range(1, $number) as $index) {
            $name = Str::random(8);
            $description = Str::random(20);
            $category = Str::random(5);

            $manga = Manga::create([
                'name' => $name,
                'category' => $category,
                'description' => $description,
            ]);

            $titles[] = $manga->name;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'data manga successfully inserted',
            'number' => $number,
            'titles' => $titles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $name = $request->name;
        $description = $request->description;
        $category = $request->category;

        // dd($name);

        $manga = Manga::where('name', $name)->first();

        if ($manga) {
            return response()->json([
                'status' => 'failed',
                'message' => 'data exist cannot insert'
            ]);
        }

        $manga = Manga::create([
            'name' => $name,
            'category' => $category,
            'description' => $description,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'manga successfully created',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $manga = Manga::find($id);

        if (!$manga) {
            return response()->json([
                'status' => 'failed',
                'message' => 'manga not found',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'dasta found',
            'data' => $manga,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deletedManga = Manga::where('id', $id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'data is deleted',
            'data_id' => $id,
        ]);
    }
}
