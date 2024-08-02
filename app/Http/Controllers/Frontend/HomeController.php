<?php

namespace App\Http\Controllers\Frontend;


use App\Models\City;
use App\Models\Post;
use App\Models\Place;
use App\Models\PlaceProduct;
use App\Models\Country;
use App\Models\Category;
use App\Commons\Response;
use App\Models\Amenities;
use App\Models\PlaceType;
use App\Models\Interest;
use App\Models\PlaceInterest;
use App\Models\Competition;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\NewsletterSubscribers;
use App\Models\RewardPointTransaction;
use Illuminate\Support\Facades\Session;
use App\Models\CompetitionParticipation;
use App\Models\HighlightedProduct;
use Illuminate\Support\Facades\Cache;


class HomeController extends Controller
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index()
    {

        // SEO Meta
        SEOMeta(setting('app_name'), setting('home_description'));


        $today = now();
        $competition = Competition::query()->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)->first();

        $popular_cities = Cache::remember('popular_cities', 1440, function () {
            // Your original query here
            return City::query()
                ->with('country')
                ->withCount(['places' => function ($query) {
                    $query->where('status', Place::STATUS_ACTIVE);
                }])
                ->where('status', Country::STATUS_ACTIVE)
                ->where('is_popular', 1)
                ->limit(8)
                ->get();
        });

        $highlightedProduct = new HighlightedProduct;
        $highlightedProducts = $highlightedProduct->getFullList(false);

        $blog_posts = Cache::remember('blog_posts', 1440, function () {
            return Post::query()
                ->with(['categories' => function ($query) {
                    $query->where('status', Category::STATUS_ACTIVE)
                        ->select('id', 'name', 'slug');
                }])
                ->where('type', Post::TYPE_BLOG)
                ->where('status', Post::STATUS_ACTIVE)
                ->limit(3)
                ->orderBy('created_at', 'desc')
                ->get(['id', 'category', 'slug', 'thumb']);
        });


        $categories = Cache::remember('categories', 1440, function () {
            return Category::query()
                ->where('categories.status', Category::STATUS_ACTIVE)
                ->where('categories.type', Category::TYPE_PLACE)
                ->where('places.status', Place::STATUS_ACTIVE)
                ->join('places', 'places.category', 'like', DB::raw("CONCAT('%', categories.id, '%')"))
                ->select('categories.id as id', 'categories.name as name','categories.description as description', 'categories.pricing_text as pricing_text', 'categories.priority as priority', 'categories.slug as slug', 'categories.color_code as color_code', 'categories.icon_map_marker as icon_map_marker', 'categories.small_icon', DB::raw("count(places.category) as place_count"))
                ->groupBy('categories.id')
                ->orderBy('categories.priority')
                ->limit(12)
                ->get();
        });

        $trending_places = Cache::remember('trending_places', 1440, function () {
            return Place::query()
                ->with('categories')
                ->with('city')
                ->with('place_types')
                ->withCount('reviews')
                ->with('avgReview')
                ->withCount('wishList')
                ->where('status', Place::STATUS_ACTIVE)
                ->where('is_highlight', 1)
                ->limit(10)
                ->get();
        });

        $popular_places = Cache::remember('popular_places', 1440, function () {
            return Place::query()
                ->where('status', Place::STATUS_ACTIVE)
                ->where('is_popular', 1)
                ->limit(4)
                ->get();
        });

        $testimonials = Cache::remember('testimonials', 1440, function () {
            return Testimonial::query()
                ->where('status', Testimonial::STATUS_ACTIVE)
                ->get();
        });

        $template = setting('template', '01');
        $home_page_video_link = setting('home_page_video_link');

        $destinations = City::query()
            ->where('status', City::STATUS_ACTIVE)
            ->orderBy('country_id', 'DESC')
            ->get();

        $regions = Cache::remember('active_regions', 1440, function () {
            return Country::query()
                ->where('status', Country::STATUS_ACTIVE)
                ->get();
        });

        $arrLocations = [];
        $arrLeftRegions = ['northland', 'gisborne', 'hawkes-bay', 'manawatu-whanganui', 'wellington', 'Marlborough', 'canterbury', 'otago'];
        $arrRightRegions = ['auckland', 'waikato', 'taranaki', 'west-coast', 'southland'];
        $arrTopRightRegions = ['tasman'];

        foreach ($regions as $region) {
            if ($region->id == 15 || $region->id == 16) {
                continue;
            }

            if (in_array($region->slug, $arrLeftRegions)) {
                $type = 'left';
            } else if (in_array($region->slug, $arrRightRegions)) {
                $type = 'right';
            } else if (in_array($region->slug, $arrTopRightRegions)) {
                $type = 'top-right';
            } else {
                $type = 'top-left';
            }

            $arrLocations[$region->id] = [
                'class'     =>  'destination_map_dropdown_' . str_replace('-', '_', $region->slug),
                'slug'      =>  $region->slug,
                'name'      =>  $region->name,
                'type'      =>  $type,
                'cities'    =>  []
            ];
        }

        foreach ($destinations as $destination) {
            if ($destination->country_id == 15 || $destination->country_id == 16) {
                continue;
            }

            $arrLocations[$destination->country_id]['cities'][] = $destination;
        }

        return view("frontend.home.home_{$template}", [
            'popular_places' => $popular_places,
            'popular_cities' => $popular_cities,
            'blog_posts' => $blog_posts,
            'categories' => $categories,
            'trending_places' => $trending_places,
            'testimonials' => $testimonials,
            'competition' => $competition,
            'home_page_video_link' => $home_page_video_link,
            'highlightedProducts' => $highlightedProducts,
            'arrLocations'  =>  $arrLocations
        ]);
    }

    public function pageFaqs()
    {
        return view('frontend.page.faqs');
    }

    public function pageContact()
    {
        return view('frontend.page.contact');
    }

    public function pageLanding($page_number)
    {
        return view("frontend.page.landing_{$page_number}");
    }

    public function sendContact(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'email' => 'required|email',
            'g-recaptcha-response' => 'required|captcha',
        ]);
        Mail::send('frontend.mail.contact_form', [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'note' => $request->note
        ], function ($message) use ($request) {
            $message->to(setting('email_system'), "{$request->first_name}")->subject('Contact from ' . $request->first_name);
        });

        return back()->with('success', 'Contact has been send!');
    }

    public function ajaxSearch(Request $request)
    {
        $keyword = $this->escape_like($request->keyword);
        $category_id = $request->category_id;
        $city_id = $request->city_id;

        $keyword = trim($keyword, '%');
        $interestArr = Interest::query()
            ->where('keyword', 'like', "%{$keyword}%")
            ->select('id')
            ->get()
            ->toArray();
        $places = Place::query()
            ->with(['city' => function ($query) {
                return $query->select('id', 'name', 'slug');
            }])
            ->with('place_interests')
            ->with('categories')
            ->where(function ($q) {
                $q->where('status', Place::STATUS_ACTIVE);
            })
            ->where(function ($q) use ($keyword, $category_id, $city_id, $interestArr) {
                $q->whereHas('products', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                })
                ->when(!empty($keyword), function ($q) use ($keyword, $interestArr) {
                    $q->orWhere(function ($q) use ($keyword, $interestArr) {
                        $q->orWhereTranslationLike('name', "%{$keyword}%")
                            ->orWhere('address', 'like', "%{$keyword}%")
                            ->orWhereHas('place_interests', function($query) use ($interestArr){
                                $query->whereIn('interest_id', $interestArr);
                             });
                    });
                })
                ->when(!empty($category_id), function ($q) use ($category_id) {
                    $q->orWhere('category', 'like', "%{$category_id}%");
                })
                ->when(!empty($city_id), function ($q) use ($city_id) {
                    $q->orWhere('city_id', $city_id);
                });
            });

        // if ($category_id) {
        //     $places->where('category', 'like', "%{$category_id}%");
        // }
        $places = $places->get(['id', 'city_id', 'name', 'slug', 'address']);

        $html = '<ul class="custom-scrollbar">';
        foreach ($places as $place) :
            if (isset($place['city'])) :
                $place_url = route('place_detail', $place->slug);
                $city_url = route('city_detail', $place['city']['slug']);
                $html .= "
                <li>
                    <a href=\"{$place_url}\">{$place->name}</a>
                    <a href=\"{$city_url}\"><i class=\"la la-city\"></i>{$place['city']['name']}</a>
                </li>
                ";
            endif;
        endforeach;
        $html .= '</ul>';

        $html_notfound = "<div class=\"golo-ajax-result\">No place found</div>";

        count($places) ?: $html = $html_notfound;

        return response($html, 200);
    }

    public function searchListing(Request $request)
    {
        $keyword = $request->keyword;

        $places = Place::query()
            ->with(['city' => function ($query) {
                return $query->select('id', 'name', 'slug');
            }])
            ->whereTranslationLike('name', "%{$keyword}%")
            ->orWhere('address', 'like', "%{$keyword}%")
            ->where('status', Place::STATUS_ACTIVE);

        $places = $places->get(['id', 'city_id', 'name', 'slug', 'address']);

        $html = '<ul class="listing_items">';
        foreach ($places as $place) :
            if (isset($place['city'])) :
                $place_url = route('place_detail', $place->slug);
                $html .= "
                <li>
                    <a href=\"{$place_url}\">{$place->name}</a>
                </li>
                ";
            endif;
        endforeach;
        $html .= '</ul>';

        $html_notfound = "<ul><li><a href='#'><span>No listing found!</span></a></li></ul>";

        count($places) ?: $html = $html_notfound;

        return response($html, 200);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $category_id = $request->category_id;
        $city_id = $request->city_id;

        $places = Place::query()
            ->with(['city' => function ($query) {
                return $query->select('id', 'name', 'slug');
            }])
            ->with('place_types')
            ->withCount('reviews')
            ->with('avgReview')
            ->withCount('wishList')
            ->orWhere('address', 'like', "%{$keyword}%")
            ->whereTranslationLike('name', "%{$keyword}%")
            ->where('status', Place::STATUS_ACTIVE);

        $categories = Category::query()
            ->where('type', Category::TYPE_PLACE)
            ->get();

        $place_types = PlaceType::query()
            ->get();

        $amenities = Amenities::query()
            ->get();

        $cities = City::query()
            ->get();

        if ($category_id) {
            $places->where('category', 'like', "%{$category_id}%");
        }

        if ($city_id) {
            $places->where('city_id', $city_id);
        }

        $places = $places->paginate(20);

        // SEO Meta
        SEOMeta(setting('app_name'), setting('home_description'));

        $template = setting('template', '01');

        return view("frontend.search.search_{$template}", [
            'places' => $places,
            'keyword' => $keyword,
            'category_names' => '',
            'categories' => $categories,
            'place_types' => $place_types,
            'amenities' => $amenities,
            'cities' => $cities,
            'filter_category' => '',
            'filter_amenities' => '',
            'filter_place_type' => '',
            'filter_city' => '',
        ]);
    }

    public function changeLanguage($locale)
    {
        Session::put('language_code', $locale);
        $language = Session::get('language_code');

        return redirect()->back();
    }

    public function pageSearchListing(Request $request)
    {
        $keyword = $request->keyword;
        $filter_category = $request->category;
        $filter_amenities = $request->amenities;
        $filter_place_type = $request->place_type;
        $filter_interest = $request->interest;
        $filter_region = $request->region;
        $filter_city = $request->city;

        $categories = Category::query()
            ->where('type', Category::TYPE_PLACE)
            ->get();

        $region = Country::query()->get();

        if ($filter_region) {
            $cities = City::query();
            foreach ($filter_region as $key => $item) {
                if ($key === 0) {
                    $cities->where('country_id', $item);
                } else {
                    $cities->orWhere('country_id', $item);
                }
            }
            $cities = $cities->get();
        } else {
            $cities = City::query()
                ->get();
        }

        if ($filter_category) {
            $place_types = PlaceType::query();
            foreach ($filter_category as $key => $item) {
                if ($key === 0) {
                    $place_types->where('category_id', $item);
                } else {
                    $place_types->orWhere('category_id', $item);
                }
            }
            $place_types = $place_types->get();
            $interests = Interest::query();
            foreach ($filter_category as $key => $item) {
                if ($key === 0) {
                    $interests->where('category_id', $item);
                } else {
                    $interests->orWhere('category_id', $item);
                }
            }
            $interests = $interests->get();
        } else {
            $place_types = PlaceType::query()
                ->get();
            $interests = Interest::query()
            ->get();
        }



        $amenities = Amenities::query()
            ->get();

        // $cities = City::query()
        //     ->get();
        $category_names = "";
        $places = Place::query()

            ->with(['city' => function ($query) {
                return $query->select('id', 'name', 'slug');
            }])
            ->with('categories')
            ->with('place_types')
            ->with('place_interests')
            ->withCount('reviews')
            ->with('avgReview')
            ->withCount('wishList')
            ->where(function($q) use ($keyword, $filter_category, $filter_amenities, $filter_place_type, $filter_interest, $filter_city, $filter_region, $category_names) {
                $q->when($keyword != null, function($query) use($keyword){
                            $query->orWhere('address', 'like', "%{$keyword}%");
                        })
                        ->whereTranslationLike('name', "%{$keyword}%");

                if ($filter_category) {
                    foreach ($filter_category as $key => $item) {

                        $cat = Category::where('id', $item)->first();
                        $category_names = $category_names . $cat->name . " ";

                        if ($key === 0) {
                            $q->where('category', 'like', "%$item%");
                        } else {
                            $q->orWhere('category', 'like', "%$item%");
                        }
                    }
                }
                if ($filter_amenities) {
                    foreach ($filter_amenities as $key => $item) {
                        if ($key === 0) {
                            $q->where('amenities', 'like', "%$item%");
                        } else {
                            $q->orWhere('amenities', 'like', "%$item%");
                        }
                    }
                }
                if ($filter_place_type) {
                    foreach ($filter_place_type as $key => $item) {
                        if ($key === 0) {
                            $q->where('place_type', 'like', "%$item%");
                        } else {
                            $q->orWhere('place_type', 'like', "%$item%");
                        }
                    }
                }
                if ($filter_interest) {
                    $q->whereHas('place_interests', function($query) use ($filter_interest){
                        $query->whereIn('interest_id', $filter_interest);
                     });
                }
                $interestArr = [];
                $cityArr = [];
                $countryArr = [];
                if ($keyword && $keyword !== "") {
                    $key_interest = Interest::query()
                    ->where('keyword', 'like', "%{$keyword}%")
                    ->get();
                    foreach( $key_interest as $i )
                    {
                        array_push($interestArr, $i->id);
                    }
                    $key_city = City::query()
                    ->whereTranslationLike('name', "%{$keyword}%")
                    ->get();
                    foreach( $key_city as $i )
                    {
                        array_push($cityArr, $i->id);
                    }
                    $key_country = Country::query()
                    ->where('name', 'like', "%{$keyword}%")
                    ->get();
                    foreach( $key_country as $i )
                    {
                        array_push($countryArr, $i->id);
                    }
                    $q->orWhereHas('place_interests', function($query) use ($interestArr){
                        $query->whereIn('interest_id', $interestArr);
                     })
                     ->orWhereIn('city_id', $cityArr)
                     ->orWhereIn('country_id', $countryArr);
                }

                if ($filter_city) {
                    $q->whereIn('city_id', $filter_city);
                }

                if ($filter_region) {
                    $q->whereIn('country_id', $filter_region);
                }
            })
            ->where('status', Place::STATUS_ACTIVE);

        if ($request->ajax == '1') {
            $places = $places->get();

            $city = null;
            if (isset($filter_city)) {
                $city = City::query()
                    ->whereIn('id', $filter_city)
                    ->first();
            }

            $data = [
                'city' => $city,
                'places' => $places
            ];

            return $this->response->formatResponse(200, $data, 'success');
        }

        $places = $places->paginate();
        $places->appends(['region' => $filter_region, 'city' => $filter_city, 'category' => $filter_category, 'place_type' => $filter_place_type]);

        //        return $places;

        $category_names = trim($category_names, " ");

        $template = setting('template', '01');

        // SEO Meta
        SEOMeta(setting('app_name'), setting('home_description'));

        return view("frontend.search.search_{$template}", [
            'keyword' => $keyword,
            'category_names' => $category_names,
            'places' => $places,
            'categories' => $categories,
            'place_types' => $place_types,
            'interests' => $interests,
            'amenities' => $amenities,
            'region' => $region,
            'cities' => $cities,
            'filter_region' => $filter_region,
            'filter_category' => $filter_category,
            'filter_amenities' => $filter_amenities,
            'filter_place_type' => $filter_place_type,
            'filter_interest' => $filter_interest,
            'filter_city' => $request->city,
        ]);
    }

    public function competition_details()
    {
        $today = now();
        $competition = Competition::query()->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)->first();

        if ($competition == null) {
            return abort(404);
        }

        $alreadyParticipated = false;
        if (auth()) {
            $user_id = auth()->user()->id;
            $competition_id = $competition->id;
            $alreadyParticipated = CompetitionParticipation::query()->where('user_id', $user_id)->where('competition_id', $competition_id)->exists();
        }

        return view('frontend.page.competition_details', ['competition' => $competition, 'alreadyParticipated' => $alreadyParticipated]);
    }

    public function competition_details_page()
    {
        $today = now();
        $competition = Competition::query()->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)->first();

        if ($competition == null) {
            return abort(404);
        }

        $alreadyParticipated = false;
        if (auth()->user()) {
            $user_id = auth()->user()->id;
            $competition_id = $competition->id;
            $alreadyParticipated = CompetitionParticipation::query()->where('user_id', $user_id)->where('competition_id', $competition_id)->exists();
        }

        return view('frontend.page.competition_details_page', ['competition' => $competition, 'alreadyParticipated' => $alreadyParticipated]);
    } //competition_details_page()

    public function competitionParticipate(Request $request, $competition_id)
    {
        $user_id = auth()->user()->id;
        if (request()->ajax()) {

            if (isUserHaveMembership()) {
                $isExists = CompetitionParticipation::query()->where('user_id', $user_id)->where('competition_id', $competition_id)->exists();
                if ($isExists) {
                    return response()->json(['status' => false, 'message' => 'You have already participated!']);
                }

                $isCompetitionExists = Competition::query()->where('id', $competition_id)->first();
                if ($isCompetitionExists == null) {
                    return response()->json(['status' => false, 'message' => 'This competition does not exists.']);
                }

                $entry_fee_points = $isCompetitionExists->entry_fee_points;
                $prize_points = $isCompetitionExists->prize_points;

                $balance = RewardPointTransaction::getBalance();

                if ($balance >= $entry_fee_points) {

                    RewardPointTransaction::addTransaction(RewardPointTransaction::TRANSACTION_MINUS, [
                        'user_id' => $user_id,
                        'competition_id' => $competition_id,
                        'points' => $entry_fee_points,
                        'title' => $isCompetitionExists->title,
                    ]);

                    CompetitionParticipation::create([
                        'user_id' => $user_id,
                        'competition_id' => $competition_id,
                        'entry_fee_points' => $entry_fee_points,
                        'prize_points' => $prize_points
                    ]);

                    return response()->json(['status' => true, 'message' => 'Participation success!']);
                } else {
                    $low = $entry_fee_points - $balance;
                    return response()->json(['status' => false, 'message' => 'Insufficient points, Your balance is low by ' . $low . ' points.']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Membership is required to participate!']);
            }
        }
        return abort(404);
    }

    public function nearBy()
    {
        $categories = Category::query()
            ->where('status', Category::STATUS_ACTIVE)
            ->where('type', Category::TYPE_PLACE)
            ->get();
        return view('frontend.page.near_by', ['categories' => $categories]);
    }

    public function nearByPlaces(Request $request)
    {

        $lat = $request->lat;
        $lng = $request->lng;

        $category = $request->category;
        //$subcategory = $request->subcategory;

        $radius = 100; //Miles // replace 6371000 with 6371 for kilometer and 3956 for miles


        // $places = Place::selectRaw("lat, lng,
        //                  ( 6371000 * acos( cos( radians(?) ) *
        //                    cos( radians( lat ) )
        //                    * cos( radians( lng ) - radians(?)
        //                    ) + sin( radians(?) ) *
        //                    sin( radians( lat ) ) )
        //                  ) AS distance", [$lat, $lng, $lat])
        //     ->having("distance", "<", $radius)
        //     ->orderBy("distance",'asc')
        //     ->limit(50)
        //     ->get();

        $places = Place::query()->where('lat', '!=', NULL)->where('lng', '!=', NULL)
            ->with('categories')
            ->with('avgReview')
            ->withCount('reviews')
            ->where('status', Place::STATUS_ACTIVE)
            ->where(function ($q) use ($category) {
                $q->whereIn(DB::Raw("REPLACE(REPLACE(category, '\"]', ''), '[\"', '')"), $category);
            })
            // ->when($subcategory!=0, function ($q, $subcategory) {
            //     $q->where('place_type', 'like', '%' . $subcategory . '%');
            // })
            ->get();
        return response()->json(['status' => true, 'data' => $places]);
    }

    public function newsletterSubscribe(Request $request)
    {
        if (request()->ajax()) {


            $data = $this->validate($request, [
                'fullname' => 'required|string',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:newsletter_subscribers'],
            ]);
            $fullname = $request->fullname;
            $email = $request->email;

            if ($email == "" || $email == null) {
                return response()->json(['status' => false, 'message' => 'Email is required!']);
            }

            $isExists = NewsletterSubscribers::query()->where('email', $email)->exists();
            if ($isExists) {
                return response()->json(['status' => false, 'message' => 'You have already subscribed!']);
            }

            NewsletterSubscribers::create([
                'fullname' => $fullname,
                'email' => $email,
            ]);

            return response()->json(['status' => true, 'message' => 'Newsletter subscription success!']);
        }
        return abort(404);
    } //newsletterSubscribe()

    public function termsAndConditions()
    {
        return view('frontend.page.terms_and_conditions');
    }

    public function howItWorksOperator()
    {
        return view('frontend.page.how_It_works_operator');
    }

    public function howItWorksUser()
    {
        return redirect()->to('https://user.venturenewzealand.co.nz/');
    }

    public function getSubCategoriesForCategory(Request $request)
    {
        $category_id = $request->category;

        $search_place_types = Category::query()
            ->where('id', $category_id)
            ->with('place_type')
            ->get();

        return response()->json(['status' => true, 'data' => $search_place_types]);
    }
}
