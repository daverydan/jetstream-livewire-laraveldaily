<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListingRequest;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listings = Listing::with('categories')->get();
        return view('listings.index', compact('listings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('listings.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreListingRequest $request)
    {
        // dd($request->all());
        // Listing::create($request->validated() + ['user_id' => auth()->id()]);
        // Listing::create($request->validated());
        // auth()->user()->listings()->create($request->validated());
        $listing = auth()->user()->listings()->create($request->validated());
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile('photo' . $i)) {
                $listing->addMediaFromRequest('photo' . $i)->toMediaCollection('listings');
            }
        }
        $listing->categories()->attach($request->categories);
        return redirect()->route('listings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function show(Listing $listing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function edit(Listing $listing)
    {
        $this->authorize('update', $listing);
        $listing->load('categories');
        $media = $listing->getMedia('listings');
        $categories = Category::all();
        return view('listings.edit', compact('listing', 'media', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function update(StoreListingRequest $request, Listing $listing)
    {
        $this->authorize('update', $listing);
        $listing->update($request->validated());
        // photos
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile('photo' . $i)) {
                $listing->addMediaFromRequest('photo' . $i)->toMediaCollection('listings');
            }
        }
        $listing->categories()->sync($request->categories);
        return redirect()->route('listings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);
        $listing->delete();
        return back();
    }

    public function deletePhoto($listingId, $photoId)
    {
        $listing = Listing::where('user_id', auth()->id())->findOrFail($listingId);
        $photo = $listing->getMedia('listings')->where('id', $photoId)->first();
        if ($photo) {
            $photo->delete();
        }
        return back();
    }
}
