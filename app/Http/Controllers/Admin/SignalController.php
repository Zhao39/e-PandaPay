<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SignalService;
use Illuminate\Http\Request;

class SignalController extends Controller
{
    public function saveAnalysis(Request $request, SignalService $signalService)
    {
        $validated = $request->validate([
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:3048'],
            'image_result' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:3048'],
        ]);

        if ($request->has('image_result')) {
            $validated['image_result'] = $request->file('image_result')->store('signals', 'public');
        } else {
            $validated['image_result'] = null;
        }

        if ($request->has('image')) {
            $validated['image'] = $request->file('image')->store('signals', 'public');
        } else {
            $validated['image'] = null;
        }

        if ($request->has('analysisid')) {
            $validated['analysisid'] = $request->analysisid;
        }
        try {
            $signalService->saveAnalysis($validated);
            return redirect()->back()->with('success', 'Analysis saved successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('message', $th->getMessage());
        }
    }
}
