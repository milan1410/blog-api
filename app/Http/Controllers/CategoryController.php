<?php

namespace App\Http\Controllers;

use App\Models\TermTaxonomy;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Fetch top-level categories (parent = 0)
        $categories = TermTaxonomy::with('term')->where('taxonomy', 'category')->where('parent', 0)->get();

        $nestedCategories = $categories->map(function ($category) {
            return $this->buildCategoryTree($category);
        });

        return response()->json($nestedCategories);
    }

    private function buildCategoryTree($category)
    {
        return [
            'term_id' => $category->term->term_id,
            'name' => $category->term->name,
            'slug' => $category->term->slug,
            'term_group' => $category->term->term_group,
            'level' => $category->children->map(function ($child) {
                return $this->buildCategoryTree($child);
            })->toArray()
        ];
    }
}
