<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToDoTasksController extends Controller
{
    public function store(Request $request, $id){
      $request->session()->push('todotasks',$id);

      return redirect()->route('clients.index');
    }

    public function destroy($id){
      $ids = session('todotasks');
      $ids = array_where($ids, function($value,$key)use ($id){
        return  $value != $id;
      });
        session(['todotasks'=>$ids]);

        return redirect()->route('clients.index');
    }
}
