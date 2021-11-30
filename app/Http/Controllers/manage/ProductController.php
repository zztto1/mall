<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class ProductController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index(){
    return view('manage.m_product');
  }
}
