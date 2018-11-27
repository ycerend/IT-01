<html>
    <head>
        <title>My first PHP Website</title>
    </head>
   <?php
   session_start(); //starts the session
   if($_SESSION['user']){ // checks if the user is logged in  
   }
   else{
      header("location: index.php"); // redirects if user is not logged in
   }
   $user = $_SESSION['user']; //assigns user value
   ?>
    <body>
        <h2>Home Page</h2>

    </body> 

     <?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "itage_database";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT * from user_table WHERE username='$user'";
$result = $conn->query($sql);
$user_id = "";
echo $user;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //echo "<br> id: ". $row["id"]. " - Name: ". $row["url_"]. " " . $row["ip"] . "<br>";
        $user_id =$row["id"];
    }

} else {
    echo "0 results";
}
$sql = "SELECT * from router_table_auth WHERE user_id='$user_id'";
$result = $conn->query($sql);
$machine_id = "";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $machine_id =$row["router_id"];
        $sql2 = "SELECT * from router_table WHERE id='$machine_id'";
        $result2 = $conn->query($sql2);
        $url ="" ;
        $ip  = "";
        if ($result2->num_rows > 0) {
        // output data of each row
        echo "<ul>";
            while($row = $result2->fetch_assoc()) {
                
                $url =$row["url_"];
                $ip =$row["ipv4"];
                $ip_to_be = (string)(gethostbyname($url));
                if($ip_to_be != long2ip($ip)){
                    $sql ="UPDATE router_table SET url_= '$url' ,ipv4=INET_ATON('$ip_to_be') WHERE id = '$machine_id'";
                    $conn->query($sql);
                    if ($conn->query($sql) === TRUE) {
                        echo "Record updated successfully";
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                }
                echo "<li>";
                echo "<a href='" . $url. "'>" . $url  . "</a><br />";
                echo   long2ip($ip)."<hr />";
                echo "</li>";
                //echo "<br>  router id: ". $url." ".long2ip($ip). "<br>";
            }
        echo "</ul>";

            } else {
                echo "0 results";
            }
        }

} else {
    echo "0 results";
}
    
    

?>
</html>



