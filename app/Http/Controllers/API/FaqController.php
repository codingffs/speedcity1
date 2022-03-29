<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Categorysubfaq;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    public function index1()
    {
        $faq = Faq::with(['sub_faq'])->get();
        return $faq;
    } 
    

}
