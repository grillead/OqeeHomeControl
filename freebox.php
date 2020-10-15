<?php
require_once ('adb.php');

$adb = new adb();
$setDevice = $adb->setDevice(['host' => '192.168.0.1', 'port' => 5555]);

//if($setDevice['success']) {
//	$adb->sendKey('KEYCODE_MEDIA_PAUSE');
// }
// shell_exec('adb connect 192.168.0.1');
 
if ($_GET["cmd"] == "mycanal") 
{
echo 'Je lance netflix';

        shell_exec('adb shell monkey -p com.canal.android.canal 1');
}
else {
//$i=0;
$cmd=$_GET["cmd"];
$num=str_split($cmd);
//while ($i < sizeof($num)){

$adb->sendKey("KEYCODE_'".$num[0]."' KEYCODE_'".$num[1]."' KEYCODE_'".$num[2]."' ");

//$adb->sendKey('KEYCODE_1');
//Print_f($num[$i]);
//}
echo $cmd[0] ;
echo  '<br/>' ."\n" ;
echo $cmd[1] ;
echo  '<br/>' ."\n" ;
echo $cmd[2] ;
echo  '<br/>' ."\n" ;
echo 'essaie encore';
}
// shell_exec('adb shell exit');
?>

