<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    private $country;

    public function __construct(Country $country)
    {
        $this->country = $country;
    }

    /**
     * Get list country
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        $countries = $this->country->getFullList();

        return view('admin.country.country_list', [
            'countries' => $countries
        ]);
    }

    /**
     * Create country
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'slug' => 'required',
            'description' => '',
            'about' => '',
            'banner' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'countrymap' => 'mimes:jpeg,jpg,png,gif,svg|max:10000',
            'countrymap_tile' => 'mimes:jpeg,jpg,png,gif,svg|max:10000',
            'website' => '',
            'video' => ''
        ]);

        if ($request->hasFile('countrymap')) {
            $map = $request->file('countrymap');
            $map_file = $this->uploadmapImage($map, '');
            $data['countrymap'] = $map_file;
        }
        if ($request->hasFile('countrymap_tile')) {
            $map_tile = $request->file('countrymap_tile');
            $map_tile_file = $this->uploadmapImage($map_tile, '');
            $data['countrymap_tile'] = $map_tile_file;
        }
        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $banner_file = $this->uploadImage($banner, '');
            $data['banner'] = $banner_file;
        }

        $model = new Country();
        $model->fill($data)->save();

        return redirect()->route('admin_region_list')->with('success', 'Add region success!');
    }

    /**
     * Update country
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $data = $this->validate($request, [
            'country_id' => 'required',
            'name' => 'required',
            'slug' => 'required',
            'description' => '',
            'about' => '',
            'banner' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'countrymap' => 'mimes:jpeg,jpg,png,gif,svg|max:10000',
            'countrymap_tile' => 'mimes:jpeg,jpg,png,gif,svg|max:10000',
            'website' => '',
            'video' => ''
        ]);

        if ($request->hasFile('countrymap')) {
            $map = $request->file('countrymap');
            $map_file = $this->uploadmapImage($map, '');
            $data['countrymap'] = $map_file;
        }
        if ($request->hasFile('countrymap_tile')) {
            $map_tile = $request->file('countrymap_tile');
            $map_tile_file = $this->uploadmapImage($map_tile, '');
            $data['countrymap_tile'] = $map_tile_file;
        }
        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $banner_file = $this->uploadImage($banner, '');
            $data['banner'] = $banner_file;
        }
        $model = Country::findOrFail($request->country_id);
        $model->fill($data);

        if ($model->save())
            return redirect()->route('admin_region_list')->with('success', 'Update region success!');
        else
            return redirect()->route('admin_region_list')->with('error', 'Update region fail!');
    }

    /**
     * Delete country
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Country::destroy($id);
        return redirect()->route('admin_region_list')->with('success', 'Delete region success!');
    }
}
