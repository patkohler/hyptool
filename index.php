<?php
/**
 * Created by PhpStorm.
 * User: patkohler
 * Date: 4/8/14
 * Time: 5:39 PM
 */

function _get_color($i = FALSE) {
    $out = array(
        '#0000dd',
        '#dd0000',
        '#21B6A8',
        '#87907D',
        '#ec6d66',
        '#177F75',
        '#B6212D',
        '#B67721',
        '#da2d8b',
        '#7F5417',
        '#FF8000',
        '#61e94c',
        '#FFAABF',
        '#91C3DC',
        '#FFCC00',
        '#E5E0C1',
        '#68BD66',
        '#179CE8',
        '#BBFF20',
        '#30769E',
        '#FFE500',
        '#C8E9FC',
        '#758a09',
        '#00CCFF',
        '#FFC080',
        '#4086AA',
        '#FFAABF',
        '#0000AA',
        '#AA6363',
        '#AA9900',
        '#1A8BC0',
        '#ECF8FF',
        '#758a09',
        '#dd3100',
        '#dea04a',
        '#af2a30',
        '#EECC99',
        '#179999',
        '#BBFF20',
        '#a92e03',
        '#dd9cc9',
        '#f30320',
        '#579108',
        '#ce9135',
        '#acd622',
        '#e46e46',
        '#53747d',
        '#36a62a',
        '#83877e',
        '#e82385',
        '#73f2f2',
        '#cb9fa4',
        '#12c639',
        '#f51b2b',
        '#985d27',
        '#3595d5',
        '#cb9987',
        '#d52192',
        '#695faf',
        '#de2426',
        '#295d5a',
        '#824b2d',
        '#08ccf6',
        '#e82a3c',
        '#fcd11a',
        '#2b4c04',
        '#3011fd',
        '#1df37b',
        '#af2a30',
        '#c456d1',
        '#dcf174',
        '#025df6',
        '#0ab24f',
        '#c0d962',
        '#62369f',
        '#73faa9',
        '#fb453c',
        '#0487a4',
        '#ce9e07',
        '#2b407e',
        '#c28551',

    );

    if ($i !== FALSE AND $i < count($out)) {
        $out = $out[$i];
    }else{
        $out = rgb2html(rand(0,255), rand(0,255), rand(0,255));
    }


    return $out;
}

$dbconn = mysql_connect("mysql17.000webhost.com", "a4907786_hypsad", "yre9udyzy");

if(!$dbconn) {
    echo "Database error!";
}

mysql_select_db("a4907786_hyps", $dbconn);

if(isset($_GET['sc'])) {
    $sc = "$_GET[sc]";
}
else {
    $sc = "6";
}

if(isset($_GET['tag_highlight'])) {
    $tag = $_GET['tag_highlight'];
}
else {
    $tag = "[III]";
}

if($_POST['acts'] == "update") {
    $cored = $_POST['core_planets'];
    for($i = 0; $i < 14; $i++) {
        if($cored[$i] != NULL) {
            $core[$i] = $cored[$i];
        }
        else {
            $core[$i] = "NULL";
        }
    }

    //update row
    $query = "UPDATE `cores` SET `planet_1`=$core[0], `planet_2`=$core[1], `planet_3`=$core[2], `planet_4`=$core[3], `planet_5`=$core[4], `planet_6`=$core[5], `planet_7`=$core[6], `planet_8`=$core[7], `planet_9`=$core[8], `planet_10`=$core[9], `planet_11`=$core[10], `planet_12`=$core[11], `planet_13`=$core[12], `planet_14`=$core[13] WHERE id = '$_POST[core_id]';";
    $res = mysql_query($query, $dbconn);
   // $num = mysql_result($res, $dbconn);
}

if($_GET['acts'] == "select_player") {
    $query = "SELECT planet_1, planet_2, planet_3, planet_4, planet_5, planet_6, planet_7, planet_8, planet_9, planet_10, planet_11, planet_12, planet_13, planet_14 FROM `cores` WHERE id = '$_GET[core_id]';";
    $res = mysql_query($query, $dbconn);
    $player_planets = mysql_fetch_array($res);
   // echo "<pre>".print_r($player_planets)."</pre>";
}

