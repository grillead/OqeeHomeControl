<?php
require_once ('adb.php');

$adb = new adb();
$setDevice = $adb->setDevice(['host' => '192.168.0.1', 'port' => 5555]);

if ($_GET["cmd"] == "mycanal")
{
        shell_exec('adb shell monkey -p com.canal.android.canal 1');
}
else {
$cmd=$_GET["cmd"];
$num=str_split($cmd);
$adb->sendKey("KEYCODE_'".$num[0]."' KEYCODE_'".$num[1]."' KEYCODE_'".$num[2]."' ");
}

?>
