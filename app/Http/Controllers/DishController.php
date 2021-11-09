<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Dish;
use Illuminate\Support\Facades\Auth;


class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dishes = Dish::all();
        return view('restaurants.dishes.index', compact('dishes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurants.dishes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $newDish = new Dish();
        $newDish->fill($data);
        //! Se vi segna un errore su Auth non fateci caso
        $newDish->restaurant_id = Auth::id();

        // Controllo se ho ricevuto i checkbox
        $gluten_free = isset($request->gluten_free) ? 1 : 0;
        $vegan = isset($request->vegan) ? 1 : 0;
        $vegetarian = isset($request->vegetarian) ? 1 : 0;
        $available = isset($request->available) ? 1 : 0;
        $frozen = isset($request->frozen) ? 1 : 0;

        $newDish->gluten_free = $gluten_free;
        $newDish->vegan = $vegan;
        $newDish->vegetarian = $vegetarian;
        $newDish->frozen = $frozen;
        $newDish->available = $available;

        //? Non sono sicuro sia il modo migliore di controllare se è presente un'immagine
        if ($request->has('image')) {
            $img_path = Storage::put('uploads', $data['image']);
            $newDish->image = $img_path;
        }

        $newDish->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //? Vogliamo una pagina di dettaglio del piatto (per il ristoratore)?
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)
    {
        return view('restaurants.dishes.edit', compact('dish'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dish $dish)
    {
        $data = $request->all();
        $dish->fill($data);
        $dish->save();
        return redirect()->route('restaurants.dishes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        $target = Dish::find($dish->id);
        $target->delete();
        return redirect()->route('restaurants.dishes.index')->with('deleted', $dish->name);
    }
}
