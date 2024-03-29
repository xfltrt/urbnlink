@extends('layouts.dashboard')

@section('script_head')
    <script src="{{ asset('js/Chart.min.js') }}" defer></script>
@endsection

@section('create_button')
    @can('createLinkFor', $project)
        <a href='{{ url("/{$project->name}/links/create") }}' class="btn items-center flex">
            <svg class="feather h-4 w-4 -ml-1"><use xlink:href="{{ url('/img') }}/feather-sprite.svg#plus"/></svg>
            <span class="ml-1">Link</span>
        </a>
    @endcan
@endsection

@section('content')
    @component('components.header')
        @slot('title') {{ $link->domain.'/'.$link->name }} @endslot
        @slot('sub_title')
            {{ $link->url }}
            <span class="block mt-2 text-gray-500">in <a href='{{ url($project->name) }}' class="text-indigo-600 border-b-2 border-dotted">{{ $project->name }}</a></span>
        @endslot
    @endcomponent

    <ul class=" flex border-b mb-8">
        <li class="-mb-px"><span class="bg-white inline-block px-4 py-2 border-l border-r border-t rounded-t">Statistics</span></li>
        <li class=""><a href='{{ url()->current()."/rules" }}' class="inline-block px-4 py-2 text-indigo-600">Rules</a></li>
        <li class=""><a href='{{ url()->current()."/edit" }}' class="inline-block px-4 py-2 text-indigo-600">Edit</a></li>
    </ul>

    @if ($stats['total'] > 0)
        <canvas id="chart" height="100"></canvas>
        <div class="mt-6 leading-loose">
            <h3 class="text-gray-500 uppercase text-xs tracking-wide mb-2">Top Referrers</h3>
            @foreach ($stats['referrers'] as $referrer=>$value)
                <div class="flex items-center font-light text-sm">
                    <div class="flex-none inline-block bg-indigo-100 text-indigo-600 text-xs px-2 py-0 rounded">{{ $value }}</div>
                    <div class="flex-auto inline-block truncate ml-2">{{ $referrer }}</div>
                </div>
            @endforeach
        </div>
        <div class="mt-6 leading-loose">
            <h3 class="text-gray-500 uppercase text-xs tracking-wide mb-2">Top Pages Visited</h3>
            @foreach ($stats['countries'] as $country=>$value)
                <div class="flex items-center font-light text-sm">
                    <div class="flex-none inline-block bg-indigo-100 text-indigo-600 text-xs px-2 py-0 rounded">{{ $value }}</div>
                    <div class="flex-auto inline-block truncate ml-2">{{ $country !== '' ? $country : 'Unknown' }}</div>
                </div>
            @endforeach
        </div>
        <div class="mt-6 leading-loose">
            <h3 class="text-gray-500 uppercase text-xs tracking-wide mb-2">Top Pages Visited</h3>
            @foreach ($stats['pages'] as $page=>$value)
                <div class="flex items-center font-light text-sm">
                    <div class="flex-none inline-block bg-indigo-100 text-indigo-600 text-xs px-2 py-0 rounded">{{ $value }}</div>
                    <div class="flex-auto inline-block truncate ml-2">{{ $page }}</div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center">
            <img src='{{ url("/img/empty-statistics.png") }}' class="mx-auto max-h-64 mb-6 rounded-lg" />
            <p class="text-lg font-light">Hold on, no statistics yet.</p>
        </div>
    @endif

    <div class="mt-12">
        <a href='{{ url($project->name) }}' class="text-indigo-600 border-b-2 border-dotted">See your other links.</a>
    </div>
@endsection

@section('script_body')
    <script>
        window.onload = function () {
            var ctx = document.getElementById('chart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [{!! implode(', ', array_keys($stats['hits'])) !!}],
                    datasets: [{
                        backgroundColor: '#a3bffa',
                        data: [{{ implode(', ', $stats['hits']) }}]
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                display: false    
                            },
                            gridLines: {
                                display: false
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                precision: 0
                            }
                        }]
                    }
                }
            });
        };
    </script>
@endsection
