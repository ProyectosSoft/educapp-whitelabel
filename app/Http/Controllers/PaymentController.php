<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout(Curso $course)
    {
      return view('payment.checkout', compact('course'));
    }
}
