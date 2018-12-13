<?php
# this include file contains some helper functions: 
include("dns-functions.php");    
echo "<br>"."database return: ".readIpFromDatabase()."<br>";
echo "<br>"."request " .getIpFromRequest()."<br>";
if ( readIpFromDatabase() == getIpFromRequest()) {
  echo "<br>"."no change in IP, address is " . getIpFromRequest() ."<br>" ;
  //header("HTTP/1.1 304 IP address didn't change", true, 304);
  
} else {
  if (writeIpToDatabase()){
    //header("HTTP/1.0 200 OK", true, 200);
    echo "<br>"."change successful, new address is " . getIpFromRequest() ."<br>" ;
  } else {
    //header("HTTP/1.0  500 Error writing file or similar", true, 500);
    echo "<br>"."error writing file or other"."<br>";
    exit;
  }
}
?>