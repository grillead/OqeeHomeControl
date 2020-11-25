<?php
include 'config.php';

$_GET["cmd"] = isset($_GET['cmd']) ? $_GET['nom'] : null ;
$_GET["nom"] = isset($_GET['nom']) ? $_GET['nom'] : null ;
$nombrut = isset($_GET['nom']) ? $_GET['nom'] : null ;
$cmd = isset($_GET['cmd']) ? $_GET['nom'] : null ;


//Connection au player
shell_exec("adb connect '".$setDevice."':'".$setPort."'");
usleep(800000);

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

//réecriture chaine
if (strpos($nombrut, 'musique') !== false) {
$nombrut = str_replace("musique", "music", $nombrut );
}
if (strpos($nombrut, 'plus 1') !== false) {
$nombrut = str_replace("plus 1", "+1", $nombrut );
}
if (strpos($nombrut, 'mangas') !== false) {
$nombrut = str_replace("mangas", "manga", $nombrut );
}
if (strpos($nombrut, 'sur ') !== false) {
$nombrut = str_replace("sur ", "", $nombrut );
}
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
shell_exec("adb shell 'dumpsys activity activities | grep mResumedActivity | grep oqee | if (($?==0));then am start -n net.oqee.androidtv/.ui.main.MainActivity;usleep 300000;fi'");
shell_exec("adb shell input text '".$num."' ");
shell_exec("adb disconnect");

?>
