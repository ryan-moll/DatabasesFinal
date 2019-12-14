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
  
$teamOne = $_POST['teamOne'];
$teamTwo = $_POST['teamTwo'];

$teamOne = mysqli_real_escape_string($conn, $teamOne);
$teamTwo = mysqli_real_escape_string($conn, $teamTwo);

$queryOne = "SELECT CONCAT(city, ' ', teamName) AS 'Team', CONCAT(wins, '-', losses) AS 'Record' FROM teams WHERE teamName LIKE '";
$queryOne = $queryOne.$teamOne."';";
$queryOneWins = "SELECT wins, teamName FROM teams WHERE teamName LIKE '";
$queryOneWins = $queryOneWins.$teamOne."';";
$queryTwo = "SELECT CONCAT(city, ' ', teamName) AS 'Team', CONCAT(wins, '-', losses) AS 'Record' FROM teams WHERE teamName LIKE '";
$queryTwo = $queryTwo.$teamTwo."';";
$queryTwoWins = "SELECT wins, teamName FROM teams WHERE teamName LIKE '";
$queryTwoWins = $queryTwoWins.$teamTwo."';";

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
$winsOne = mysqli_query($conn, $queryOneWins)
or die(mysqli_error($conn));
$resultTwo = mysqli_query($conn, $queryTwo)
or die(mysqli_error($conn));
$winsTwo = mysqli_query($conn, $queryTwoWins)
or die(mysqli_error($conn));
$best = 0;
$betterTeam = "";
print "<pre>";
while($row = mysqli_fetch_array($resultOne, MYSQLI_BOTH))
  {
    print "Team 1:\n";
    print "$row[Team]  $row[Record]";
  }
while($row = mysqli_fetch_array($winsOne, MYSQLI_BOTH))
  {
    $best = $row[wins];
    $betterTeam = $row[teamName];
  }
while($row = mysqli_fetch_array($resultTwo, MYSQLI_BOTH))
  {
    print "\nTeam 2:\n";
    print "$row[Team]  $row[Record]";
  }
while($row = mysqli_fetch_array($winsTwo, MYSQLI_BOTH))
  {
    if($row[wins] > $best){
        $best = $row[wins];
        $betterTeam = $row[teamName];
    }
  }
print "</pre>";
print "\nThe $betterTeam are the better team.\n";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>
     
 
</body>
</html>
      
