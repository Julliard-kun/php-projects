<?php
    "This is about switch.";

    "Switch is used to check multiple conditions.";

    $favorite_day = "Saturday";

    switch ($favorite_day) {
        case "Monday":
            echo "4 more days to Friday.";
            break;
        case "Tuesday":
            echo "3 more days to Friday.";
            break;
        case "Wednesday":
            echo "2 more days to Friday.";
            break;
        case "Thursday":
            echo "1 more days to Friday.";
            break;
        case "Friday":
            echo "Finally Friday. Go out and enjoy your weekend.";
            break;
        case "Saturday":
            echo "Weekend day. Go out and enjoy your weekend.";
            break;
        case "Sunday":
            echo "Weekend day. Go out and enjoy your weekend.";
            break;
        default:
            echo "Invalid day.";
            break;
    }

?>