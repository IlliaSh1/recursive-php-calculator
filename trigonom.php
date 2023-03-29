<?php 
    function calcTrigonom($pref, $x) {
        // echo "return "."$pref(".$x.");";
        $deg = ($x*pi()/180);
        $res = eval("return "."$pref(".$deg.");");
        return $res;

    }
    // var_dump(eval("return "."sin(30)".";"));
    $x = calcTrigonom("-cos","60");
    echo $x;
?>