// Generate list of players
$query = "SELECT `cores`.id, `cores`.player_id as player_id, `players`.name FROM `cores`, `players` WHERE `cores`.player_id = `players`.id ORDER BY `players`.name ASC;";
$res4 = mysql_query($query, $dbconn);
while($assignedCores[] = mysql_fetch_array($res4));

$query = "SELECT `cores`.id FROM `cores` WHERE `cores`.player_id IS NULL ORDER BY `cores`.id ASC;";
$res5 = mysql_query($query, $dbconn);
while($unassignedCores[] = mysql_fetch_array($res5));
$listCores = array_merge($assignedCores,$unassignedCores);

if(isset($_GET['core_id'])) {
    $query = "SELECT `cores`.id, `players`.name FROM `cores`, `players` WHERE `cores`.id = '$_GET[core_id]' AND (`cores`.player_id = `players`.id OR `cores`.player_id IS NULL);";
    $res2 = mysql_query($query, $dbconn);
}

// Get last update ID
$query = "SELECT id FROM `updates` ORDER BY id DESC LIMIT 0,1;";
$res = mysql_query($query, $dbconn);

$uid = mysql_fetch_array($res);

//get all cored planets next
$query = "SELECT planet_1, planet_2, planet_3, planet_4, planet_5, planet_6, planet_7, planet_8, planet_9, planet_10, planet_11, planet_12, planet_13, planet_14, player_id FROM `cores` ORDER BY id ASC;";
$res = mysql_query($query, $dbconn);

while($allianceCore[] = mysql_fetch_array($res));

// Get planets from last ID
$query = "SELECT * FROM `planets` WHERE sc = '$sc' AND uid = '$uid[0]' ORDER BY y_coord DESC, x_coord ASC, id ASC";
$res = mysql_query($query, $dbconn);
$planet = mysql_fetch_array($res);

$p = 0;
$scSize = sizeof($planet);

$scRadius = $planet['y_coord'] + 1;


echo "<html>";
echo "<head>";
echo "<link href=\"./theme_std.css\" rel=stylesheet type=\"text/css\" />";
?>
<script src="./js/jquery-1.10.2.js"></script>
<script src="./js/jquery-ui-1.10.4.custom.min.js"></script>
<link rel="stylesheet" href="./css/mint-choc/jquery-ui-1.10.4.custom.css" />
<script type="text/javascript">
$("document").ready(function() {
    $(document).tooltip();
});
</script>
<?php
echo "</head>";
echo "<body>";
echo "<a href=\"./index.php\">Home</a> | <a href=\"./listCorePlanets.php\">List Cores</a> | <a href=\"./playerManage.php\">Manage Players</a><br/><br/>";
//need to make a form to select cores to edit and to add a new core, then we can do a check on the planet ID to see if it is taken, by who, and what not.
//might think about doing a hover/onclick that dynamically generates a form to update a selected planet. might get complicated.
if(!isset($_GET['core_id'])) {

    echo "<form method=\"get\" action=\"./index.php\">";
    echo "<label>Player:</label>";
    echo "<select name=\"core_id\">";
    echo "<option>Please select a core</option>";
    foreach($assignedCores as $cores) {
        echo "<option value=\"$cores[0]\">$cores[0] assigned to $cores[2]</option>";
    }
    foreach($unassignedCores as $cores) {
        echo "<option value=\"$cores[0]\">$cores[0] is not assigned</option>";
    }
    echo "</select>";
    echo "<input type=\"hidden\" name=\"acts\" value=\"select_player\"/>";
    echo "<input type=\"submit\" value\"Select Player\"/></form>";
}
else {
    $cores = mysql_fetch_array($res2);
    echo "<form method=\"post\" action=\"index.php\">";
    echo "<h1>$_GET[core_id] assigned to ";
    if(isset($cores['id'])) {
        echo "$cores[name]";
    }
    else {
        echo "<i>NO ONE</i>";
    }

    echo "</h1>";
    echo "<input type=\"hidden\" name=\"core_id\" value=\"$cores[id]\"/>";
    echo "<input type=\"hidden\" name=\"acts\" value=\"update\"/>";
    echo "<input type=\"submit\" value=\"Update with Selected Planets\"/>";
}
echo "<table class=\"tinytext\">";

