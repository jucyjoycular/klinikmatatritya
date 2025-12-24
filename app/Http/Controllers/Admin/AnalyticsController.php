<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;

class AnalyticsController extends Controller
{
    public function data(Request $request)
    {
        $propertyId = env('GA4_PROPERTY_ID');
        $keyPath = storage_path('app/keys/ga-service-account.json');

        $end = $request->query('end', date('Y-m-d'));
        $start = $request->query('start', date('Y-m-d', strtotime('-29 days', strtotime($end))));

        $client = new BetaAnalyticsDataClient([
            'credentials' => $keyPath
        ]);

        $response = $client->runReport([
            'property' => "properties/{$propertyId}",
            'dateRanges' => [
                ['startDate' => $start, 'endDate' => $end]
            ],
            'dimensions' => [
                ['name' => 'date']
            ],
            'metrics' => [
                ['name' => 'screenPageViews']
            ],
        ]);

        $rows = [];
        $total = 0;

        foreach ($response->getRows() as $row) {
            $date = $row->getDimensionValues()[0]->getValue();
            $pv = (int) $row->getMetricValues()[0]->getValue();

            $rows[] = [
                'date' => $date,
                'pageviews' => $pv
            ];

            $total += $pv;
        }

        $avg = count($rows) ? round($total / count($rows), 2) : 0;

        return response()->json([
            'rows' => $rows,
            'total' => $total,
            'avg_per_day' => $avg,
            'pct_change' => null
        ]);
    }
}
