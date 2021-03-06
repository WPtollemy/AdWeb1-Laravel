<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dvd;

class DvdsController extends Controller
{

    public function create()
    {
        request()->validate([
            'title'=> 'required',
            'description' => ['required', 'min:4']
        ]);

        $dvd = new Dvd();
        $dvd->title = request('title');
        $dvd->description = request('description');
        $dvd->save();

        return redirect('/');;
    }

    public function update($id)
    {
        request()->validate([
            'title'=> 'required',
            'description' => ['required', 'min:4']
        ]);

        $dvd = Dvd::find($id);

        $dvd->title = request('title');
        $dvd->description = request('description');

        $dvd->save();

        return redirect('/');
    }

    //Gets the edit form to update films
    public function edit($id)
    {
        $dvd = Dvd::find($id);

        return view('dvds.edit', compact('dvd'));
    }

    public function destroy($id)
    {
        Dvd::find($id)->delete();

        return redirect('/');
    }

    //Home page gets all DVDs
    public function home()
    {
        $dvds = Dvd::all();

        return view('dvds.dvds', compact('dvds'));
    }

    //Search is a search by title method
    public function search()
    {
        $dvds = new Dvd();
        $searchKey = request('searchTitle');

        //If search term is nothing just display all DVDs
        if ($searchKey == '') {
            return redirect('/');
        }

        //Search for similar values not exact
        $dvds = $dvds->where('title', 'LIKE', '%'.$searchKey.'%')->get(); 

        return view('dvds.dvds', compact('dvds'));
    }
}
