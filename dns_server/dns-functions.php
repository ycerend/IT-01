<?php
define('SERVER', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'dns_server');
# get IP address from request parameter, or if none is given, 
# from the REMOTE_ADDR parameter
function getIpFromRequest() {
  # just in case the IP is in the request parameters, you never know: 
  if (isset($_GET["ip"])) {
    return $_GET["ip"];
  } 
  if (isset($_POST["ip"])) {
    return $_POST["ip"];
  } 
  # if it's not, we get it from the remote address parameter: 
  return $_SERVER["REMOTE_ADDR"];
}

# read the IP address from the file. 
function readIpFromDatabase() {
  $conn = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);
  $project_name = "";
  if (isset($_GET["project_name"])) {
    $project_name = $_GET["project_name"];
  } 
  if (isset($_POST["project_name"])) {
    $project_name = $_POST["project_name"];
  }
  ($project_name !="") or die("project name can't be reachable from request");

  
  $sql = "SELECT * from project_information WHERE project_name='$project_name'";
  $result =$conn->query($sql); 
  mysqli_close($conn);
  if ($result->num_rows > 0) {
    
    // output data of each row
    while($row = $result->fetch_assoc()) {
       return long2ip($row["project_ipv4"]);
    }
  } else {
    echo "0 results";
  }
}

# write the IP to the file. will return 'false' if there is a problem. 
function writeIpToDatabase(){
  $conn = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);
  #project name query'den gelmeli, test için direkt verdik
  $project_name = "test";
  $ip_to_be = getIpFromRequest();
  $sql ="UPDATE project_information SET project_ipv4=INET_ATON('$ip_to_be') WHERE project_name= '$project_name' ";
  $updateCheck = $conn->query($sql);
  mysqli_close($conn);
  return $updateCheck;

}


?>