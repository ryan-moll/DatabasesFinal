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
  
$player = $_POST['playerName'];

$player = mysqli_real_escape_string($conn, $player);

$playerQuery = "SELECT CONCAT(fname, ' ', lname) AS 'Name', salary1819 AS 'Salary', (ppg+rebounds+blocks+assists+steals-fouls-turnovers) AS 'Value' FROM player JOIN playerStat USING(playerID) JOIN playerSalary USING(playerID) WHERE CONCAT(fname, ' ', lname) LIKE '";
$playerQuery = $playerQuery.$player."';";
$betterThanQuery = "SELECT CONCAT(fname, ' ', lname) AS 'Name', salary1819 AS 'Salary', (ppg+rebounds+blocks+assists+steals-fouls-turnovers) AS 'Value' FROM player JOIN playerStat USING(playerID) JOIN playerSalary USING(playerID) WHERE (ppg+rebounds+blocks+assists+steals-fouls-turnovers) > (SELECT (ppg+rebounds+blocks+assists+steals-fouls-turnovers) AS 'main' FROM player JOIN playerStat USING(playerID) JOIN playerSalary USING(playerID) WHERE CONCAT(fname, ' ', lname) LIKE '";
$betterThanQuery = $betterThanQuery.$player."') ORDER BY (ppg+rebounds+blocks+assists+steals-fouls-turnovers) ASC LIMIT 5;";

$worseThanQuery = "SELECT CONCAT(fname, ' ', lname) AS 'Name', salary1819 AS 'Salary', (ppg+rebounds+blocks+assists+steals-fouls-turnovers) AS 'Value' FROM player JOIN playerStat USING(playerID) JOIN playerSalary USING(playerID) WHERE (ppg+rebounds+blocks+assists+steals-fouls-turnovers) < (SELECT (ppg+rebounds+blocks+assists+steals-fouls-turnovers) AS 'main' FROM player JOIN playerStat USING(playerID) JOIN playerSalary USING(playerID) WHERE CONCAT(fname, ' ', lname) LIKE '";
$worseThanQuery = $worseThanQuery.$player."') ORDER BY (ppg+rebounds+blocks+assists+steals-fouls-turnovers) DESC LIMIT 5;";

?>


<p>
The queries:
<p>
<?php
print $playerQuery;
print $betterThanQuery;
print $worseThanQuery;
?>

<hr>
<p>
Result of queries:
<p>

<?php
$playerResult = mysqli_query($conn, $playerQuery)
or die(mysqli_error($conn));
$betterResult = mysqli_query($conn, $betterThanQuery)
or die(mysqli_error($conn));
$worseResult = mysqli_query($conn, $worseThanQuery)
or die(mysqli_error($conn));

print "<pre>";
print "\nPlayers better than $player :\n";
$totalSal = 0;
$playerSal = 0;
while($row = mysqli_fetch_array($betterResult, MYSQLI_BOTH))
  {
    print "\n";
    print "$row[Name]  $row[Salary] $row[Value]";
    $totalSal = $totalSal + $row[Salary];
  }
print "\nPlayers worse than $player :\n";
while($row = mysqli_fetch_array($worseResult, MYSQLI_BOTH))
  {
    print "\n";
    print "$row[Name]  $row[Salary] $row[Value]";
    $totalSal = $totalSal + $row[Salary];
  }
print "\n$player :\n";
while($row = mysqli_fetch_array($playerResult, MYSQLI_BOTH))
  {
    print "\n";
    print "$row[Name]  $row[Salary] $row[Value]";
    $playerSal = $row[Salary];
  }
$avgSal = $totalSal/10;
print "\nAverage salary for players like $player : $avgSal \n";
if($playerSal > $avgSal){
    print "$player is being overpaid.";
}else{
    print "$player is being underpaid.";
}
print "</pre>";

mysqli_free_result($playerResult);
mysqli_free_result($betterResult);
mysqli_free_result($worseResult);

mysqli_close($conn);

?>

<p>
<hr>
 	 
 
</body>
</html>
	  
