<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function getChildCategories($category_id)
    {
        $categories = DB::table('wp_term_taxonomy')
            ->where('taxonomy', 'category')
            ->where('parent', $category_id)
            ->pluck('term_id');

        $allCategories = collect($categories);

        foreach ($categories as $cat) {
            $allCategories = $allCategories->merge($this->getChildCategories($cat));
        }

        return $allCategories;
    }

    public function getPostsByCategory($category_id)
    {
        $categoryIds = $this->getChildCategories($category_id)->push($category_id)->unique();

        $posts = DB::table('wp_posts')
            ->join('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
            ->join('wp_term_taxonomy', 'wp_term_relationships.term_taxonomy_id', '=', 'wp_term_taxonomy.term_taxonomy_id')
            ->whereIn('wp_term_taxonomy.term_id', $categoryIds)
            ->where('wp_posts.post_status', 'publish')
            ->where('wp_posts.post_type', 'post')
            ->select('wp_posts.ID', 'wp_posts.post_title', 'wp_posts.post_content', 'wp_posts.post_date')
            ->get();

        return response()->json($posts);
    }
}
