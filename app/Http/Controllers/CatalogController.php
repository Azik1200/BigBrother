<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\JsonResponse;

class CatalogController extends Controller
{
    /**
     * Return categories for the given catalog.
     */
    public function categories(Catalog $catalog): JsonResponse
    {
        return response()->json($catalog->categories);
    }
}
