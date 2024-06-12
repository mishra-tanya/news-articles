<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class NewsController extends Controller
{
    public function fetchNews(Request $request)
    {
        // fetching data from the api
        $apiUrl = config('services.news_api.url');
        $response = Http::get($apiUrl); 
        // $response = Http::get('https://timesofindia.indiatimes.com/rssfeeds/-2128838597.cms?feedtype=json');
        $data = $response->json();
        //getting heading
        $heading = $data['channel'];

        // checking whether the articles are set or not
        if (isset($data['channel']['item']) && is_array($data['channel']['item'])) {
            // storing them into $articles
            $articles = $data['channel']['item'];
        } else {
            $articles = [];
        }


        // sorting
        $sortDirection = $request->query('sort', 'desc'); 
        if ($sortDirection === 'asc') {
            usort($articles, function ($a, $b) {
                return strtotime($a['pubDate']) - strtotime($b['pubDate']);
            });
        } elseif ($sortDirection === 'desc') {
            usort($articles, function ($a, $b) {
                return strtotime($b['pubDate']) - strtotime($a['pubDate']);
            });
        }

        // searching
        $searchQuery = $request->query('search');
        if ($searchQuery) {
            $articles = array_filter($articles, function ($article) use ($searchQuery) {
                return stripos($article['title'], $searchQuery) !== false ||
                       stripos($article['description'], $searchQuery) !== false;
            });
        }

        // pagination
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 7;
        $currentPageItems = array_slice($articles, ($currentPage - 1) * $perPage, $perPage);
        $paginator = new LengthAwarePaginator($currentPageItems, count($articles), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('welcome', ['articles' => $paginator, 'heading' => $heading]);
    }
}
