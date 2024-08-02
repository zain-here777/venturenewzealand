<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['name', 'feature_title'];

    protected $table = 'categories';

    protected $fillable = [
        'name', 'description', 'slug', 'priority','is_feature', 'feature_title', 'icon_map_marker', 'color_code', 'type', 'status', 'seo_title', 'seo_description',
        'small_icon', 'parent_id', 'pricing_text'
    ];

    protected $hidden = [];

    protected $casts = [
        'priority' => 'integer',
        'is_feature' => 'integer',
        'status' => 'integer'
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_DEACTIVE = 0;

    const IS_FEATURE = 1;

    const TYPE_PLACE = "place";
    const TYPE_POST = "post";

    const PRICING_TEXT = [
        'see' => [
            'adult' => '',
            'child' => ''
        ],
        'play' => [
            'adult' => 'Adult',
            'child' => 'Child'
        ],
        'stay' => [
            'adult' => 'Per Night',
            'child' => 'Per Night'
        ],
        'eat' => [
            'adult' => 'Adult',
            'child' => 'Child'
        ],
        'rent' => [
            'adult' => 'Per Day',
            'child' => 'Per Day'
        ],
        'travel' => [
            'adult' => 'Adult',
            'child' => 'Child'
        ]
    ];

    public function place_type()
    {
        return $this->hasMany(PlaceType::class, 'category_id', 'id');
    }

    public function interest()
    {
        return $this->hasMany(Interest::class, 'category_id', 'id');
    }

    public function getListAll($type)
    {
        $categories = self::query()
            ->where('type', $type)
            ->orderBy('priority', 'asc')
            ->get();

        return $categories;
    }

    public function getById($id)
    {
    }

    public function getBySlug($slug)
    {
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getAllCategories($type, $fields = [])
    {
        $categories = self::query()
            ->where('type', $type)
            ->where('parent_id', NULL)
            ->when(!empty($fields), function ($q) use ($fields) {
                $q->select($fields);
            })
            ->orderBy('priority', 'asc')
            ->get();
        return $categories;
    }

    public static function getSubCategories($category_ids)
    {
        return Category::query()->select('id', 'name', 'parent_id')->whereIn('parent_id', $category_ids)->get();
    }

    public function getPriceText()
    {
        $temp = ['play', 'travel', 'eat'];
        if (in_array($this->attributes['slug'], $temp)) {
            return "Adult";
        }
        return $this->attributes['pricing_text'];
    }

    public function getPriceTextPlaceHolderForAdult()
    {
        return $this::PRICING_TEXT[$this->attributes['slug']]['adult']??'';
    }

    public function getPriceTextPlaceHolderForChild()
    {
        return $this::PRICING_TEXT[$this->attributes['slug']]['child']??'';
    }
}
