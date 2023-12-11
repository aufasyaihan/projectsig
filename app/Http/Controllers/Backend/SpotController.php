<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Spot;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;


class SpotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $data = Spot::paginate(5);
            $point = Spot::get();
            return view("admin.backend.spot.index")->with('data', $data)->with('point', $point);
        } else {
            $data = Spot::get();
            return view("users.index")->with('data', $data);
        }
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view("admin.backend.spot.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'coordinate' => 'required',
            'name'=> 'required',
            'description'=> 'required',
            'images'=> 'file|image|mimes:png,jpg,jpeg',
        ]);
        $spot = new Spot;
        if ($request->hasFile('images')) {
            /**
             * Upload to public folder
             */
            $images = $request->file('images');
            $uploadFile = $images->hashName();
            $images->move('upload/spots/', $uploadFile);
            $spot->images = $uploadFile;
            /**
             *  Upload file image to storage
             */
            // $images = $request->file('images');
            // $images->storeAs('public/ImageSpots', $images->hashName());
            // $spot->images = $images->hashName();
        }
        $spot->name = $request->input('name');
        $spot->slug = Str::slug($request->name,'-');
        $spot->description = $request->input('description');
        $spot->coordinates = $request->input('coordinate');
        $spot->save();

        if ($spot) {
            return to_route('spot.index')->with('success','Data Berhasil Disimpan');
        } else {
            return to_route('spot.index')->with('error','Data Gagal Disimpan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $spot = Spot::findOrFail($id);
        return view('users.show', ['spot' => $spot]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Spot $spot)
    {
        $spot = Spot::findOrFail($spot->id);
        return view('admin.backend.spot.edit', ['spot'=> $spot]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Spot $spot)
    {
        $this->validate($request, [
            'coordinate'=> 'required',
            'name'=> 'required',
            'description'=> 'required',
            'images'=> '',
        ]);

        if ($request->hasFile('images')) {
            if(File::exists('upload/spots/',$spot->images)){
                File::delete('upload/spots/', $spot->images);
            }
            $file = $request->file('images');
            $uploadFile = $file->hashName();
            $file->move('upload/spots/', $uploadFile);
            $spot->images = $uploadFile;
        }

        $spot->name = $request->input('name');
        $spot->slug = Str::slug($request->name,'-');
        $spot->description = $request->input('description');
        $spot->coordinates = $request->input('coordinate');
        $spot->update();

        if ($spot) {
            return to_route('spot.index')->with('success','Data Berhasil Diupdate');
        } else {
            return to_route('spot.index')->with('error','Data Gagal Diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $spot =Spot::findOrFail($id);
        $spot->delete();
        if ($spot) {
            return redirect()->back()->with('success','Data Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error','Data Gagal Dihapus');
        }
    }
}
