<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    private function getIcons()
    {
        return [
            'fas fa-user-md',
            'fas fa-stethoscope',
            'fas fa-heartbeat',
            'fas fa-hospital',
            'fas fa-ambulance',
            'fas fa-medkit',
            'fas fa-plus-square',
            'fas fa-h-square',
            'fas fa-wheelchair',
            'fas fa-user-nurse',
            'fas fa-syringe',
            'fas fa-tablets',
            'fas fa-capsules',
            'fas fa-prescription-bottle',
            'fas fa-eye',
            'fas fa-glasses',
            'fas fa-low-vision',
            'fas fa-brain',
            'fas fa-notes-medical',
            'fas fa-procedures',
            'fas fa-x-ray',
            'fas fa-file-medical',
            'fas fa-microscope',
            'fas fa-vial',
            'fas fa-dna',
        ];
    }

    public function __construct()
    {
        $this->middleware('permission:read.spesialisasi')->only('index');
        $this->middleware('permission:create.spesialisasi')->only(['create', 'store']);
        $this->middleware('permission:update.spesialisasi')->only(['edit', 'update']);
        $this->middleware('permission:delete.spesialisasi')->only('destroy');
    }

    public function index()
    {
        $specializations = Specialization::latest()->paginate(10);
        return view('admin.specializations.index', compact('specializations'));
    }

    public function create()
    {
        $icons = $this->getIcons();
        return view('admin.specializations.create', compact('icons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string',
        ]);

        Specialization::create($request->all());

        return redirect()->route('admin.specializations.index')->with('success', 'Spesialisasi berhasil ditambahkan.');
    }

    public function edit(Specialization $specialization)
    {
        $icons = $this->getIcons();
        return view('admin.specializations.edit', compact('specialization', 'icons'));
    }

    public function update(Request $request, Specialization $specialization)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string',
        ]);

        $specialization->update($request->all());

        return redirect()->route('admin.specializations.index')->with('success', 'Spesialisasi berhasil diperbarui.');
    }

    public function destroy(Specialization $specialization)
    {
        $specialization->delete();

        return redirect()->route('admin.specializations.index')->with('success', 'Spesialisasi berhasil dihapus.');
    }
}
