<?php
$setDevice="e-infor.fr";
$setPort="1123"; 

shell_exec("adb connect ".$setDevice.":".$setPort." ");
sleep(1);
 
if ($_GET["cmd"] == "mycanal") 
{
shell_exec('adb shell monkey -p com.canal.android.canal 1');
}

else 
{
$cmd=$_GET["cmd"];
$num=str_split($cmd);
shell_exec("adb shell input keyevent KEYCODE_'".$num[0]."' input keyevent KEYCODE_'".$num[1]."' input keyevent KEYCODE_'".$num[2]."'");
}

shell_exec('adb shell exit');
?>

