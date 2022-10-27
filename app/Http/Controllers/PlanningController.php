<?php

namespace App\Http\Controllers;

use App\Models\Planning;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Cmixin\BusinessTime;
use stdClass;

class PlanningController extends Controller
{
    public function registerSchedule()
    {
        BusinessTime::enable(Carbon::class, [
            'monday' => ['10:00-19:30'],
            'tuesday' => ['10:00-19:30'],
            'wednesday' => ['10:00-19:30'],
            'thursday' => ['10:00-19:30'],
            'friday' => ['10:00-19:30'],
            'saturday' => ['10:00-19:30'],
            'sunday' => ['10:00-19:30'],
            'exceptions' => [],
            'holidays' => [],
        ]);
    }

    public function getSchedulesAt(Request $request)
    {
        $this->registerSchedule();
        $start_date = Carbon::parse($request->start_date);
        $start_date->setHour(0);
        $start_date->setMinute(0);
        $start_date->setSecond(0);
        $tomorrow = Carbon::parse($request->start_date)->addDay();
        $date = new stdClass;
        // dd($start_date->toDateString() );
        while ($start_date->toDateString() != $tomorrow->toDateString()) {
            $horraire = $start_date->addMinutes(30);
            if ($horraire->isOpen()) {
                $schedule = new stdClass;
                $date_info = new stdClass;
                $schedule->time = $horraire->toTimeString('minute');
                $date_info->day = $horraire->format('d');
                $date_info->name = $horraire->format('l');
                $date_info->month = $horraire->format("M");
                $date_info->full = $start_date->toDateString();
                $schedule->lesson = Planning::where('scheduled_at', Carbon::parse($horraire)->toDateTimeString())->first();
                if (is_null($schedule->lesson)) {
                    $schedule->disabled = false;
                } else {
                    $schedule->disabled = true;
                }
                $date->date = $date_info;
                $date->hours[] = $schedule;
            } else {
                $start_date->nextOpen();
            }
        }
        return $date;
    }

    public function getTimeTable()
    {
        $this->registerSchedule();
        $start_date = Carbon::now()->setHours(10);
        $start_date->minute = $start_date->second = 0;
        $dates = [];
        while ($start_date <= Carbon::now()->setHours(7)->addDays(15)) {
            $horraire = $start_date->addMinutes(30);
            if ($horraire->isOpen()) {
                $schedule = new stdClass;
                $date_info = new stdClass;
                $schedule->time = $horraire->toTimeString('minute');
                $date_info->day = $horraire->format('d');
                $date_info->name = $horraire->format('l');
                $date_info->month = $horraire->format("M");
                $date_info->full = $start_date->toDateString();
                $schedule->lesson = Planning::where('scheduled_at', Carbon::parse($horraire)->toDateTimeString())->first();
                if (is_null($schedule->lesson)) {
                    $schedule->disabled = false;
                } else {
                    $schedule->disabled = true;
                }
                $dates[$start_date->toDateString()]["date"] = $date_info;
                $dates[$start_date->toDateString()]["hours"][] = $schedule;
            } else {
                $start_date->nextOpen();
            }
        }
        return $dates;
    }



    public function addBooking(Request $request)
    {
        if (!Planning::where('date', Carbon::parse($request->date)->toDateTimeString())->exists()) {
            $planning = Planning::create([
                'user_id'  => $request->user_id,
                'coiffeur_id' => $request->coiffeur_id,
                'date' => $request->date
            ]);

            return response()->json([
                'status' => 'success',
                'planning' => $planning,
                'planning' => [
                    'coiffeur' => $request->coiffeur_id,
                    'date' => $request->date,
                ]
            ]);
        } else {

            return response()->json([
                'status' => 'Error, already planned'
            ], 401);
        }
    }

    public function addUnavailability(Request $request)
    {
        $planning = Planning::create([
            'user_id'  => $request->user_id,
            'coiffeur_id' => $request->coiffeur_id,
            'date' => $request->date
        ]);

        return response()->json([
            'status' => 'success',
            'planning' => $planning,
            'planning' => [
                'coiffeur' => $request->coiffeur_id,
                'date' => $request->date,
            ]
        ]);
    }

    public function removeUnavailability(Request $request)
    {
        $planning = Planning::where([
            'user_id'  => $request->user_id,
            'coiffeur_id' => $request->coiffeur_id,
            'date' => $request->date
        ])->delete();

        return response()->json([
            'status' => 'success',
            'planning' => $planning,
            'planning' => [
                'coiffeur' => $request->coiffeur_id,
                'date' => $request->date,
            ]
        ]);
    }
}
