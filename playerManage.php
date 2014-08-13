<?php
/**
 * Created by PhpStorm.
 * User: patkohler
 * Date: 6/6/14
 * Time: 10:24 PM
 */


$dbconn = mysql_connect("mysql17.000webhost.com", "a4907786_hypsad", "yre9udyzy");

if(!$dbconn) {
    echo "Database error!";
}

mysql_select_db("a4907786_hyps", $dbconn);

if(isset($_GET['player_id'])) { //change cores
    $query = "UPDATE `cores` SET `player_id` = '$_GET[player_id]' WHERE `id` = '$_GET[core_id]' LIMIT 1;";
    $res = mysql_query($query, $dbconn);
}
else if(isset($_GET['new_player_name'])) { //add new Player
    $query = "INSERT INTO `players` (name) VALUES('$_GET[new_player_name]');";
    $res = mysql_query($query, $dbconn);
    $newPlayerID = mysql_insert_id($dbconn);
}
else if(isset($_GET[newcore])) { //create new core
    $query = "INSERT INTO `cores` (sc) VALUES(6);";
    $res = mysql_query($query, $dbconn);
}

$query = "SELECT id, name FROM `players` ORDER BY name ASC;";
$res = mysql_query($query, $dbconn);

$query = "SELECT `cores`.id, `players`.name FROM `cores`, `players` WHERE `cores`.player_id = `players`.id ORDER BY `players`.name ASC;";
$res2 = mysql_query($query, $dbconn);

$query = "SELECT `cores`.id FROM `cores` WHERE `cores`.player_id IS NULL ORDER BY `cores`.id ASC;";
$res3 = mysql_query($query, $dbconn);


echo "<a href=\"./index.php\">Home</a> | <a href=\"./listCorePlanets.php\">List Cores</a> | <a href=\"./playerManage.php\">Manage Players</a><br/><br/>";
?>

<form method="get" action="./playerManage.php">
    <fieldset>
        <legend>Attach Player to Existing Core</legend>
        Assign
        <select name="player_id">
            <option value="">Player to assign to core</option>
<?php
        while($players = mysql_fetch_array($res)) {
            echo "<option value=\"$players[0]\">$players[1]</option>";
        }
?>
        </select>
        to core
        <select name="core_id">
            <option value="core_id">Core ID and Player assigned to core</option>
<?php
        while($cores = mysql_fetch_array($res2)) {
            echo "<option value=\"$cores[0]\">$cores[0] assigned to $cores[1]</option>";
        }
        while($cores = mysql_fetch_array($res3)) {
            echo "<option value=\"$cores[0]\">$cores[0] is not assigned</option>";
        }
?>
        </select>
        <input type="submit" value="Attach to Core"/>
    </fieldset>
</form>

<form method="get" action="./playerManage.php">
    <fieldset>
        <legend>New Player</legend>
        New Player Name: <input type="text" name="new_player_name"/>
        <input type="submit" value="Create New Player"/>
    </fieldset>
</form>

<form method="get" action="./playerManage.php">
    <fieldset>
        <legend>New Core</legend>
        <input type="hidden" name="newcore" value="true"/>
        <input type="submit" value="Create Core"/>
    </fieldset>
</form>


<a href="http://www.000webhost.com/" target="_blank"><img src="http://www.000webhost.com/images/120x60_powered.gif" alt="Web Hosting" width="120" height="60" border="0" /></a>