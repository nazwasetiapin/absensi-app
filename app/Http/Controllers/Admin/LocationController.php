<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric|min:10',
        ]);

        Location::create($request->all());

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('admin.locations.edit', compact('location'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric|min:10',
        ]);

        $location = Location::findOrFail($id);
        $location->update($request->all());

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil dihapus.');
    }


    public function activate($id)
    {
        // Nonaktifkan semua lokasi terlebih dahulu
        Location::query()->update(['is_active' => false]);

        // Aktifkan lokasi tertentu
        Location::findOrFail($id)->update(['is_active' => true]);

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil diaktifkan.');
    }
    public function deactivate($id)
    {
        Location::findOrFail($id)->update(['is_active' => false]);

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil dinonaktifkan.');
    }
}
