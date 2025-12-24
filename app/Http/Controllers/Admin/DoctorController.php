<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\DoctorSchedule;
class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::latest()->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('doctors', 'public');
            $data['photo'] = $photoPath;
        }
        $doctor = Doctor::create($data);

        if ($request->has('schedule')) {
        foreach ($request->schedule as $item) {
            if (!empty($item['day']) && !empty($item['hours'])) {
                $doctor->schedules()->create($item);
            }
        }
    }

        return redirect()->route('admin.doctors.index')->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($doctor->photo) {
                Storage::disk('public')->delete($doctor->photo);
            }
            $photoPath = $request->file('photo')->store('doctors', 'public');
            $data['photo'] = $photoPath;
        }

        $doctor->update($data);

        $existingIds = $doctor->schedules()->pluck('id')->toArray();
        $incomingIds = [];

        if ($request->schedule) {
            foreach ($request->schedule as $item) {

                if (empty($item['day']) || empty($item['hours'])) {
                    continue;
                }

                // Update existing
                if (!empty($item['id'])) {
                    DoctorSchedule::where('id', $item['id'])->update([
                        'day' => $item['day'],
                        'hours' => $item['hours'],
                    ]);
                    $incomingIds[] = $item['id'];
                } 
                // Create new
                else {
                    $schedule = $doctor->schedules()->create([
                        'day' => $item['day'],
                        'hours' => $item['hours'],
                    ]);
                    $incomingIds[] = $schedule->id;
                }
            }
        }

        // Delete removed schedules
        $deleteIds = array_diff($existingIds, $incomingIds);
        DoctorSchedule::whereIn('id', $deleteIds)->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $doctor)
    {   
        $doctor->schedules()->delete();
        
        if ($doctor->photo) {
            Storage::disk('public')->delete($doctor->photo);
        }
        
        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'Dokter berhasil dihapus.');
    }
}
