<?php
# script for moving from one upload_dir to another

$path = '/var/www/upload/upload_avail/';
//print_r( shell_exec("ls -la ".$path."; ls -ld ".$path));

$link = mysql_connect("db.usic.lan", "site", $argv[1]);
mysql_select_db("site", $link);

$query = "select * from upload";
$res = mysql_query($query, $link);
//$n = mysql_num_rows($res);
$row = array();
while($r = mysql_fetch_array($res, MYSQL_ASSOC)) {
    $row[] = $r;
}
$n = sizeof($row);
// copying to new dir, update the db and deleting from old dir
for($i=0; $i<$n; ++$i) {
    $old = $row[$i]["url"];
    $hash = substr($old,($a=strrpos($old, '/')+1), strrpos($old, '.')-$a);
    if (!mkdir($path.$hash)) {
	echo $path.$hash."\n"; exit(1);
    }
    $new = $path.$hash.'/'.$row[$i]["filename"];
    $command = "cp ".$old." ".$new;//echo $command."\n\n";
    echo shell_exec($command);
    $query = "update upload set url='".$new."' where id='".$row[$i]["id"]."'";
    mysql_query($query);
    echo shell_exec("rm ".$old);
}

echo "ok";
/*for($i=0; $i<$n; ++$i) {
    echo "id = ".$row[$i]["id"]."\n";
    echo "filename = ".$row[$i]["filename"]."\n";
    echo "url = ".$row[$i]["url"]."\n";
    echo "\n";
}*/


mysql_close($link);
?>
