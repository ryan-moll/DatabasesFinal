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
  
$coachTeam = $_POST['coachName'];

$coachTeam = mysqli_real_escape_string($conn, $coachTeam);
// this is a small attempt to avoid SQL injection
// better to use prepared statements

$query = "SELECT CONCAT(c.fname, ' ', c.lname) AS 'Coach', (c.wins/c.losses) AS 'Expected', (t.wins/t.losses) AS 'Result' FROM coach c JOIN teams t USING(teamID) WHERE t.teamName LIKE '";
$query = $query.$coachTeam."';";

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
$exp = "";
$res = "";

print "<pre>";
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
  {
    print "\n";
    print "Coach: $row[Coach]\n";
    $exp = $row[Expected];
    $res = $row[Result];
  }
if($exp == $res){
    if($exp < 1){
        print "\nThis was their first season. They had a losing win/loss rate of $exp \n";
    }else{
        print "\nThis was their first season. They had a winning win/loss rate of $exp \n";
    }
}else{
    if($exp < $res){
        print "\nThey overperformed! Their career win/loss rate is $exp and their season win/loss rate was $res \n";
    }else{
        print "\nThey underperformed. Their career win/loss rate is $exp and their season win/loss rate was $res \n";
    }
}
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>
 	 
 
</body>
</html>
	  
