<?php 
    require_once("../Required.php");
    Required::SwiftLogger();

    require_once("prevent_access_if_not_localhost.php");
    
    $logger = new SwiftLogger(ROOT_DIRECTORY,false);
    $logger->clearLogs();

    $queryString = $_SERVER['QUERY_STRING'];
    header('Location:read-logs.php?'.$queryString, true, 303);
?>
