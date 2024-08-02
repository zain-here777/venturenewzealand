<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\AdsBanner;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Http\Request;

class AdsBannerController extends Controller
{
    public function list()
    {
        $adsbanner = AdsBanner::query()->orderBy('id','DESC')->get();
        return view('admin.adsbanner.adsbanner_list', [
            'adsbanners' => $adsbanner
        ]);
    }

    public function pageCreate($id = null)
    {
        $adsbanners = AdsBanner::find($id);
        return view('admin.adsbanner.adsbanner_create', [
            'adsbanners' => $adsbanners
        ]);
    }

    public function create(Request $request)
    {
        $rule_factory = RuleFactory::make([
            '%title%' => 'nullable',
            'image' => 'required'
        ]);
        $data = $this->validate($request, $rule_factory);
        // if ($request->hasFile('image')) {
        //     $thumb = $request->file('image');
        //     $thumb_file = $this->uploadImage($thumb, '');
        //     $data['image'] = $thumb_file;
        // }

        $model = new AdsBanner();
        $model->fill($data);
        $model->save();

        return redirect('admincp/adsbanners')->with('success', 'Create ads banner success!');
    }

    public function update(Request $request)
    {
        $rule_factory = RuleFactory::make([
            '%title%' => '',
            'image' => 'required'
        ]);
        $data = $this->validate($request, $rule_factory);

        // if ($request->hasFile('image')) {
        //     $thumb = $request->file('image');
        //     $thumb_file = $this->uploadImage($thumb, '');
        //     $data['image'] = $thumb_file;
        // }

//        return $data;


        $model = AdsBanner::find($request->id);
        $model->fill($data);
        $model->save();

        return redirect('admincp/adsbanners')->with('success', 'Update ads banner success!');
    }

    public function destroy($id)
    {
        AdsBanner::destroy($id);
        return redirect()->back()->with('success', 'Delete ads banner success!');
    }

}
