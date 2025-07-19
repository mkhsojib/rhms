<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::getGrouped();
        return view('superadmin.settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = ['general', 'appearance', 'system', 'business'];
        $types = ['text', 'textarea', 'image', 'select', 'boolean'];
        
        return view('superadmin.settings.create', compact('groups', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|unique:settings,key|max:255',
            'value' => 'nullable|string',
            'type' => 'required|in:text,textarea,image,select,boolean',
            'group' => 'required|in:general,appearance,system,business',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'options' => 'nullable|array',
            'is_public' => 'boolean',
        ]);

        // Handle file upload for image type
        if ($request->type === 'image' && $request->hasFile('value')) {
            $path = $request->file('value')->store('settings', 'public');
            $validated['value'] = $path;
        }

        Setting::create($validated);

        return redirect()->route('superadmin.settings.index')
            ->with('success', 'Setting created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        return view('superadmin.settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        $groups = ['general', 'appearance', 'system', 'business'];
        $types = ['text', 'textarea', 'image', 'select', 'boolean'];
        
        return view('superadmin.settings.edit', compact('setting', 'groups', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $validated = $request->validate([
            'value' => 'nullable|string',
            'type' => 'required|in:text,textarea,image,select,boolean',
            'group' => 'required|in:general,appearance,system,business',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'options' => 'nullable|array',
            'is_public' => 'boolean',
        ]);

        // Handle file upload for image type
        if ($request->type === 'image' && $request->hasFile('value')) {
            // Delete old file if exists
            if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                Storage::disk('public')->delete($setting->value);
            }
            
            $path = $request->file('value')->store('settings', 'public');
            $validated['value'] = $path;
        }

        $setting->update($validated);

        return redirect()->route('superadmin.settings.index')
            ->with('success', 'Setting updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        // Delete file if it's an image
        if ($setting->type === 'image' && $setting->value) {
            Storage::disk('public')->delete($setting->value);
        }

        $setting->delete();

        return redirect()->route('superadmin.settings.index')
            ->with('success', 'Setting deleted successfully.');
    }

    /**
     * Show general settings form
     */
    public function general()
    {
        $settings = Setting::getByGroup('general');
        return view('superadmin.settings.general', compact('settings'));
    }

    /**
     * Update general settings
     */
    public function updateGeneral(Request $request)
    {
        $settings = Setting::getByGroup('general');
        
        foreach ($settings as $setting) {
            $value = $request->input($setting->key);
            
            // Handle file upload for image type
            if ($setting->type === 'image' && $request->hasFile($setting->key)) {
                // Delete old file if exists
                if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                    Storage::disk('public')->delete($setting->value);
                }
                
                $path = $request->file($setting->key)->store('settings', 'public');
                $value = $path;
            }
            
            $setting->update(['value' => $value]);
        }

        return redirect()->route('superadmin.settings.general')
            ->with('success', 'General settings updated successfully.');
    }

    /**
     * Show appearance settings form
     */
    public function appearance()
    {
        $settings = Setting::getByGroup('appearance');
        return view('superadmin.settings.appearance', compact('settings'));
    }

    /**
     * Update appearance settings
     */
    public function updateAppearance(Request $request)
    {
        $settings = Setting::getByGroup('appearance');
        
        foreach ($settings as $setting) {
            $value = $request->input($setting->key);
            
            // Handle file upload for image type
            if ($setting->type === 'image' && $request->hasFile($setting->key)) {
                // Delete old file if exists
                if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                    Storage::disk('public')->delete($setting->value);
                }
                
                $path = $request->file($setting->key)->store('settings', 'public');
                $value = $path;
            }
            
            $setting->update(['value' => $value]);
        }

        return redirect()->route('superadmin.settings.appearance')
            ->with('success', 'Appearance settings updated successfully.');
    }

    /**
     * Show system settings form
     */
    public function system()
    {
        $settings = Setting::getByGroup('system');
        return view('superadmin.settings.system', compact('settings'));
    }

    /**
     * Update system settings
     */
    public function updateSystem(Request $request)
    {
        $settings = Setting::getByGroup('system');
        
        foreach ($settings as $setting) {
            $value = $request->input($setting->key);
            $setting->update(['value' => $value]);
        }

        return redirect()->route('superadmin.settings.system')
            ->with('success', 'System settings updated successfully.');
    }

    /**
     * Show business settings form
     */
    public function business()
    {
        $settings = Setting::getByGroup('business');
        return view('superadmin.settings.business', compact('settings'));
    }

    /**
     * Update business settings
     */
    public function updateBusiness(Request $request)
    {
        $settings = Setting::getByGroup('business');
        
        foreach ($settings as $setting) {
            $value = $request->input($setting->key);
            $setting->update(['value' => $value]);
        }

        return redirect()->route('superadmin.settings.business')
            ->with('success', 'Business settings updated successfully.');
    }
}
