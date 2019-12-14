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
  
$playerOne = $_POST['playerOne'];
$playerTwo = $_POST['playerTwo'];

$playerOne = mysqli_real_escape_string($conn, $playerOne);
$playerTwo = mysqli_real_escape_string($conn, $playerTwo);

$queryOne = "SELECT CONCAT(fname, ' ', lname) AS 'name', (ppg+rebounds+blocks+assists+steals-fouls-turnovers) AS 'value' FROM player JOIN playerStat USING(playerID) WHERE CONCAT(fname, ' ', lname) LIKE '";
$queryOne = $queryOne.$playerOne."';";
$queryTwo = "SELECT CONCAT(fname, ' ', lname) AS 'name', (ppg+rebounds+blocks+assists+steals-fouls-turnovers) AS 'value' FROM player JOIN playerStat USING(playerID) WHERE CONCAT(fname, ' ', lname) LIKE '";
$queryTwo = $queryTwo.$playerTwo."';";

?>


<p>
The queries:
<p>
<?php
print $queryOne;
?>
<p>
<?php
print $queryTwo;
?>

<hr>
<p>
Result of queries:
<p>

<?php
$resultOne = mysqli_query($conn, $queryOne)
or die(mysqli_error($conn));
$resultTwo = mysqli_query($conn, $queryTwo)
or die(mysqli_error($conn));
$best = 0;
$betterPlayer = "";
print "<pre>";
while($row = mysqli_fetch_array($resultOne, MYSQLI_BOTH))
  {
    print "Player 1:\n";
    print "$row[name]  $row[value]";
    if($row[value] > $best){
        $best = $row[value];
        $betterPlayer = $row[name];
    }
}
while($row = mysqli_fetch_array($resultTwo, MYSQLI_BOTH))
  {
    print "\nPlayer 2:\n";
    print "$row[name]  $row[value]\n";
    if($row[value] > $best){
      $best = $row[value];
      $betterPlayer = $row[name];
    }
  }
print "</pre>";
print "\nThe better player is: \n$betterPlayer\n";

mysqli_free_result($resultOne);
mysqli_free_result($resultTwo);

mysqli_close($conn);
?>

<p>
<hr>
 	 
 
</body>
</html>
	  
