<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function staff(Request $request): Response
    {
        return Inertia::render('Staff/Dashboard');
    }

    public function approver(Request $request): Response
    {
        return Inertia::render('Approver/Dashboard');
    }

    public function procurement(Request $request): Response
    {
        return Inertia::render('Procurement/Dashboard');
    }

    public function vendor(Request $request): Response
    {
        return Inertia::render('Vendor/Dashboard');
    }

    public function admin(Request $request): Response
    {
        return Inertia::render('Admin/Dashboard');
    }
}
