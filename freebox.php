<?php
include 'config.php';

$_GET["cmd"] = isset($_GET['cmd']) ? $_GET['cmd'] : null ;
$_GET["nom"] = isset($_GET['nom']) ? $_GET['nom'] : null ;
$nombrut = isset($_GET['nom']) ? $_GET['nom'] : null ;
$cmd = isset($_GET['cmd']) ? $_GET['cmd'] : null ;
$count = 0 ;
$debug = false;
$displayinfos = true;

if ($debug == true)
{
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}


//Connexion
shell_exec("adb connect '".$setDevice."':'".$setPort."'");
usleep(800000);

// Var for launching apps :
if ($_GET["cmd"] == "mycanal") 
{
shell_exec('adb shell monkey -p com.canal.android.canal 1');
exit;
}


echo "<h1><div align=center> Freebox Player POP Remote Control</div> </h1>";
if ($nombrut != NULL) 
KEYCODE_MEDIA_PLAY_PAUSE

{
if (strpos($nombrut, 'sur ') !== false) {
$nombrut = str_replace("sur ", "", $nombrut );
}
//Gestion play/pause	
if (strpos($nombrut, 'pause' !== false) {
shell_exec("adb shell input adb shell input keyevent KEYCODE_DPAD_CENTER | adb shell input keyevent KEYCODE_DPAD_CENTER");
shell_exec("adb disconnect");
}
if (strpos($nombrut, 'play' !== false) {
shell_exec("adb shell input adb shell input keyevent KEYCODE_DPAD_CENTER | adb shell input keyevent KEYCODE_DPAD_CENTER");
shell_exec("adb disconnect");
}   
//Check Is channel numbers or channel name
if (is_numeric($nombrut))
{
$num = $nombrut;
if ($displayinfos == true)
	{
		echo "<strong> Change via NUM </strong>";
		echo '<br/><br/>';
		echo "Channel number : ".$num;
		echo '<br/><br/>';
	}
goto zap ;
}

//Channel rewrite

include 'rewrite.php';

//Find channel uuid
retry:
if ($count == 1) { $count = 2 ; }

$json1 = file_get_contents('http://mafreebox.freebox.fr/api/v3/tv/channels');
$data1 = json_decode($json1);
foreach ($data1->result as $item1) {
	if (strcasecmp($item1->name, $nombrut) == 0 ){
	    $uuid = $item1->uuid;
	echo '</br>';
goto suite;
 }   
}

$nombrut = str_replace(" ", "", $nombrut );
if ($count == 2) { 
echo "<strong> Channel not found </strong>";
echo $nombrut;
exit ; 
}

$count = 1;

goto retry; 

//Find channel number with UUID
suite:
$json2 = file_get_contents('http://mafreebox.freebox.fr/api/v3/tv/bouquets/freeboxtv/channels');
$data2 = json_decode($json2);
foreach ($data2->result as $item2) {
    if ($item2->uuid == $uuid) {
//		echo $item2->number;
		$num = $item2->number;
//		echo '</br>';
    }
}

if ($displayinfos == true)
	{
		echo "<strong> Change via NOM </strong>";
		echo '<br/><br/>';
		echo "Raw channel number : ".$nombrut;
		echo '<br/><br/>';
		echo "Channel number : ".$uuid;
		echo '<br/><br/>';
		echo "Channel: ".$num;
		echo '<br/><br/>';		
	}
goto zap ;
}

// Changement chaine sur le player
zap:
shell_exec("adb shell 'dumpsys activity activities | grep mResumedActivity | grep oqee ; if (($?==1));then am start -n net.oqee.androidtv/.ui.main.MainActivity;usleep 300000;fi'");
shell_exec("adb shell input text '".$num."' ");
shell_exec("adb disconnect");

?>
