<?php

namespace App\Http\Controllers\Admin;


use Logic\PinGenerator;
use App\Models\Category;
use App\Models\Language;
use App\Commons\Response;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Astrotomic\Translatable\Validation\RuleFactory;

class CategoryController extends Controller
{
    private $category;
    private $response;

    public function __construct(Category $category, Response $response)
    {
        $this->category = $category;
        $this->response = $response;
    }

    public function list($type)
    {
        $categories = $this->category->getListAll($type);

//        return $categories;

        return view('admin.category.category_list', [
            'categories' => $categories,
            'type' => $type
        ]);
    }

    public function create(Request $request)
    {
        $request['slug'] = getSlug($request, 'name');

        $rule_factory = RuleFactory::make([
            '%name%' => '',
            'slug' => '',
            'description' => '',
            'priority' => '',
            'is_feature' => '',
            '%feature_title%' => '',
            'type' => '',
            'color_code' => '',
            'seo_title' => '',
            'seo_description' => '',
            'icon_map_marker' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'parent_id' => '',
        ]);
        $data = $this->validate($request, $rule_factory);

        if ($request->hasFile('icon_map_marker')) {
            $icon = $request->file('icon_map_marker');
            $file_name = $this->uploadImage($icon, '');
            $data['icon_map_marker'] = $file_name;
        }

        if ($request->hasFile('small_icon')) {
            $icon = $request->file('small_icon');
            $file_name = $this->uploadImage($icon, '');
            $data['small_icon'] = $file_name;
        }

        $model = new Category();
        $model->fill($data)->save();

        return back()->with('success', 'Add category success!');
    }

    public function update(Request $request)
    {
        $request['slug'] = getSlug($request, 'name');

        $rule_factory = RuleFactory::make([
            'category_id' => 'required',
            '%name%' => '',
            'description' => '',
            'slug' => '',
            'priority' => '',
            'is_feature' => '',
            '%feature_title%' => '',
            'type' => '',
            'color_code' => '',
            'seo_title' => '',
            'seo_description' => '',
            'icon_map_marker' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'parent_id' => '',
        ]);
        $data = $this->validate($request, $rule_factory);

        //Delete marker on category update
        $iconMarkerImage = public_path("uploads/categorymarker/" . $request->category_id . '.png');
        if (file_exists($iconMarkerImage)) {
            unlink($iconMarkerImage);
        }

        if ($request->hasFile('icon_map_marker')) {
            $icon = $request->file('icon_map_marker');
            $file_name = $this->uploadImage($icon, '');
            $data['icon_map_marker'] = $file_name;


            $category = Category::find($request->category_id);

                $iconMarkerImage = public_path("uploads/categorymarker/".$category->id.'.png');
                $iconImage = public_path("uploads/".$file_name);

                $colorCode = $category->color_code?$category->color_code:"#FF0000";
                $markerColorRGB = hex2rgba($colorCode);

                    //Create Folder if not exists
                    $folder = 'uploads/categorymarker/';
                    $path = public_path($folder);
                    if(!File::isDirectory($path)){
                        File::makeDirectory($path, 0755, true, true);
                    }

                if(!$category->icon_map_marker){
                    $iconImage = "";
                }

                $pin = PinGenerator::getStripedPin($iconImage,[$markerColorRGB]);
                file_put_contents ($iconMarkerImage, $pin);

        }

        if ($request->hasFile('small_icon')) {
            $icon = $request->file('small_icon');
            $file_name = $this->uploadImage($icon, '');
            $data['small_icon'] = $file_name;
        }

//        return $data;

        $model = Category::find($request->category_id);
        $model->fill($data);

        if ($model->save())
            return back()->with('success', 'Update category success!');
        else
            return back()->with('error', 'Update category fail!');
    }

    public function destroy($id)
    {
        Category::destroy($id);
        return back()->with('success', 'Delete category success!');
    }

    /**
     * API update status
     */
    public function updateStatus(Request $request)
    {
        $data = $this->validate($request, [
            'status' => 'required',
        ]);

        $model = Category::find($request->category_id);
        $model->fill($data);

        if ($model->save()) {
            return $this->response->formatResponse(200, $model, 'Update category status success!');
        }
    }

    /**
     * API update is_feature
     */
    public function updateIsFeature(Request $request)
    {
        $data = $this->validate($request, [
            'is_feature' => 'required',
        ]);

        $model = Category::find($request->category_id);
        $model->fill($data);

        if ($model->save()) {
            return $this->response->formatResponse(200, $model, 'Update category is feature success!');
        }
    }


}
