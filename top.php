<?php
    $fp = fopen("./data.csv",'r');
    $row = fgetcsv("$fp");
    echo "<pre>";
    print_r($row);
    echo "</pre>"


?>