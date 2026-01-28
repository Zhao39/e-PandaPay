<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PaymentMethodMail;
use App\Models\Image;
use App\Models\PaymentMethod;
use App\Models\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\File;

class SetupController extends Controller
{
    public function updateGeneralSettings(Request $request): RedirectResponse
    {
        Gate::authorize('update general settings');
        $settings = Cache::get('site_settings');

        $validated = $request->validate([
            'logo' => ['nullable', 'sometimes', File::types(['jpg', 'jpeg', 'png'])->max('100mb')],
            'favicon' => [
                'nullable',
                'sometimes',
                File::types(['jpg', 'jpeg', 'png', 'ico'])
                    ->max('50mb'),
            ],
            'site_name' => ['required'],
            'site_title' => ['required'],
            'site_address' => ['required'],
            'purchase_code' => ['nullable'],
            'merchant_key' => ['nullable'],
            'admin_base_url' => ['required', 'starts_with:/', 'regex:/^[a-zA-Z\/\-]*$/', 'lowercase', 'max:99'],
            'live_chat' => [
                'nullable',
                'sometimes',
                'string',
                'regex:/^(?!(<\s*script)|(<\s*\/\s*script))(.)*$/u',
            ],
            'timezone' => ['required'],
            'install_type' => ['required'],
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store(path: 'settings');
        } else {
            $validated['logo'] = $settings->logo;
        }

        if ($request->hasFile('favicon')) {
            $validated['favicon'] = $request->file('favicon')->store(path: 'settings');
        } else {
            $validated['favicon'] = $settings->favicon;
        }

        $settings->update($validated);
        Cache::forget('site_settings');
        activity()->log('General Settings Updated');

        if ($settings->wasChanged('admin_base_url')) {
            $base = $request->admin_base_url;
            return redirect("{$base}/settings/general");
        }

        return redirect()->route('admin.settings.general')->with('success', 'General Settings Updated');
    }

    public function addMedia(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'photos.*' => [
                'image',
                File::types(['jpg', 'jpeg', 'png', 'webp', 'pdf', 'mp4', 'webm', 'gif'])->max('55mb'),
            ],
        ]);

        foreach ($validated['photos'] as $file) {
            $path = $file->store(path: 'media');
            $image = new Image();
            $image->title = $file->hashName();
            $image->path = $path;
            $image->save();
        }

        return redirect()->route('admin.settings.website.media')->with('success', 'Images Uploaded Successfully.');
    }

    public function addPaymentMethod(Request $request): RedirectResponse
    {
        $request->validate([
            'note' => ['nullable', 'max:200'],
            'img_url' => ['nullable'],
            'barcode' => [
                'nullable',
                'sometimes',
                File::image()
                    ->min('1kb')
                    ->max('30mb'),
            ],
        ]);

        $filtered = Arr::except($request->all(), ['_token']);

        if ($request->hasFile('barcode')) {
            $filtered['barcode'] = $request->file('barcode')->store(path: 'barcodes');
        }

        $method = PaymentMethod::create($filtered);
        $settings = Settings::select(['id', 'receive_payment_method_email', 'notifiable_email'])->find(1);
        if ($settings->receive_payment_method_email) {
            dispatch(function () use ($settings, $method) {
                Mail::to($settings->notifiable_email)->send(new PaymentMethodMail($method, auth()->user()->name));
            })->afterResponse();
        }
        return redirect()->back()->with('success', 'Method Saved Successfully.');
    }

    public function editPaymentMethod(Request $request): RedirectResponse
    {
        $request->validate([
            'note' => ['nullable', 'max:200'],
            'img_url' => ['nullable'],
            'barcode' => [
                'nullable',
                'sometimes',
                File::image()
                    ->min('1kb')
                    ->max('30mb'),
            ],
        ]);

        $filtered = Arr::except($request->all(), ['_token', '_method']);
        $method = PaymentMethod::find($request->id);

        if ($request->hasFile('barcode')) {
            $filtered['barcode'] = $request->file('barcode')->store(path: 'barcodes');
        } else {
            $filtered['barcode'] = $method->barcode;
        }

        $method->update($filtered);

        $settings = Settings::select(['id', 'receive_payment_method_email', 'notifiable_email'])->find(1);

        if ($settings->receive_payment_method_email) {
            dispatch(function () use ($settings, $method) {
                Mail::to($settings->notifiable_email)->send(new PaymentMethodMail($method, auth()->user()->name, false));
            })->afterResponse();
        }
        return redirect()->back()->with('success', 'Method Updated Successfully.');
    }
}
