<?php
include 'config.php';

//$setDevice="e-infor.fr";
//$setPort="1123";
//$conn = mysql_connect("localhost:3306", "freebox", "freebox") or die;
//$db = mysql_select_db("chaine");

$_GET["cmd"] = isset($_GET['cmd']) ? $_GET['nom'] : null ;
$_GET["nom"] = isset($_GET['nom']) ? $_GET['nom'] : null ;
$nom = isset($_GET['nom']) ? $_GET['nom'] : null ;
$cmd = isset($_GET['cmd']) ? $_GET['nom'] : null ;


//Connection au player
shell_exec("adb connect '".$setDevice."':'".$setPort."'");
sleep(1);

//echo $nom ;
//----------------------------------------------------------------
// Variable pour lancement d appli :
 
if ($_GET["cmd"] == "mycanal") 
{
shell_exec('adb shell monkey -p com.canal.android.canal 1');
break;
}
//----------------------------------------------------------------

//Verif si commande avec numeros ou nom de chaine
if ($_GET["cmd"] != NULL)
{
$num=$_GET["cmd"];
goto zap ;
}

if ($nom != NULL) 
{
//req chaine<>numeros
$sqlnum = "SELECT `free` FROM `chaines` WHERE `nom` = '$nom' ";
$resultnum = mysql_query($sqlnum)  ;
$chaine = mysql_fetch_array($resultnum);
$num = $chaine['free'];
goto zap ;
}


// Changement chaine sur le player
zap:
shell_exec("adb shell input text '".$num."' ");
shell_exec("adb disconnect");

?>
