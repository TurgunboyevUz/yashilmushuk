<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('status', 1)->get(['slug', 'name', 'image']);

        return view('services.index', compact('services'));
    }

    public function show(string $slug)
    {
        $service = Service::where('slug', $slug)->where('status', 1)->firstOrFail();

        return view('services.show', compact('service'));
    }
}
