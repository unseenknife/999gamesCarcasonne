<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Round;
use App\Image;


class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //count how many rounds there are
        $round = Round::all()
            ->count();

        //Jennifer
        //fill variable data with Images table

        $data = [
            'images' => Image::all(),
        ];

        //if there is a round then do below
        if($round >= 1) {

            //give view index with variable data
            return view('gallery.index')->with($data);
        }
        //else redirect to home
        else{
            return redirect(route('home'));
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Jennifer
        //give view create
        return view('gallery.create');
    }


    public function store(Request $request)
    {
        //Jennifer
        //require title, description and the file

        $this->validate($request, [
            'title' => 'required',
            'file' => 'required',
        ]);

        //set variable image
        //make new line in database from model image
        //fill table title with form title
        //fill table description with form description
        //save in database
        $image = new Image();
        $image->title = $request->input('title');
        $image->save();

        //set variable path store request->file in public and save it as the title name (variable given in  form) .png
        $path = $request->file('file')->storeAs(
            'public', $image->id . '.png'
        );

        //return view index with a succes message
        return redirect('/gallerij')->with('Success', 'Foto met succes toegevoegd');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
