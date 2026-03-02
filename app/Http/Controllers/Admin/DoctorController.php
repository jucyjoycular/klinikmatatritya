<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Media;
use App\Models\MediaUsage;
use App\Traits\HandlesMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{

    use HandlesMedia;
    
    public function index()
    {
        $doctors = Doctor::latest()->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $mediaItems = Media::latest()->get();
        return view('admin.doctors.create', compact('mediaItems'));
    }

    public function store(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'education_level' => 'nullable|string|max:255',
            'education_history' => 'nullable|string',
            'special_training' => 'nullable|string',
            'competence' => 'nullable|string',
            'research_publications' => 'nullable|string',
            'media_id' => 'nullable|exists:media,id',
        ]);

        $data = $request->all();

        $doctor = Doctor::create($data);

        if ($request->filled('media_id')) {

            $media = Media::findOrFail($request->media_id);

            $this->attachExistingMedia($doctor, $media->id);

            $data['photo'] = $media->filepath;
            $doctor->update($data);
        } elseif ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('doctors', 'public');
            $data['photo'] = $imagePath;
            $doctor->fill($data)->save();

            $this->attachMedia($doctor, $request->file('photo'));
        } else {
            $doctor->fill($data)->save();
        }

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
        $mediaItems = Media::latest()->get();
        return view('admin.doctors.edit', compact('doctor', 'mediaItems'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'education_level' => 'nullable|string|max:255',
            'education_history' => 'nullable|string',
            'special_training' => 'nullable|string',
            'competence' => 'nullable|string',
            'research_publications' => 'nullable|string',
            'media_id' => 'nullable|exists:media,id',
        ]);

        $data = $request->all();

        if ($request->filled('media_id')) {

            $media = Media::findOrFail($request->media_id);

            $this->attachExistingMedia($doctor, $media->id);

            $data['photo'] = $media->filepath;
            $doctor->update($data);
        } elseif ($request->hasFile('photo')) {
             if ($doctor && Storage::disk('public')->exists($doctor->photo)) {
                Storage::disk('public')->delete($doctor->photo);

                DB::table('media_usages')->where('model_type', get_class($doctor))
                        ->where('model_id', $doctor->id)
                        ->delete();
            }
            $imagePath = $request->file('photo')->store('doctors', 'public');
            $data['photo'] = $imagePath;
            $doctor->fill($data)->save();
            
            $this->attachMedia($doctor, $request->file('photo'));
        } else {
            $doctor->fill($data)->save();
        }

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
                } else {
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