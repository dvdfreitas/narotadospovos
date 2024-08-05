<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    public function index()
    {

        $partners = Partner::where('visible', true)->latest()->paginate(8);
        $iconsPath = public_path('icons');
        $iconsFiles = File::files($iconsPath);
        $socialMedias = ['website', 'facebook', 'instagram', 'linkedIn'];
        $icons = [];

        foreach ($iconsFiles as $icon) {
            $iconName = pathinfo($icon, PATHINFO_FILENAME);
            if (in_array($iconName, $socialMedias)) {
                $icons[$iconName] = asset('icons/' . $icon->getFilename());
            }
        }

        return view('partners.index', compact('partners', 'icons'));
    }

    public function create()
    {
        return view('partners.create');
    }

    public function store(Request $request)
    {
        $dataValidated = $request->validate([
            'name' => ['required', 'string', 'min:6', 'max:255', 'unique:partners,name'],
            'logo' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            ],

            'visible' => ['required', 'boolean'],
            'website' => ['nullable', 'url', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'linkedIn' => ['nullable', 'url', 'max:255'],
        ]);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalExtension();
            $logo->move(public_path('logos'), $logoName);
            $dataValidated['logo'] = $logoName;
        }

        $dataValidated['slug'] = Str::slug($dataValidated['name']);

        Partner::create($dataValidated);
        return redirect('partners/');
    }
}
