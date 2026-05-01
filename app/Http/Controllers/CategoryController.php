<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth');
    }
    
	  public function index()
    {
        return view("categories.index");
    }

     public function edit($id)
    {
    	return view('categories.edit')->with('id', $id);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function listForSelect(Request $request)
    {
        $query = [
            'page' => 1,
            'page_size' => 1000,
        ];

        if ($request->filled('section')) {
            $query['section'] = $request->input('section');
        }

        $response = Http::acceptJson()
            ->timeout(15)
            ->get('https://storage.fondex.uz/api/categories/', $query);

        return response()->json($response->json(), $response->status());
    }

    public function vendorsForSelect(Request $request)
    {
        $query = [
            'page' => 1,
            'page_size' => 1000,
        ];

        if ($request->filled('section')) {
            $query['section'] = $request->input('section');
        }

        $response = Http::acceptJson()
            ->timeout(15)
            ->get('https://storage.fondex.uz/api/vendors/', $query);

        return response()->json($response->json(), $response->status());
    }

}
