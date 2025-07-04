<?php

namespace App\Http\Controllers;

use App\Models\Catalog;

class CatalogController extends Controller
{
    public function index()
    {
        $catalogs = Catalog::where('status', 1)
            ->with([
                'categories' => fn ($q) => $q->where('status', 1),
            ])->get();

        return view('catalog.index', compact('catalogs'));
    }

    public function show(string $catalog, ?string $slug = null)
    {
        $catalogs = Catalog::where('status', 1)
            ->with([
                'categories' => fn ($q) => $q->where('status', 1)->where('slug', $slug),
                'categories.products' => fn ($q) => $q->where('status', 1),
            ])->get();

        $sidebar = Catalog::where('status', 1)->with([
            'categories' => fn ($q) => $q->where('status', 1),
        ])->get();

        $products = $catalogs->first()->categories->first()->products ?? collect([]);

        return view('catalog.show', compact('catalogs', 'sidebar', 'products'));
    }
}
