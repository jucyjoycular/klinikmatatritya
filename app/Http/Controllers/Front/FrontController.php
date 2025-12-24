<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promo;
use App\Models\PopupSetting;
use App\Models\Service;
use App\Models\Article;
use App\Models\Doctor;
use App\Models\Testimonial;
use App\Models\SocialFeed;
use App\Models\Career;
use App\Models\JobApplication;

class FrontController extends Controller
{
    public function landingPage()
    {
        $services = Service::latest()->take(6)->get();
        $articles = Article::latest()->take(6)->get();
        $doctors = Doctor::with('schedules')->take(6)->get();
        $promos = Promo::latest()->take(2)->get();
        $popup = PopupSetting::where('is_active',1)->first();
        $testimonials = Testimonial::latest()->take(6)->get();
        return view('front.landing-page', compact('services', 'articles', 'doctors', 'promos','testimonials','popup'));
    }
    public function services()
    {
        $services = Service::paginate(12);
        $promos = Promo::latest()->take(2)->get();
        return view('front.services', compact('services', 'promos'));
    }
    public function serviceShow($slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();
        return view('front.services.show', compact('service'));
    }
    public function articles()
    {
        $items = Article::paginate(12);
        return view('front.articles.index', compact('items'));
    }
    public function articleShow($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return view('front.articles.show', compact('article'));
    }
    public function doctors()
    {
        $doctors = Doctor::with('schedules')->get();
        return view('front.our-doctor', compact('doctors'));
    }
    public function doctor()
    {
        return view('front.doctor');
    }
    public function contact()
    {
        return view('front.contact');
    }

    public function cariers()
    {
        $careers = \App\Models\Career::where('is_active', true)
            ->latest()
            ->paginate(10);
        return view('front.cariers', compact('careers'));
    }

    public function carier($slug)
    {
        $career = \App\Models\Career::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $other_jobs = \App\Models\Career::where('id', '!=', $career->id)
            ->where('is_active', true)
            ->take(5)
            ->get();
        return view('front.carier', compact('career', 'other_jobs'));
    }

    public function jobForm(Request $request)
    {
        $career = null;
        if ($request->has('career_id')) {
            $career = \App\Models\Career::find($request->career_id);
        }
        return view('front.form.job-form', compact('career'));
    }

    public function storeJobApplication(Request $request)
    {
        $request->validate([
            'career_id' => 'required|exists:careers,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'source' => 'required|string|max:255',
            'cv_path' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->except('cv_path');

        if ($request->hasFile('cv_path')) {
            $data['cv_path'] = $request->file('cv_path')->store('cvs', 'public');
        }

        \App\Models\JobApplication::create($data);

        return redirect()->back()->with('success', 'Lamaran Anda berhasil dikirim! Kami akan segera menghubungi Anda.');
    }

    // Other existing methods...
    public function about()
    {
        $recent_articles = Article::latest()->take(5)->get();
        return view('front.about', compact('recent_articles'));
    }

    public function news()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.news', compact('articles', 'recent_articles', 'social_feeds'));
    }
    public function articleDetail($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        $recent_articles = Article::latest()->where('id', '!=', $article->id)->take(5)->get();
        return view('front.new', compact('article', 'recent_articles'));
    }

    public function detailPromo($slug)
    {
        $promo = Promo::where('slug', $slug)->firstOrFail();
        $recent_articles = Article::latest()->take(5)->get();
        return view('front.detail-promo', compact('promo', 'recent_articles'));
    }

    public function appointment()
    {
        return view('front.form.appointment');
    }

    public function csr()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.csr', compact('articles', 'recent_articles', 'social_feeds'));
    }

    public function investor()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.investor', compact('articles', 'recent_articles', 'social_feeds'));
    }

    public function emc()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.emc', compact('articles', 'recent_articles', 'social_feeds'));
    }

    public function charities()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.charities', compact('articles', 'recent_articles', 'social_feeds'));
    }

    public function privacy()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.privacy', compact('articles', 'recent_articles', 'social_feeds'));
    }

    public function help_center()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.help_center', compact('articles', 'recent_articles', 'social_feeds'));
    }

    public function promosi()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.promosi', compact('articles', 'recent_articles', 'social_feeds'));
    }

    public function hvf()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.statis.hvf', compact('articles', 'recent_articles', 'social_feeds'));
    }

    public function biometry()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.statis.biometry', compact('articles', 'recent_articles', 'social_feeds'));
    }

    public function microskop()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.statis.microskop', compact('articles', 'recent_articles', 'social_feeds'));
    }

    public function yag_laser()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.statis.yag_laser', compact('articles', 'recent_articles', 'social_feeds'));
    }

    public function oct()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.statis.oct', compact('articles', 'recent_articles', 'social_feeds'));
    }

    public function green_laser()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.statis.green_laser', compact('articles', 'recent_articles', 'social_feeds'));
    }

    public function ark()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.statis.ark', compact('articles', 'recent_articles', 'social_feeds'));
    }

    public function nct()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.statis.nct', compact('articles', 'recent_articles', 'social_feeds'));
    }

    public function slit_lamp()
    {
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.statis.slit_lamp', compact('articles', 'recent_articles', 'social_feeds'));
    }
}
