<?php 

    require_once("SwiftDatetime.php");
   
    $swiftDatetime = new SwiftDatetime(); 
   
    try{
        // $now = $swiftDatetime->now();
        // var_dump($now);
        $myDatetime = $swiftDatetime->now()->asObject();
        // $myDatetime->add(new DateInterval('PT1H')); //add 1 hour
        // $myDatetime->add(new DateInterval('PT10M')); //add 10 minutes
        // $myDatetime->add(new DateInterval('PT120S')); //add 120 seconds
        // $myDatetime->add(new DateInterval('P1Y')); //add 1 year
        // $myDatetime->add(new DateInterval('P1M')); //add 1 month
        // $myDatetime->add(new DateInterval('P1D')); //add 1 day

        $asYmdHis = $swiftDatetime->now()->addDays(1)->asdmYHis();
        echo $asYmdHis;
    }
    catch(Exception $exp){
        die($exp->getMessage());
    }

   



   
?>