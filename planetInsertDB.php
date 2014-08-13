<?php
/**
 * Created by PhpStorm.
 * User: patkohler
 * Date: 5/1/14
 * Time: 11:07 PM
 */

/*
http://www.hyperiums.com/servlet/HAPI?game=Hyperiums7&player=NightDragon&passwd=t0rt0ise&request=download&filetype=
?game=Hyperiums7&player=NightDragon&passwd=t0rt0ise&request=download&filetype={players|planets|events|alliances}
 * */

//url = "http://www.hyperiums.com/servlet/HAPI?gameid=1&playerid=57941&authkey=454536208&failsafe=54321&request=getplanetinfo&planet=arfarfarf&data=general";

//Need to do insert for update and what not.

file_put_contents("planetlist_Hyperiums7.txt.gz", file_get_contents("http://hyp2.hyperiums.com/servlet/HAPI?game=Hyperiums7&player=NightDragon&passwd=t0rt0ise&request=download&filetype=planets"));

$dbconn = mysql_connect("mysql17.000webhost.com", "a4907786_hypsad", "yre9udyzy");

if(!$dbconn) {
    echo "Database error!";
}

mysql_select_db("a4907786_hyps", $dbconn);

$query = "INSERT INTO updates (val) VALUES(1);";
$result = mysql_query($query, $dbconn);

$uid = mysql_insert_id($dbconn);
$track = 0;
$lines = gzfile('planetlist_Hyperiums7.txt.gz');
foreach ($lines as $line) {
    if($line[0] != '#') {
        $planet = explode(" ", $line);

        $plane['planet_id'] = $planet[0];
        $plane['planet_name'] = $planet[1];
        $plane['x_coord'] = $planet[3];
        $plane['y_coord'] = $planet[4];
        $plane['gov_sys'] = $planet[2];
        $plane['race'] = $planet[5];
        $plane['prod_type'] = $planet[6];
        $plane['activity'] = $planet[7];
        $plane['public_tag'] = $planet[8];
        $plane['civ_lvl'] = $planet[9];
        $plane['planet_size'] = $planet[10];
        $plane['sc'] = $planet[11];

        if($planet[11] == 6) {
            //$res = pg_insert($dbconn, 'planet_current', $plane);
            $query = "INSERT INTO planets (id, name, x_coord, y_coord, race, prod_type, gov_sys, civ_lvl, activity, public_tag, planet_size, sc, uid) VALUES ($plane[planet_id],'$plane[planet_name]', $plane[x_coord], $plane[y_coord], $plane[race], $plane[prod_type], $plane[gov_sys], $plane[civ_lvl], $plane[activity], '$plane[public_tag]', $plane[planet_size], $plane[sc], $uid);";
            $res = mysql_query($query, $dbconn);
            //$res = pg_execute($dbconn, "planets", $planet);

            echo "-".mysql_error($dbconn)."<br/>";
            //echo "$query<br/><br/>";
        }
        else {
            $track++;
        }
    }
}

echo "$track records ignored.";

?>
<a href="http://www.000webhost.com/" target="_blank"><img src="http://www.000webhost.com/images/120x60_powered.gif" alt="Web Hosting" width="120" height="60" border="0" /></a>
