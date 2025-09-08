<?php
    /*
    Common Date Format Characters:
    d - Day of the month, 2 digits with leading zeros (01 to 31)
    j - Day of the month without leading zeros (1 to 31)
    m - Month as a number with leading zeros (01 to 12)
    n - Month as a number without leading zeros (1 to 12)
    M - Month as a three-letter abbreviation (Jan to Dec)
    F - Full month name (January to December)
    Y - Full year, 4 digits (e.g., 2024)
    y - Year, 2 digits (e.g., 24)
    l - Full day of week (Sunday to Saturday)
    D - Day of week as three-letter abbreviation (Sun to Sat)
    h - Hour in 12-hour format with leading zeros (01 to 12)
    H - Hour in 24-hour format with leading zeros (00 to 23)
    i - Minutes with leading zeros (00 to 59)
    s - Seconds with leading zeros (00 to 59)
    a - Lowercase Ante meridiem and Post meridiem (am or pm)
    A - Uppercase Ante meridiem and Post meridiem (AM or PM)
    */

    echo "<h2>Different Date Formats:</h2>";

    // Basic date format
    echo "1. Basic date (d/m/Y): " . date("d/m/Y") . "<br>";

    // Date with month name
    echo "2. Date with month name: " . date("d F Y") . "<br>";

    // Date with day name
    echo "3. Full day and date: " . date("l, d F Y") . "<br>";

    // Short date format
    echo "4. Short date format: " . date("D, d M y") . "<br>";

    echo "<h2>Time Formats:</h2>";

    // 12-hour time format
    echo "5. 12-hour time: " . date("h:i:s a") . "<br>";

    // 24-hour time format
    echo "6. 24-hour time: " . date("H:i:s") . "<br>";

    // Complete date and time
    echo "7. Complete date and time: " . date("l, d F Y - H:i:s") . "<br>";

    echo "<h2>Custom Date Operations:</h2>";

    // Tomorrow's date
    echo "8. Tomorrow: " . date("d F Y", strtotime("+1 day")) . "<br>";

    // Next week
    echo "9. Next week: " . date("d F Y", strtotime("+1 week")) . "<br>";

    // First day of next month
    echo "10. First day of next month: " . date("d F Y", strtotime("first day of next month")) . "<br>";

    // Check if it's weekend
    $isWeekend = (date('N') >= 6);
    echo "11. Is it weekend? " . ($isWeekend ? "Yes" : "No") . "<br>";

    // Days remaining in this month
    $daysInMonth = date("t");
    $currentDay = date("d");
    echo "12. Days remaining in this month: " . ($daysInMonth - $currentDay) . "<br>";

    echo "<h2>Setting Default Timezone:</h2>";

    // Setting the default timezone to your desired timezone
    date_default_timezone_set("Africa/Cairo");

    echo "13. The timezone now is: " . date_default_timezone_get() . "<br>";

    echo "The current time is: " . date("h:i:s A") . "<br>";
?>