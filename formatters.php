<?php

function red_black($value) {
    $v = (float) $value;
    if ($v < 0) {
        return "<span class=\"red\">" . sprintf("%0.2f", $v) . "</span>";
    } else {
        return sprintf("%0.2f", $v);
    }
}

?>
