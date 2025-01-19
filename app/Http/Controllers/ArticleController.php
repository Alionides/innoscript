<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Article::paginate(10);
    }

    public function search(Request $request)
    {
        $query = Article::query();

        if ($request->filled('keyword')) {
            $query->where('title', 'LIKE', "%{$request->keyword}%");
        }
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        return $query->paginate(10);
    }
}
