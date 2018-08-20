<?php
function datestr($yr, $mo, $day) {
    // given year, month, and day, return "2018-08-15"
    return strftime("%Y-%m-%d", strtotime("$mo/$day/$yr"));
}

function datevals($s) {
    // given "2018-08-10", return an array with (d)ay, (m)onth, and (y)ear
    $arr = strptime($s, "%Y-%m-%d");
    $result = ["d" => $arr["tm_mday"],
               "m" => $arr["tm_mon"] + 1,
               "y" => $arr["tm_year"] + 1900];
    return $result;
}

function next_endpt($yr, $mo, $endpt) {
    // advance by one month
    if ($mo == 12) {
        return datestr($yr+1, 1, $endpt);
    } else {
        return datestr($yr, $mo+1, $endpt);
    }
}

function prev_endpt($yr, $mo, $endpt) {
    // go back one month
    if ($mo == 1) {
        return datestr($yr-1, 12, $endpt);
    } else {
        return datestr($yr, $mo-1, $endpt);
    }
}

function period_endpts($today) {  // today is a "2018-08-15" string
    $LEFT_BREAKPOINT = 15;
    $RIGHT_BREAKPOINT = 14;
    $vals = datevals($today);
    $day = $vals['d'];
    $month = $vals['m'];
    $year = $vals['y'];

    if ($day >= $LEFT_BREAKPOINT && $day <= 31) {
        $left = datestr($year, $month, $LEFT_BREAKPOINT);
        $right = next_endpt($year, $month, $RIGHT_BREAKPOINT);
    } else {
        $left = prev_endpt($year, $month, $LEFT_BREAKPOINT);
        $right = datestr($year, $month, $RIGHT_BREAKPOINT);
    }
    return [$left, $right];
}

?>
