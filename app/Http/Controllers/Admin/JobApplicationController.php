<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read.lamaran')->only(['index', 'show']);
        $this->middleware('permission:delete.lamaran')->only('destroy');
        $this->middleware('permission:update.lamaran')->only('reply');
    }

    public function index(Request $request)
    {
        $query = JobApplication::with('career');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'desc');
        $query->orderBy('created_at', $sort);

        $applications = $query->paginate(10);
        return view('admin.job-applications.index', compact('applications'));
    }

    public function show(JobApplication $jobApplication)
    {
        return view('admin.job-applications.show', compact('jobApplication'));
    }

    public function destroy(JobApplication $jobApplication)
    {
        if ($jobApplication->cv_path && Storage::disk('public')->exists($jobApplication->cv_path)) {
            Storage::disk('public')->delete($jobApplication->cv_path);
        }
        $jobApplication->delete();
        return redirect()->route('admin.job-applications.index')->with('success', 'Lamaran berhasil dihapus.');
    }

    public function reply(Request $request, JobApplication $jobApplication)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required', // WYSIWYG content
        ]);

        // Logic to send email
        // Example: Mail::to($jobApplication->email)->send(new \App\Mail\JobReplyMail($request->subject, $request->message));
        
        // For now, we utilize the Mail facade directly or mock it
        try {
            Mail::send([], [], function ($message) use ($jobApplication, $request) {
                $message->to($jobApplication->email)
                        ->subject($request->subject)
                        ->html($request->message); // Send WYSIWYG content as HTML
            });
            
            $jobApplication->status = 'reviewed';
            $jobApplication->save();

            return redirect()->back()->with('success', 'Email balasan berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }
}