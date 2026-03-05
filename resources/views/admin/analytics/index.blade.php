@extends('layouts.admin')

@section('title', 'Social Feeds')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<form method="GET"
      action="{{ route('admin.analytics.export.csv') }}"
      class="card p-3 mb-4">

    <h6 class="mb-3">Export Period</h6>

    {{-- MODE --}}
    <div class="mb-3">
        <label class="me-3">
            <input type="radio" name="mode" value="range" checked>
            Custom Date
        </label>
        
        <label>
            <input type="radio" name="mode" value="month_year">
            Month + Year
        </label>
    </div>

    {{-- RANGE --}}
    <div class="row g-2 period period-range">
        <div class="col-md-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control">
        </div>
        <div class="col-md-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control">
        </div>
    </div>

    {{-- MONTH --}}
    <div class="row g-2 period period-month d-none">
        <div class="col-md-3">
            <label>Month</label>
            <select name="month" class="form-control">
                @for($m=1;$m<=12;$m++)
                    <option value="{{ $m }}">{{ date('F', mktime(0,0,0,$m)) }}</option>
                @endfor
            </select>
        </div>
    </div>

    {{-- YEAR --}}
    <div class="row g-2 period period-year d-none">
        <div class="col-md-3">
            <label>Year</label>
            <select name="year" class="form-control">
                @for($y = now()->year; $y >= 2020; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
        </div>
    </div>

    {{-- MONTH + YEAR --}}
    <div class="row g-2 period period-month_year d-none">
        <div class="col-md-3">
            <label>Month</label>
            <select name="month" class="form-control">
                @for($m=1;$m<=12;$m++)
                    <option value="{{ $m }}">{{ date('F', mktime(0,0,0,$m)) }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3">
            <label>Year</label>
            <select name="year" class="form-control">
                @for($y = now()->year; $y >= 2020; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
        </div>
    </div>

    <div class="mt-3">
        @can('export.analytics')
        <button class="btn btn-success">
            Export CSV
        </button>    
        @endcan
    </div>
</form>

<canvas id="usersChart" height="120"></canvas>
<canvas id="viewsChart" height="120" style="margin-top:50px"></canvas>
<canvas id="sessionsChart" height="120" style="margin-top:50px"></canvas>
<canvas id="searchChart" height="120" style="margin-top:50px"></canvas>
<canvas id="socialChart" height="120" style="margin-top:50px"></canvas>
@php
$searchData = [];
$socialData = [];

foreach ($data['dates'] as $label) {
    $rawDate = \Carbon\Carbon::createFromFormat('d F Y', $label)
        ->format('Ymd');

    $searchData[] = $organicSearch[$rawDate] ?? 0;
    $socialData[] = $organicSocial[$rawDate] ?? 0;
}
@endphp


<script>
document.querySelectorAll('input[name="mode"]').forEach(radio => {
    radio.addEventListener('change', function () {
        document.querySelectorAll('.period').forEach(p => p.classList.add('d-none'));
        document.querySelector('.period-' + this.value).classList.remove('d-none');
    });
});
</script>


<script>
const labels = @json($data['dates']);
</script>

<script>
new Chart(document.getElementById('searchChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Organic Search Traffic',
            data: @json($searchData),
            borderWidth: 2
        }]
    }
});

new Chart(document.getElementById('socialChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Organic Social Traffic',
            data: @json($socialData),
            borderWidth: 2
        }]
    }
});
</script>

<script>

new Chart(document.getElementById('usersChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Users',
            data: @json($data['users']),
            borderWidth: 2
        }]
    }
});

new Chart(document.getElementById('viewsChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Page Views',
            data: @json($data['views']),
            borderWidth: 2
        }]
    }
});

new Chart(document.getElementById('sessionsChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Sessions',
            data: @json($data['sessions']),
            borderWidth: 2
        }]
    }
});
</script>

@endsection


