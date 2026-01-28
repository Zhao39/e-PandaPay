<?php

namespace App\Services;

use Carbon\Carbon;

class RoiDateCalculatorService
{
    /**
     * Calculate the next ROI date based on the interval and start date.
     *
     * @param string $interval
     * @param \Carbon\Carbon $startDate
     *
     * @return \Carbon\Carbon
     */
    public function getNextRoiDate(string $interval, Carbon $startDate): Carbon
    {
        $currentDay = $startDate->day;
        $nextGrowth = match ($interval) {
            'Every 10 Minutes' => $startDate->addMinutes(10),
            'Every 15 Minutes' => $startDate->addMinutes(15),
            'Every 30 Minutes' => $startDate->addMinutes(30),
            'Hourly' => $startDate->addHour(),
            'Every 2 Hours' => $startDate->addHours(2),
            'Every 4 Hours' => $startDate->addHours(4),
            'Every 6 Hours' => $startDate->addHours(6),
            'Daily' => $startDate->addDay(),
            'Twice Daily' => $startDate->addHours(12),
            'Weekly' => $startDate->addWeek(),
            'Weekly on Monday at 8:00' => $startDate->next(Carbon::MONDAY)->setTime(8, 0),
            'Monthly' => $startDate->addMonth(),
            'Twice Monthly' => match (true) {
                $currentDay < 15 => $startDate->copy()->day(15), // If before the 15th, set ROI to the 15th
                $currentDay >= 15 => $startDate->copy()->addMonthNoOverflow()->day(1), // If on or after the 15th, set ROI to the 1st of next month
            },
            'Last Day of the Month' => $startDate->lastOfMonth(),
            'Quarterly' => $startDate->addQuarter(),
            'Quarterly on 4th at 14:00' => $startDate->addQuarter()->day(4)->setTime(14, 0),
            'Yearly' => $startDate->addYear(),
            'Yearly on June 1st at 17:00' => $startDate->copy()->month(6)->day(1)->setTime(17, 0),
            default => $startDate,
        };

        // If the calculated date is before now, adjust accordingly
        if ($nextGrowth->lt(now()->inUserTimezone())) {
            $nextGrowth = $this->adjustDate($interval, $nextGrowth);
        }

        return $nextGrowth;
    }

    /**
     * Adjust the date if it's in the past.
     *
     * @param string $interval
     * @param \Carbon\Carbon $date
     *
     * @return \Carbon\Carbon
     */
    private function adjustDate(string $interval, Carbon $date): Carbon
    {
        return match ($interval) {
            'Every 10 Minutes' => $date->addMinutes(10),
            'Every 15 Minutes' => $date->addMinutes(15),
            'Every 30 Minutes' => $date->addMinutes(30),
            'Hourly' => $date->addHour(),
            'Every 2 Hours' => $date->addHours(2),
            'Every 4 Hours' => $date->addHours(4),
            'Every 6 Hours' => $date->addHours(6),
            'Daily' => $date->addDay(),
            'Twice Daily' => $date->addHours(12),
            'Weekly' => $date->addWeek(),
            'Weekly on Monday at 8:00' => $date->addWeek(),
            'Monthly' => $date->addMonth(),
            'Twice Monthly' => $date->addMonthNoOverflow(),
            'Last Day of the Month' => $date->addMonthNoOverflow()->lastOfMonth(),
            'Quarterly' => $date->addQuarter(),
            'Quarterly on 4th at 14:00' => $date->addMonths(3),
            'Yearly' => $date->addYear(),
            'Yearly on June 1st at 17:00' => $date->addYear(),
            default => $date,
        };
    }
}