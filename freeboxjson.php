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
$nombrut = str_replace("musique", "Music", $nombrut );
}
if (strpos($nombrut, 'plus 1') !== false) {
$nombrut = str_replace("plus 1", "+1", $nombrut );
}
if (strpos($nombrut, 'manga') !== false) {
$nombrut = str_replace("manga", "mangas", $nombrut );
}
if (strpos($nombrut, 'sur ') !== false) {
$nombrut = str_replace("sur ", "", $nombrut );
}
 //req chaine<>numeros convertie les espace %20 en %
echo $nombrut;
echo '</br>';
//$nombrut = str_replace(" ", "", $nombrut );
//echo $nombrut;
//echo '</br>';

retry:
$json1 = file_get_contents('http://mafreebox.freebox.fr/api/v3/tv/channels');
$data1 = json_decode($json1);
foreach ($data1->result as $item1) {
//    if (stripos($item1->name,$nombrut) !==false && $item1->available == 'true') {
	if (strcasecmp($item1->name, $nombrut) == 0 ){
	    $uuid = $item1->uuid;
echo $uuid;
	echo '</br>';
goto suite;
 }   
}
 
$nombrut = str_replace(" ", "", $nombrut );
echo $nombrut;
echo '</br>';
goto retry; 



suite:
$json2 = file_get_contents('http://mafreebox.freebox.fr/api/v3/tv/bouquets/freeboxtv/channels');
$data2 = json_decode($json2);
foreach ($data2->result as $item2) {
    if ($item2->uuid == $uuid) {
		echo $item2->number;
		$num = $item2->number;
		echo '</br>';
    }
}
echo $nom;
goto zap ;
}


// Changement chaine sur le player
zap:
shell_exec("adb shell 'dumpsys activity activities | grep mResumedActivity | grep oqee ; if (($?==1));then am start -n net.oqee.androidtv/.ui.main.MainActivity;usleep 300000;fi'");
shell_exec("adb shell input text '".$num."' ");
shell_exec("adb disconnect");

?>
