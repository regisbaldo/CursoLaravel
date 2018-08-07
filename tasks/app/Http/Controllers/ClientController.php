<?php

namespace App\Http\Controllers;

use Validator;
use App\Client;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $request->session()->put('framework','Laravel');
      session(['versao'=>'5.5']);
        $clients = Client::get();

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        echo $request->session()->get('framework');
      if($request->session()->has('versao')){
        echo "existe versão";
      }
      else {
        echo "não existe versão";
      }

        echo $request->session()->pull('versao');

        echo "<pre>";
        print_r($request->session()->all());
        echo "</pre>";

        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {

        $client = new Client;

        if ($request->hasFile('photo')) {
            $client->photo = $request->photo->store('public');
        }

        $client->name = $request->input("name");
        $client->email = $request->input("email");
        $client->age = $request->input("age");
        $client->save();

        return redirect()->route('clients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::findOrFail($id);

        return view('clients.edit', compact('client'));
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

      Validator::make($request->all(),[
        'name'=>['required', 'max:100', 'min:3'],
        'email'=>['required', 'email','unique:clients'],
        'age'=>['required', 'integer'],
        'photo'=>['mimes:jpeg,bmp,png']
      ])->validate();



        $client = Client::findOrFail($id);

        if ($request->hasFile('photo')) {
            $client->photo = $request->photo->store('public');
        }

        $client->name = $request->input("name");
        $client->email = $request->input("email");
        $client->age = $request->input("age");
        $client->save();

        return redirect()->route('clients.index');
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
