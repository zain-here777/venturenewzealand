<?php

namespace App\Models;


use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

/**
 * @property string $category
 * @property PlaceProduct[]|Collection $placeProducts
 */
class Place extends Model  implements TranslatableContract
{
    use Translatable, HasJsonRelationships {
        Translatable::getAttribute insteadof HasJsonRelationships;
    }

    const DB_SETTING_KEY_IS_PLACE_PRODUCTS_LIMITED_FOR_OPERATOR = 'is_place_products_limited_for_operator';
    const DB_SETTING_KEY_PLACE_PRODUCTS_LIMIT_FOR_OPERATOR = 'place_products_limit_for_operator';

    const NOT_LIMITED = 0;
    const LIMITED = 1;

    const DB_SETTING_KEY_IS_PLACE_FEATURED_PRODUCTS_LIMITED_FOR_OPERATOR = 'is_place_featured_products_limited_for_operator';
    const DB_SETTING_KEY_PLACE_FEATURED_PRODUCTS_LIMIT_FOR_OPERATOR = 'place_featured_products_limit_for_operator';

    public $translatedAttributes = ['name', 'description', 'needtobring'];

    protected $casts = [
        'category' => 'json',
        'sub_category' => 'json',
        'place_type' => 'json',
        'social' => 'json',
        'amenities' => 'json',
        'opening_hour' => 'json',
        'gallery' => 'json',
        'menu' => 'json',
        'faq' => 'json',

        'user_id' => 'integer',
        'country_id' => 'integer',
        'city_id' => 'integer',
        'price_range' => 'integer',
        'lat' => 'double',
        'lng' => 'double',
        'booking_type' => 'integer',
        'status' => 'integer'
    ];

    protected $table = 'places';

    protected $fillable = [
        'user_id', 'country_id', 'city_id', 'category', 'sub_category', 'place_type', 'slug', 'price_range',
        'amenities', 'address', 'lat', 'lng', 'email', 'phone_number', 'website', 'social', 'opening_hour',
        'thumb', 'gallery', 'video', 'booking_type', 'link_bookingcom', 'status', 'seo_title', 'seo_description', 'faq',
        'reward_link', 'booking_link', 'hide_info', 'is_highlight', 'is_popular','logo'
    ];

    protected $hidden = [];

    const STATUS_DEACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 2;
    const STATUS_DELETE = 4;

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function products()
    {
        return $this->hasMany(PlaceProduct::class, 'place_id');
    }

    public function categories()
    {
        return $this->belongsToJson(Category::class, 'category');
    }

    public function sub_categories()
    {
        return $this->belongsToJson(Category::class, 'sub_category');
    }

    public function list_amenities()
    {
        return $this->belongsToJson(Amenities::class, 'amenities');
    }

    public function place_types()
    {
        return $this->belongsToJson(PlaceType::class, 'place_type');
    }

    /**
     * @deprecated
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function place_interests()
    {
        return $this->hasMany(PlaceInterest::class, 'place_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'place_id', 'id');
    }

    public function avgReview()
    {
        return $this->reviews()
            ->selectRaw('avg(score) as aggregate, place_id')
            ->groupBy('place_id');
    }

    public function getAvgReviewAttribute()
    {
        if (!array_key_exists('avgReview', $this->relations)) {
            $this->load('avgReview');
        }
        $relation = $this->getRelation('avgReview')->first();
        return ($relation) ? $relation->aggregate : null;
    }

    public function wishList()
    {
        return $this->hasMany(Wishlist::class, 'place_id', 'id')->where('user_id', Auth::id());
    }

    public function getAll()
    {
        return self::query()
            ->with('city')
            ->where('status', self::STATUS_ACTIVE)
            ->get();
    }

    public function listByFilter($country_id, $city_id, $cat_id)
    {
        $places = self::query()
            ->with('city')
            ->with('categories')
            // ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id', 'desc');

        if ($country_id)
            $places->where('country_id', $country_id);

        if ($city_id)
            $places->where('city_id', $city_id);

        if ($cat_id)
            $places->where('category', 'like', '%' . $cat_id . '%');

        $places = $places->get();

        return $places;
    }

    public function getBySlug($slug)
    {
        $place = self::query()
            ->withCount('wishList')
            ->with(['products' => function ($query) {
                $query->withCount('placeProductWishlist');
            }])
            ->where('slug', $slug)
            ->where('status', '!=', self::STATUS_DELETE)
            ->first();
        return $place;
    }

    public static function generatePlaceRewardLink($place_id)
    {
        $place = self::find($place_id);
        if ($place->reward_link == NULL) {
            $salt = "Th!si54S4l7Valu3";
            $reward_link = md5($salt . $place->id . now());
            $place->reward_link = $reward_link;
            $place->save();

            $folder = 'uploads/qrcodes/';
            $path = public_path($folder);
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            $full_link = url('/reward/' . $reward_link);
            QrCode::format('png')
                ->size(500)
                ->generate($full_link, public_path($folder . $reward_link . '.png'));

            return true;
        }
        return false;
    } //generatePlaceRewardLink()

    public static function getPlacesCount()
    {
        $user_id = auth()->user()->id;
        $count = self::query()->where('user_id', $user_id)
            ->where('status', self::STATUS_ACTIVE)
            ->count();
        return $count;
    } //getPlacesCount()

    public static function isPlaceOperatorHaveStripeConnect($place_id)
    {
        $isExists = self::query()->where('places.id', $place_id)
            ->join('users', 'users.id', '=', 'places.user_id')
            ->where('users.stripe_account_id', '!=', NULL)->exists();
        return $isExists;
    }

    public function getPlacePrice() {
        $place = PlaceProduct::query()
            ->select('*')
            ->where('place_id', $this->id)
            ->orderby('price')
            ->first();

        // if( $this->id == 329){
        //     dd($place);
        // }

        if ($place == null) {
            return 0;
        }

        return getRezdyPrice($place);
    }

    static function createSlug($name,$id = null)
    {
        $slug = Str::slug($name);
        $checkSlug = self::where('slug',$slug)->when($id != null, function($query) use($id){
            $query->where('id','!=',$id);
        })->first();
        if ($checkSlug !== null) {
            $max = static::whereName($name)->latest('id')->skip(1)->value('slug');
            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }
        return $slug;
    }

    /**
     * Get the place products for the place.
     */
    public function placeProducts()
    {
        return $this->hasMany(PlaceProduct::class);
    }
}
