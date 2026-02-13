<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function __construct(private User $user){}
 
  public function index()
  {
    try{
      $view = View::make('admin.users.index');

      return $view;
    }
    catch(\Exception $e){
     
    }
  }

  public function create()
  {
   
  }

  public function store(Request $request)
  {            
   
  }

  public function edit(User $user)
  {
    return response()->json(
      [
        'user' => $user
      ], 
      200
    );
  }

  public function destroy(User $user)
  {
   
  }
}