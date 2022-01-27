<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Note;
use Carbon\CarbonPeriod;
use App\Models\Organization;
use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\NoteDistribution;
use ConsoleTVs\Charts\BaseChart;

class SampleChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $thisMonth = Carbon::now();
        $sixMonthAgo = Carbon::now()->subMonth(11);
    
        $notes = Note::oldest()->where('created_at', '<=', now())
                        ->where('created_at' , '>=', $sixMonthAgo->startOfMonth())
                        ->get()->groupBy(function($note) {
            $a = Carbon::parse($note->created_at->toDateTimeString())->format('Y-M');
            return $a;
        });

        $noteSends = NoteDistribution::oldest()
                    ->where('created_at', '<=', now())
                    ->where('created_at' , '>=', $sixMonthAgo->startOfMonth())
                    ->get()->groupBy(function($note) {
                        $a = Carbon::parse($note->created_at->toDateTimeString())->format('Y-M');
                        return $a;
                    });

        $noteReads = NoteDistribution::oldest()
                                ->where('is_read', true)
                                ->where('created_at', '<=', now())
                                ->where('created_at' , '>=', $sixMonthAgo->startOfMonth())
                                ->get()->groupBy(function($note) {
                                    $a = Carbon::parse($note->created_at->toDateTimeString())->format('Y-M');
                                    return $a;
                                });

        $period = CarbonPeriod::create(now()->subMonth(5),'1 month', now());
        foreach ($period as $date) {
            $monthLables[] =  $date->format('Y-M');
        }


        $organizations = Organization::all();

        $chart = Chartisan::build()
        ->labels($monthLables);

        foreach ($monthLables as $keyMonth => $month) {
            $data['data'][] = $notes->has($month) ? $notes[$month]->count() : 0;
            $data['send'][] = $noteSends->has($month) ?  $noteSends[$month]->count() : 0;
            $data['read'][] = $noteReads->has($month) ?  $noteSends[$month]->count() : 0;
        }
        
        // foreach ($notes as $key => $row) {
        //     $data['data'][] = $row->count();
        // }

    
        $chart->dataset('Notulen Dibuat', $data['data']);
        $chart->dataset('Notulen Terikim', $data['send']);
        $chart->dataset('Notulen Dibaca', $data['read']);

        return $chart;
    }
}