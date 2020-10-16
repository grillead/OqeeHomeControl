<?php
//include 'fonction.php';

$setDevice="e-infor.fr";
$setPort="1123";
$conn = mysql_connect("localhost:3306", "root", ""); 
$nom = isset($_GET['nom']) ? $_GET['nom'] : null ;

shell_exec("adb connect ".$setDevice.":".$setPort." ");
sleep(1);
 
if ($_GET["cmd"] == "mycanal") 
{
shell_exec('adb shell monkey -p com.canal.android.canal 1');
break;
}

if ($nom != NULL) 
{
$nom = $_GET["nom"];
$sqlchaine = " SELECT free FROM `chaines` WHERE `nom` = '$nom' ";
$num = mysql_query($$sqlchaine);

goto zap ;
}


else 
{
$num=$_GET["cmd"];
}

zap:
echo $num ;
shell_exec("adb shell input text '".$num."' ");
shell_exec('adb shell exit');

?>
