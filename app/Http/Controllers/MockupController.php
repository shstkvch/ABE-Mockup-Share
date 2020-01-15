<?php

namespace App\Http\Controllers;

use App\Mockup;
use Illuminate\Http\Request;

class MockupController extends Controller
{

    public function __construct() {
        $this->middleware( 'auth.basic' )->except( [
            'index',
            'show'
        ] );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'mockup.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file( 'mockup' );

        $filename = $file->storeAs( 
            'mockups', $file->hashName()
        , 'public');

        if ( ! $filename ) {
           ddd( $filename );
        }

        $mock = new Mockup();

        // generate the mockup's private access key
        $key = bin2hex( random_bytes(32) );

        $mock->filename = $filename;
        $mock->access_key = $key;

        $mock->save();

        $url = action( 'MockupController@show', [ 'mockup' => $mock->id ] ) . '?access_key=' . $key; 

        return redirect( $url );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mockup  $mockup
     * @return \Illuminate\Http\Response
     */
    public function show(Mockup $mockup, Request $request)
    {
        if ( $request->access_key != $mockup->access_key ) {
            abort( 403 );
        }

        $url = \Storage::url( $mockup->filename );
    
        $image_path = storage_path( 'app/public/'.$mockup->filename );

        $data = getimagesize( $image_path );  

        $width = $data[0];

        if ( $request->get( '2x' ) ) {
            $width /= 2;
        }

        return view( 'mockup.show', [ 
            'url'   => $url,
            'width' => $width
        ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mockup  $mockup
     * @return \Illuminate\Http\Response
     */
    public function edit(Mockup $mockup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mockup  $mockup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mockup $mockup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mockup  $mockup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mockup $mockup)
    {
        //
    }
}
