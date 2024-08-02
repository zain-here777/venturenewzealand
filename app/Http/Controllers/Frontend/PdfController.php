<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use PDF;

class PdfController extends Controller
{
public function showOperatorPdf()
    {
        return view('frontend.pdf.presentation');
    }
}
