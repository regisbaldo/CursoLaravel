<?php

namespace App\Http\Middleware;

use Closure;

class AlertTasks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        //lógica
        $ids = $request->session()->get('todotasks',[]);
        $tasks= count($ids);
        if($ids){
          $request->session()->flash('alert',"Você tem
          {$tasks}
          tarefas pendentes" );
        }else{
          $request->session()->flash("Você não tem tarefas
           pendentes");
        }

        return $response;
    }
}
