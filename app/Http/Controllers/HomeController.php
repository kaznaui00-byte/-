<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Novel;
use App\Models\Story;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        // أحدث الاقتباسات
        $latestQuotes = Quote::with('user')
            ->where('post_type', 'text')
            ->whereNotNull('text')
            ->latest()
            ->take(4)
            ->get();

        // أحدث حلقات البودكاست
        $latestEpisodes = Quote::with(['user', 'likes', 'comments.user'])
            ->where('post_type', 'audio')
            ->whereNotNull('audio_path')
            ->latest()
            ->take(3)
            ->get();

        // أحدث الروايات
        $latestNovels = Novel::with('user')
            ->withCount('chapters')
            ->where('is_published', true)
            ->latest()
            ->take(4)
            ->get();

        // أحدث القصص
        $latestStories = Story::with('user')
            ->where('status', 'published')
            ->latest()
            ->take(4)
            ->get();

        // المبدعون
        $featuredCreators = User::where('show_in_creator_space', true)
            ->latest()
            ->take(4)
            ->get();

        return view('welcome', compact(
            'latestQuotes',
            'latestEpisodes',
            'latestNovels',
            'latestStories',
            'featuredCreators'
        ));
    }
}