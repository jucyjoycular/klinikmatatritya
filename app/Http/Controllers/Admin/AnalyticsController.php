<?php


namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GA4Service;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read.analytics')->only('index');
        $this->middleware('permission:export.analytics')->only('exportCsv');
    }

    public function index(GA4Service $analytics)
    {   
        $data = $analytics->getReport();

        $organicSearch = $analytics->getChannelReport('Organic Search');
        $organicSocial = $analytics->getChannelReport('Organic Social');

        return view('admin.analytics.index', compact(
            'data',
            'organicSearch',
            'organicSocial'
        ));
    }

    public function exportCsv(Request $request, GA4Service $analytics)
    {
        [$startDate, $endDate] = $this->resolveDateRange($request);

        $total  = $analytics->getReport($startDate, $endDate);
        $social = $analytics->getSocialMediaReport($startDate, $endDate);

        $fileName = "ga4-report-{$startDate}-{$endDate}.csv";

        return response()->streamDownload(function () use ($total, $social) {

            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Date',
                'Total Users',
                'Total Sessions',
                'Total Page Views',
                'Social Users',
                'Social Sessions',
                'Social Page Views'
            ], ';');

            foreach ($total['dates_raw'] as $i => $rawDate) {

                $label = Carbon::createFromFormat('Ymd', $rawDate)
                               ->translatedFormat('d F Y');

                fputcsv($handle, [
                    $label,
                    $total['users'][$i] ?? 0,
                    $total['sessions'][$i] ?? 0,
                    $total['views'][$i] ?? 0,
                    $social[$rawDate]['users'] ?? 0,
                    $social[$rawDate]['sessions'] ?? 0,
                    $social[$rawDate]['views'] ?? 0,
                ], ';');
            }

            fclose($handle);

        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function resolveDateRange(Request $request)
    {
        switch ($request->mode) {

            case 'range':
                return [
                    $request->start_date,
                    $request->end_date
                ];

            case 'month':
                $year  = (int) $request->year;
                $month = (int) $request->month;

                $start = Carbon::create($year, $month, 1);

                return [
                    $start->format('Y-m-d'),
                    $start->endOfMonth()->format('Y-m-d')
                ];

            case 'year':
                return [
                    $request->year . '-01-01',
                    $request->year . '-12-31'
                ];

            case 'month_year':
                $start = Carbon::create(
                    (int) $request->year,
                    (int) $request->month,
                    1
                );

                return [
                    $start->format('Y-m-d'),
                    $start->endOfMonth()->format('Y-m-d')
                ];

            default:
                return [
                    now()->subDays(30)->format('Y-m-d'),
                    now()->format('Y-m-d')
                ];
        }
    }


}
