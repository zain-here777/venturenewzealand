<?php

namespace App\Http\Controllers\Admin;


use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Models\Interest;
use App\Models\Category;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Http\Request;

class InterestController extends Controller
{
    private $category;
    private $interest;
    private $response;

    public function __construct(Category $category, Interest $interest, Response $response)
    {
        $this->category = $category;
        $this->interest = $interest;
        $this->response = $response;
    }

    public function list(Request $request)
    {
        $param_category_id = $request->category_id;
        $categories = Category::query()
            ->where('categories.status', Category::STATUS_ACTIVE)
            ->where('categories.type', Category::TYPE_PLACE)
            ->select('categories.id as id', 'categories.name as name','categories.description as description', 'categories.pricing_text as pricing_text', 'categories.priority as priority', 'categories.slug as slug', 'categories.color_code as color_code', 'categories.icon_map_marker as icon_map_marker', 'categories.small_icon')
            ->groupBy('categories.id')
            ->orderBy('categories.priority')
            ->get();
        $interests = $this->interest->getListByCategory($param_category_id);

    //    return $cities;

        return view('admin.interest.interest_list', [
            'categories' => $categories,
            'interests' => $interests,
            'category_id' => (int)$param_category_id
        ]);
    }

    public function create(Request $request)
    {

        $rule_factory = RuleFactory::make([
            'category_id'   => 'required',
            'keyword'       => 'required'
        ]);
        $data = $this->validate($request, $rule_factory);

        $model = new Interest();
        $model->fill($data)->save();

        return back()->with('success', 'Add Interest success!');
    }

//     public function update(Request $request)
//     {
//         $request['slug'] = getSlug($request, 'name');

//         $rule_factory = RuleFactory::make([
//             'country_id' => 'required',
//             '%name%' => '',
//             'slug' => 'required',
//             '%intro%' => '',
//             '%description%' => '',
//             'currency' => '',
//             'language' => '',
//             'best_time_to_visit' => '',
//             'lat' => '',
//             'lng' => '',
//             'seo_title' => '',
//             'seo_description' => '',
//             'thumb' => 'mimes:jpeg,jpg,png,gif|max:10000',
//             'banner' => 'mimes:jpeg,jpg,png,gif|max:10000',
//             'map' => 'mimes:jpeg,jpg,png,gif,svg|max:10000',
//             'website' => '',
//             'video' => '',
//             'is_popular' => '',
//         ]);
//         $data = $this->validate($request, $rule_factory);

//         if(isset($request->is_popular)){
//             $data['is_popular'] = 1;
//         }
//         else{
//             $data['is_popular'] = 0;
//         }

// //        return $data;

//         if ($request->hasFile('thumb')) {
//             $thumb = $request->file('thumb');
//             $thumb_file = $this->uploadImage($thumb, '');
//             $data['thumb'] = $thumb_file;
//         }
//         if ($request->hasFile('banner')) {
//             $banner = $request->file('banner');
//             $banner_file = $this->uploadImage($banner, '');
//             $data['banner'] = $banner_file;
//         }
//         if ($request->hasFile('map')) {
//             $map = $request->file('map');
//             $map_file = $this->uploadImage($map, '');
//             $data['map'] = $map_file;
//         }

//         $model = City::find($request->city_id);
//         $model->fill($data);

//         if ($model->save()) {
//             return back()->with('success', 'Update city success!');
//         }
//     }


    public function destroy(Request $request, $id)
    {
        Interest::destroy($id);
        return back()->with('success', 'Delete Interest success!');
    }


}
