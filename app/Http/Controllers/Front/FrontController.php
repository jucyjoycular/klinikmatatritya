<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Career;
use App\Models\Doctor;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\FooterSection;
use App\Models\InstagramSetting;
use App\Models\Insurance;
use App\Models\JobApplication;
use App\Models\PopupSetting;
use App\Models\Promo;
use App\Models\ReviewSetting;
use App\Models\Service;
use App\Models\Settings;
use App\Models\SocialFeed;

use App\Models\Specialization;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FrontController extends Controller
{
    public function landingPage()
    {
        $services = Service::latest()->take(6)->get();
        $articles = Article::latest()->take(6)->get();
        $doctors = Doctor::with('schedules')->take(6)->get();
        $promos = Promo::latest()->get();
        $popup = PopupSetting::where('is_active',1)->first();  
        $social_feeds = SocialFeed::latest()->take(4)->get();
        $insurances = Insurance::latest()->get();
        $faqCategories = FaqCategory::with(['faqs' => function ($query) {
            $query->where('is_active', true);
        }])->get();
        $specializations = Specialization::all();
        return view('front.landing-page', compact('services', 'articles', 'doctors', 'promos','popup','social_feeds',   'insurances', 'faqCategories', 'specializations'));
    }

    public function faqSearch(Request $request)
    {
        $query = trim((string) $request->get('q', ''));
        if (mb_strlen($query) < 2) {
            return response()->json(['items' => []]);
        }

        $items = Faq::query()
            ->with('faqCategory')
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('question', 'like', "%{$query}%");
            })
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($faq) {
                $slug = $faq->faqCategory?->slug;

                return [
                    'id' => $faq->id,
                    'question' => $faq->question,
                    'category_slug' => $slug,
                    'target' => $slug ? "faq-{$slug}-{$faq->id}" : null,
                ];
            })
            ->values();

        return response()->json(['items' => $items]);
    }

    public function services()
    {
        $services = Service::paginate(12);
        $promos = Promo::latest()->get();
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
    public function doctor($id)
    {
        $doctor = Doctor::with('schedules')->find($id);
        $articles = Article::latest()->take(6)->get();
        return view('front.doctor', compact('doctor', 'articles'));
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
        $posts = Article::latest()->take(5)->get();
        return view('front.carier', compact('career', 'other_jobs', 'posts'));
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
        
        $doctors = Doctor::all();

        // Chart Kompetensi (by Specialty)
        $specialties = $doctors->groupBy('specialty')->map->count();
        $chartKompetensi = [
            'labels' => $specialties->keys(),
            'data' => $specialties->values(),
        ];

        // Chart Pendidikan (by Education Level)
        $educations = $doctors->whereNotNull('education_level')->groupBy('education_level')->map->count();
        $chartPendidikan = [
            'labels' => $educations->keys(),
            'data' => $educations->values(),
        ];

        $settings = Settings::whereIn('key', ['about_us', 'vision', 'mission', 'motto'])->pluck('value', 'key');
        $about_us = $settings['about_us'] ?? 'Klinik Mata Tritya (KMT) merupakan salah satu pelopor berdirinya klinik khusus mata...'; // Default fallback
        $vision = $settings['vision'] ?? 'Layanan paripurna, sehat mata dan manfaat sesama.';
        $mission = $settings['mission'] ?? 'Menyediakan fasilitas dan pelayanan kesehatan mata paripurna dengan mengedepankan kepuasan pelanggan.';
        $motto = $settings['motto'] ?? 'Mari Melihat Kembali';

        return view('front.about', compact('recent_articles', 'chartKompetensi', 'chartPendidikan', 'about_us', 'vision', 'mission', 'motto'));
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
        $section = Cache::remember('footer_csr', 3600, function () {
            return FooterSection::with('items')
            ->where('slug', 'csr')
            ->firstOrFail();
        });
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.csr', compact('section', 'articles', 'recent_articles', 'social_feeds'));
    }

    public function investor()
    {
        $section = Cache::remember('footer_investor', 3600, function () {
            return FooterSection::with('items')
            ->where('slug', 'investor')
            ->firstOrFail();
        });
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.investor', compact('section', 'articles', 'recent_articles', 'social_feeds'));
    }

    public function emc()
    {
            $section = Cache::remember('footer_emc', 3600, function () {
                return FooterSection::with('items')
                ->where('slug', 'emc')
                ->firstOrFail();
            });
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.emc', compact('section', 'articles', 'recent_articles', 'social_feeds'));
    }

    public function charities()
    {
        $section = Cache::remember('footer_charities', 3600, function () {
            return FooterSection::with('items')
            ->where('slug', 'kegiatan-amal')
            ->firstOrFail();
        });
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.charities', compact('section', 'articles', 'recent_articles', 'social_feeds'));
    }

    public function privacy()
    {
        $section = Cache::remember('footer_privacy', 3600, function () {
            return FooterSection::with('items')
            ->where('slug', 'kebijakan-privasi')
            ->firstOrFail();
        });
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.privacy', compact('section', 'articles', 'recent_articles', 'social_feeds'));
    }

    public function help_center()
    {
        $section = Cache::remember('footer_help_center', 3600, function () {
            return FooterSection::with('items')
            ->where('slug', 'pusat-bantuan')
            ->firstOrFail();
        });
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.help_center', compact('section', 'articles', 'recent_articles', 'social_feeds'));
    }

    public function promosi()
    {
        $section = Cache::remember('footer_promosi', 3600, function () {
            return FooterSection::with('items')
            ->where('slug', 'promo')
            ->firstOrFail();
        });
        $articles = Article::latest()->paginate(9);
        $recent_articles = Article::latest()->take(5)->get();
        $social_feeds = SocialFeed::latest()->take(4)->get();
        return view('front.promosi', compact('section', 'articles', 'recent_articles', 'social_feeds'));
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