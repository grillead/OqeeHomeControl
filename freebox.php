<?php
include 'config.php';

$_GET["cmd"] = isset($_GET['cmd']) ? $_GET['nom'] : null ;
$_GET["nom"] = isset($_GET['nom']) ? $_GET['nom'] : null ;
$nombrut = isset($_GET['nom']) ? $_GET['nom'] : null ;
$cmd = isset($_GET['cmd']) ? $_GET['nom'] : null ;


//Connection au player
shell_exec("adb connect '".$setDevice."':'".$setPort."'");
usleep(500000);
shell_exec("adb shell am start -n net.oqee.androidtv/.ui.main.MainActivity");
usleep(500000);

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

if ($nombrut != NULL) 
{
//req chaine<>numeros convertie les espace %20 en %
echo $nombrut;
$nom = str_replace(" ", "%", $nombrut );
echo $nom ;

$sqlnum = "SELECT `free` FROM `chaines` WHERE `nom` like '$nom' ";
echo $sqlnum;
$resultnum = mysql_query($sqlnum)  ;
$chaine = mysql_fetch_array($resultnum);
$num = $chaine['free'];
echo $num;
goto zap ;
}


// Changement chaine sur le player
zap:
shell_exec("adb shell input text '".$num."' ");
shell_exec("adb disconnect");

?>
