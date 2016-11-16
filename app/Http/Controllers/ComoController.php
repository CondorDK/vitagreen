<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Como;
use Session;
use Image;
class ComoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $como = Como::all();
        return view('como.index')->withComo($como);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('como.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validando la data
        $this->validate($request, array(
                'title' => 'required|max:225',
                'body'  => 'required'
            ));

        // store en la base de datos
        $como = new Como;

        $como->title = $request->title;
        $como->body = $request->body;

        //guardar imagen
        if ($request->hasFile('featured_image')){
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(800, 400)->save($location);

            $como->image = $filename;
        }

        $como->save();

        Session::flash('success', 'El mensaje se ha enviado correctamente!');

        return redirect()->route('como.show', $como->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $como = Como::find($id);
        return view('como.show')->withComo($como);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // busca los post en la database y guarda
        $como = Como::find($id);
        // devuelve la vista
        return view('como.edit')->withComo($como);

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
        // Validando la data
        $this->validate($request, array(
                'title' => 'required|max:225',
                'body'  => 'required'
            ));

        // Guarda la data en database
        $como = Como::find($id);

        $como->title = $request->input('title');
        $como->body = $request->input('body');

        $como->save();

        // Mensaje flash
        Session::flash('success', 'Se Ha Guardo Correctamente.');



        // redirect with flash data to necesito.show
        return redirect()->route('como.show', $como->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $como = Como::find($id);

        $como->delete();

        Session::flash('success', 'El Post Ha Sido Borrado Correctamente');
        return redirect()->route('como.index');
    }
}
