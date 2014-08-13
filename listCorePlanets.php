<?php
/**
 * Created by PhpStorm.
 * User: patkohler
 * Date: 6/6/14
 * Time: 7:24 PM
 */


$dbconn = mysql_connect("mysql17.000webhost.com", "a4907786_hypsad", "yre9udyzy");

if(!$dbconn) {
    echo "Database error!";
}

mysql_select_db("a4907786_hyps", $dbconn);

// Generate list of players
$query = "SELECT * FROM `players` ORDER BY name ASC;";
$res = mysql_query($query, $dbconn);

while($users[] = mysql_fetch_array($res));

if(isset($_GET['player_id'])) {
    // Get last update ID
    $query = "SELECT id FROM `updates` ORDER BY id DESC LIMIT 0,1;";
    $res = mysql_query($query, $dbconn);

    $uid = mysql_fetch_array($res);

    //get all cored planets next
    $query = "SELECT planets.id, planets.name, planets.x_coord, planets.y_coord, planets.race, planets.prod_type, planets.civ_lvl, planets.activity FROM `planets`, `cores` WHERE planets.sc = '6' AND planets.uid = '$uid[0]' AND cores.player_id = '$_GET[player_id]' AND (planets.id = cores.planet_1 OR planets.id = cores.planet_2 OR planets.id = cores.planet_3 OR planets.id = cores.planet_4 OR planets.id = cores.planet_5 OR planets.id = cores.planet_6 OR planets.id = cores.planet_7 OR planets.id = cores.planet_8 OR planets.id = cores.planet_9 OR planets.id = cores.planet_10 OR planets.id = cores.planet_11 OR planets.id = cores.planet_12 OR planets.id = cores.planet_13 OR planets.id = cores.planet_14) ORDER BY planets.id ASC;";
    $res = mysql_query($query, $dbconn);

}
?>

<html>
<head>
    <title>Player Core Planet List</title>
</head>
<body>

<a href="./index.php">Home</a> | <a href="./listCorePlanets.php">List Cores</a> | <a href="./playerManage.php">Manage Players</a><br/><br/>
<form method="get" action="listCorePlanets.php">
    <label>Select Player</label>
    <select name="player_id">
<?php
    foreach($users as $player) {
        echo "<option value=\"$player[0]\">$player[1]</option>";
    }
?>
    </select>
    <input type="submit" value="Select"/>
</form>
<table cellspacing="2" cellpadding="1">
    <th>Planet ID</th>
    <th>Planet Name</th>
    <th>Coordinates</th>
    <th>Race</th>
    <th>Prod. Type</th>
    <th>Civ. Level</th>
    <th>Activity</th>
<?php
if(isset($_GET['player_id'])) {
    $type[0] = 0;
    $type[1] = 0;
    $type[2] = 0;
    $race[0] = 0;
    $race[1] = 0;
    $race[2] = 0;

    while($planet = mysql_fetch_array($res)) {
        $type[$planet[5]]++;
        $race[$planet[4]]++;

        echo "<tr><td>$planet[0]</td><td>$planet[1]</td><td>($planet[2],$planet[3])</td><td>";
        switch($planet[4]) {
            case 0:
                echo "H";
                break;
            case 1:
                echo "A";
                break;
            case 2:
                echo "X";
                break;
        }
        echo "</td><td>";
        switch($planet[5]) {
            case 0:
                echo "A";
                break;
            case 1:
                echo "M";
                break;
            case 2:
                echo "T";
                break;
        }
        echo "</td><td>$planet[6]</td><td>$planet[7]</td></tr>";
    }
    echo "<tr rows=\"2\"><td cols=\"7\">Core Stats</td></tr>";
    echo "<tr><td>Agros:</td><td>$type[0]</td><td cols=\"3\">&nbsp;</td><td>Humans:</td><td>$race[0]</td></tr>";
    echo "<tr><td>Mineros:</td><td>$type[1]</td><td cols=\"3\">&nbsp;</td><td>Azterks:</td><td>$race[1]</td></tr>";
    echo "<tr><td>Technos:</td><td>$type[2]</td><td cols=\"3\">&nbsp;</td><td>Xillors:</td><td>$race[2]</td></tr>";
}
?>
</table>

<a href="http://www.000webhost.com/" target="_blank"><img src="http://www.000webhost.com/images/120x60_powered.gif" alt="Web Hosting" width="120" height="60" border="0" /></a>
</body>
</html>