for($j = $scRadius; $j >= $scRadius*(-1); $j--) {//y
    echo "<tr class=\"vt\">";
    for($i = $scRadius*(-1); $i <= $scRadius; $i++) {//x
        echo "<td class=\"tacMapZone hc\">";
        echo "($i,$j)<table class=\"array\">";
            while($planet['x_coord'] == $i && $planet['y_coord'] == $j) {
                echo "<tr>";
                if(isset($_GET['core_id'])) {
                    if(sizeof($player_planets) > 0) {
                        for($k = 0; $k < 14; $k++) {
                            if($player_planets[$k] == $planet['id']) {
                                $checked = "checked";
                                break;
                            }
                            else {
                                $checked = "";
                            }
                        }
                    }

                    echo "<td class=\"hc\"";
                    if($checked != "") {
                        echo "style=\"background-color: red\"";
                    }
                    echo "><input type=\"checkbox\" name=\"core_planets[]\" value=\"$planet[id]\" $checked/></td>";
                }
                echo "<td class=\"h1 \"";
                foreach($allianceCore as $core) {
                    for($k = 0; $k < 14; $k++) {
                        if($core[$k] == $planet['id']) {
                            foreach($listCores as $cores) {
                                if(isset($cores['player_id'])) {
                                    if($core[14] == $cores['player_id']) {
                                        //echo "\n\n <!--- $core[14] and $cores[id] --->\n\n";
                                        echo "style=\"color: #000000; background-color: ";
                                        echo ""._get_color($cores['id'])."";
                                        echo "\"";
                                        echo "title=\"Core $cores[id] assigned to ";
                                        if(isset($cores['name'])) {
                                            echo "$cores[name]";
                                        }
                                        else {
                                            echo "no one";
                                        }
                                        echo "\"";
                                        break;
                                    }
                                }
                            }
                            break;
                        }
                    }
                    if($k < 14) break;
                }
                echo ">$planet[name]</td>";
                echo "<td class=\"";
                switch($planet['gov_sys']) {
                    case 0:
                        echo "Dict\">D";
                        break;
                    case 1:
                        echo "Auth\">A";
                        break;
                    case 2:
                        echo "Demo\">D";
                        break;
                    case 3:
                        echo "Hyp\">H";
                        break;
                }
                echo "</td>";
                echo "<td class=\"hc \"";
                if($planet[public_tag] == $tag) echo " style=\"background-color: #003366;\"";
                echo ">$planet[public_tag]</td>";
                echo "<td class=\"hc \">$planet[civ_lvl]</td>";
                echo "<td class=\"";
                switch($planet[race]) {
                    case 0:
                        echo "Human\">H";
                        break;
                    case 1:
                        echo "Azterk\">A";
                        break;
                    case 2:
                        echo "Xillor\">X";
                        break;
                }
                echo "</td>";
                echo "<td class=\"";
                switch($planet[prod_type]) {
                    case 0:
                        echo "Agro\">A";
                        break;
                    case 1:
                        echo "Minero\">M";
                        break;
                    case 2:
                        echo "Techno\">T";
                        break;
                }
                echo "</td>";
                echo "<td class=\"hr info \">$planet[activity]</td></tr>";
                $planet = mysql_fetch_array($res);
            }
        echo "</table></td>";
    }
    echo "</tr>";
}

echo "</table>";
echo "</form>";

//echo "<!---";
//print_r($listCores);
//echo "--->";

?>

<a href="http://www.000webhost.com/" target="_blank"><img src="http://www.000webhost.com/images/120x60_powered.gif" alt="Web Hosting" width="120" height="60" border="0" /></a>
</body>
</html>