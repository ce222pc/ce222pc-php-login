<?php

class DateTimeView {
    public function show() {
        $dt = new DateTime();
        
        // Day of week, ex. Monday
        $weekDay = $dt->format('l');
        
        // Date of month, ex. 21
        $date = $dt->format('j');
        
        // Suffix of date of month, ex. st
        switch (substr($date, -1)) {
            case 1:
                $dateSuffix = "st";
                break;
            case 2:
                $dateSuffix = "nd";
                break;
            case 3:
                $dateSuffix = "rd";
                break;
            default:
                $dateSuffix = "th";
                break;
        }

        // Month, ex. September
        $month = $dt->format('F');

        // Year, ex. 2016
        $year = $dt->format('Y');

        // Time, ex. 13:37:00
        $time = $dt->format('H:i:s');

        $timeString = "$weekDay, the $date$dateSuffix of $month $year, The time is $time";
        return '<p>' . $timeString . '</p>';
    }
}
