<?php

namespace App\Http\Controllers\API;

use App\User;
use Carbon\Carbon;
use App\Model\Product;
use App\Model\Category;
use App\Model\Customer;
use Barryvdh\DomPDF\PDF;
use App\Model\Transaction;
use Illuminate\Http\Request;
use App\Model\TransactionDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    //
}