<?php

include('connection.php');

//  This function helps with generating and assigning a client code to the client

function generateClientCode($conn, $name) {
    $name = strtoupper(trim($name));
    $words = preg_split("/[\s\-]+/", $name);
    $prefix = "";

    if (count($words) == 1) {
        $prefix = substr($words[0], 0, 3);
        while (strlen($prefix) < 3) {
            $prefix .= "X";
        }
    } else if (count($words) == 2) {
        $prefix = substr($words[0], 0, 2) . substr($words[1], 0, 1);
        $prefix = str_pad($prefix, 3, "X");
    } else {
        $prefix = substr($words[0], 0, 1) . substr($words[1], 0, 1) . substr($words[2], 0, 1);
    }

    $prefix = strtoupper($prefix);

    $num = 1;
    while (true) {
        $code = $prefix . str_pad($num, 3, "0", STR_PAD_LEFT);
        $check = mysqli_query($conn, "SELECT 1 FROM clients WHERE client_code = '$code' LIMIT 1");

        if (mysqli_num_rows($check) == 0) {
            break;
        }
        $num++;
    }

    return $code;
}



