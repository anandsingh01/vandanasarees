<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InstagramController extends Controller
{
    private $clientId = '2814825078683206';
    private $clientSecret = '85c19a68158304fce678f8cd7eae3754';
    private $redirectUri = 'https://vandanasarees.com/instagram/callback';

    public function authorizeUser()
    {
        $instagramUrl = "https://api.instagram.com/oauth/authorize?client_id={$this->clientId}&redirect_uri={$this->redirectUri}&scope=user_profile,user_media&response_type=code";
        return redirect($instagramUrl);
    }

    public function handleCallback(Request $request)
    {
        $code = $request->input('code');

        // Get Access Token
        $response = Http::asForm()->post('https://api.instagram.com/oauth/access_token', [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->redirectUri,
            'code' => $code,
        ]);

        $data = $response->json();
        $accessToken = $data['access_token'];

        // Save the access token in the session or database
        session(['instagram_access_token' => $accessToken]);

        return redirect('/instagram/posts');
    }

    public function fetchPosts()
    {
        $accessToken = session('instagram_access_token');

        if (!$accessToken) {
            return redirect('/instagram/authorize');
        }

        // Fetch user's posts from Instagram
        $response = Http::get("https://graph.instagram.com/me/media", [
            'fields' => 'id,caption,media_type,media_url,permalink,video_url',
            'access_token' => $accessToken,
        ]);

        $posts = $response->json()['data'];

//        print_r($posts);die;

        return view('web.index', compact('posts'));
    }

//    public function fetchPosts()
//    {
//        $accessToken = session('instagram_access_token');
//
//        if (!$accessToken) {
//            return redirect('/instagram/authorize');
//        }
//
//        // Fetch user's posts from Instagram
//        $response = Http::get("https://graph.instagram.com/me/media", [
//            'fields' => 'id,caption,media_url,permalink',
//            'access_token' => $accessToken,
//        ]);
//
//        $posts = $response->json()['data'];
//        print_r($posts);die;
//
//        return view('instagram.posts', compact('posts'));
//    }
}
