<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectScheduleController extends Controller
{
    public function index()
    {
        $schedules = DB::table('project_schedule')
            ->orderBy('start_date', 'asc')
            ->get();

        return view('project.index', compact('schedules'));
    }

    public function events()
    {
        $events = DB::table('project_schedule')
            ->select(
                'id',
                'title',
                'description',
                'lecturer',
                'note',
                'start_date',
                'end_date',
                'color'
            )
            ->get();

        $result = [];

        foreach ($events as $event) {

            $result[] = [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'backgroundColor' => $event->color,
                'borderColor' => $event->color,

                'extendedProps' => [
                    'description' => $event->description,
                    'lecturer'   => $event->lecturer,
                    'note'       => $event->note,
                ]
            ];
        }

        return response()->json($result);
    }
}
