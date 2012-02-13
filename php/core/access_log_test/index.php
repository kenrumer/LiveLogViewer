<?php

$log_file = '/app/asc/logs/core.lighttpd-multiple_ports.access.log';
$pattern = '/^([^ ]+) ([^ ]+) ([^ ]+) (\[[^\]]+\]) "(.*) (.*) (.*)" ([0-9\-]+) ([0-9\-]+) "(.*)" "(.*)"$/';

$fh = fopen($log_file,'r') or die($php_errormsg);
$i = 1;
$requests = array();
while (! feof($fh)) {
    // read each line and trim off leading/trailing whitespace
    if ($s = trim(fgets($fh,16384))) {
        // match the line to the pattern
        if (preg_match($pattern,$s,$matches)) {
            /* put each part of the match in an appropriately-named
             * variable */
            list($whole_match,$remote_host,$logname,$user,$time,
                 $method,$request,$protocol,$status,$bytes,$referer,
                 $user_agent) = $matches;
             // keep track of the count of each request 
            $requests[$request]++;
        } else {
            // complain if the line didn't match the pattern 
            error_log("Can't parse line $i: $s");
        }
    }
    $i++;
}
fclose($fh) or die($php_errormsg);

// sort the array (in reverse) by number of requests 
arsort($requests);

// print formatted results
foreach ($requests as $request => $accesses) {
    printf("%6d   %s\n",$accesses,$request);
}

?>
