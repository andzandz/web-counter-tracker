<html>

<head>
<style>
a {
  color: lightgrey;
  text-shadow: none;
}

body {
  color: white;
  font-family: Sans-serif, "Arial", "Verdana";
  text-align: center;
  text-shadow: 2px 2px #000000;
  background-image: url("flag.png");
  background-color: #003399;
  background-repeat: no-repeat;
  background-position: center 200px; 
}

table {
  text-align: center;
  margin-left:auto; 
  margin-right:auto;
  background-color:rgba(0, 0, 0,0.6);
}

th {
  cursor:pointer;
  text-decoration: underline;
}

td {
}

</style>
<title>(YourThing) Tracker</title>

<script src="sorttable.js"></script>
</head>

<body>

<h1>(YourThing) Tracker</h1>

<a href="http://link.to.something/here">http://link.to.something/here</a><br>
<br>

<?php
//Crude view count!
system('echo "view!" >> viewcount');

$timestamp = 1466965322;

function unixToUTC($timestamp) 
{
  return gmdate('Y-m-d H:i', $timestamp);
}

function unixToUkTime($timestamp)
{
  $datetime = new DateTime('@' . $timestamp);
  $datetime->setTimeZone(new DateTimeZone('Europe/London'));
  return $datetime->format('Y-m-d H:i');
}

function unixToUkTimeOnly($timestamp)
{
  $datetime = new DateTime('@' . $timestamp);
  $datetime->setTimeZone(new DateTimeZone('Europe/London'));
  return $datetime->format('H:i');
}

function unixToUkDateOnly($timestamp)
{
  $datetime = new DateTime('@' . $timestamp);
  $datetime->setTimeZone(new DateTimeZone('Europe/London'));
  return $datetime->format('Y-m-d');
}

function getLines($filename)
{
  $contents = file_get_contents($filename);
  return explode("\n", $contents);
}

function intValue($int_string)
{
  return str_replace(',', '', $int_string);
}

function formatInt($int)
{
  return number_format($int);
}

$lines = getLines('../index.html');

echo '<table class="sortable"><tr>';
echo '<th width="250" id="th_time">Time (UK)</th>';
echo '<th width="250">Signatures</th>';
echo '<th width="250">Increase</th>';
echo '</tr>';

$last_row_count = 0;
foreach($lines as $line) if($line != '') {
  $line_parts = explode("|",$line);
  if(unixToUkTimeOnly($line_parts[1]) == '00:00') {
    echo "<tr><td>". unixToUkDateOnly($line_parts[1]) . " --------</td><td>-----</td><td>-----</td></tr>";
  }

  echo '<tr>';
  echo '<td>' . unixToUkTime($line_parts[1]) . '</td>';
  echo '<td>' . ($line_parts[0]) . '</td>';
  if($last_row_count > 0) {
    $increase = 2 * (intValue($line_parts[0]) - $last_row_count); 
    echo '<td>' . formatInt($increase) . ' / hour' . ' = ' . formatInt($increase*24) . ' / day</td>';
  } else {
    echo '<td>-</td>';
  }
  echo '</tr>';

  $last_row_count = intValue($line_parts[0]);
}

echo '</table>';

?>
<br><br><br>
<i>by Andy C. K</i>

<script>
setTimeout(function() {
  th_time = document.getElementById("th_time")
  th_time.click()
}, 750);
</script>

</body>
</html>
