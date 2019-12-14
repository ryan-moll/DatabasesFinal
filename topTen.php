<?php

include('nbaConData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
<head>
  <title>NBA Data</title>
  </head>
  
  <body bgcolor="white">
  
  
  <hr>
  
  
<?php
  
$category = $_POST['category'];

$category = mysqli_real_escape_string($conn, $category);
// this is a small attempt to avoid SQL injection
// better to use prepared statements

$query = "SELECT fName, lName, ";
$query = $query.$category;
$query = $query." as 'stat' FROM playerStat ps JOIN player p USING(playerID) ORDER BY ";
$query = $query.$category." DESC LIMIT 10;";

?>


<p>
The query:
<p>
<?php
print $query;
?>

<hr>
<p>
Result of query:
<p>

<?php
$result = mysqli_query($conn, $query)
or die(mysqli_error($conn));

print "<pre>";
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
  {
    print "\n";
    print "$row[fName]  $row[lName] $row[stat]";
  }
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>
 	 
 
</body>
</html>
	  
