<?php
/**
 * Created by PhpStorm.
 * User: minhthe
 * Date: 2020-04-27
 * Time: 16:07
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscribers;
use App\Models\Place;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Commons\Response;

class UserController extends Controller
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function getUserInfo(Request $request)
    {
        $user = $this->getUserByApiToken($request);
        return $user;
    }

    public function getPlaceByUser($user_id)
    {
        $places = Place::query()
            ->where('user_id', $user_id)
            ->paginate();

        return $places;
    }

    public function getPlaceWishlistByUser($user_id)
    {
        $wishlists = Wishlist::query()
            ->where('user_id', $user_id)
            ->get('place_id')->toArray();

        $wishlists = array_column($wishlists, 'place_id');

        $places = Place::query()
            ->with('place_types')
            ->withCount('reviews')
            ->with('avgReview')
            ->withCount('wishList')
            ->whereIn('id', $wishlists)
            ->paginate();

        return $places;
    }

    public function addEmailSubscription(Request $request) {
        $email = $request->input('email');
        $count = NewsletterSubscribers::where('email', $email)->count();

        if ($count > 0) {
            return response()->json([
                "code" => 401,
                "message" => 'E-mail already exists!'
            ]);
        }
        NewsletterSubscribers::create($request->all());

        return $this->response->formatResponse(200, 'Success');
    }

    /**
     * @param User $user
     * @return array|string[]
     */
    public function getUserInterests(User $user): array
    {
        return $user->interests->pluck('keyword')->unique()->values()->toArray();
    }
}
