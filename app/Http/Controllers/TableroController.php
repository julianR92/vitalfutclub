<?php


namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TableroController extends Controller
{

 /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tableros.index');
    }


}
