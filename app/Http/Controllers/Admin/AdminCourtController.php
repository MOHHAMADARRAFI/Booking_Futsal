<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use Illuminate\Http\Request;

class AdminCourtController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $courts = Court::with('owner')->paginate(15);
        return view('admin.courts.index', compact('courts'));
    }

    public function show(Court $court)
    {
        return view('admin.courts.show', compact('court'));
    }

    public function edit(Court $court)
    {
        return view('admin.courts.edit', compact('court'));
    }

    public function update(Request $request, Court $court)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $court->update($validated);
        return redirect()->route('admin.courts.show', $court)->with('success', 'Court status updated');
    }

    public function destroy(Court $court)
    {
        $court->delete();
        return redirect()->route('admin.courts.index')->with('success', 'Court deleted');
    }
}
