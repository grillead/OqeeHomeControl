<?php

include 'config.php';

$debug = false;
$displayinfos = true;

if ($debug == true)
{
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}

$nombrut = isset($_GET['nom']) ? $_GET['nom'] : null ;

$num = null;

//---------------------------------------------------------------

echo "<h1> Freebox Player POP Remote Control </h1>";

//Input number information
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
}

//Input texte information
if ($nombrut !== NULL && !is_numeric($nombrut)) 
{
	//Format channel
	if (strpos($nombrut, 'musique') !== false) 
	{
		$nombrut = str_replace("musique", "music", $nombrut );
	}
	if (strpos($nombrut, 'plus 1') !== false) 
	{
		$nombrut = str_replace("plus 1", "+1", $nombrut );
	}
	if (strpos($nombrut, 'mangas') !== false) 
	{
		$nombrut = str_replace("mangas", "manga", $nombrut );
	}
	if (strpos($nombrut, 'sur ') !== false) 
	{
		$nombrut = str_replace("sur ", "", $nombrut );
	}

	//Convert spaces %20 to %
	$nom = str_replace(" ", "%", $nombrut );
	
	//Request
	//$sqlnum = "SELECT `free` FROM `chaines` WHERE `nom` like '$nom' ";
	$sqlnum = "SELECT `free` FROM `chaines` WHERE `nom` like :nom ";

	$stmt = $dbh->prepare($sqlnum);
	$stmt->execute(array(':nom' => $nom));
	$chaine = $stmt->fetch(PDO::FETCH_ASSOC);

	$num = $chaine['free'];

	if ($displayinfos == true)
	{
		echo "<strong> Change via NOM </strong>";
		echo '<br/><br/>';
		echo "Raw channel number : ".$nombrut;
		echo '<br/><br/>';
		echo "Channel number : ".$nom;
		echo '<br/><br/>';
		echo "Request: ".$sqlnum;
		echo '<br/><br/>';
		echo "Channel: ".$num;
		echo '<br/><br/>';		
	}
}


// Change channel
if ($num != NULL) 
{
	if ($displayinfos == true)
	{
		echo "<strong> Change channel </strong>";
		echo '<br/><br/>';
	}

	//Connexion to the player
	$outputconnection = shell_exec("adb connect '".$setDevice."':'".$setPort."'");
	usleep(800000);
	if ($displayinfos == true)
	{
		echo "Connection player : ".$outputconnection;
		echo '<br/><br/>';
	}

	// Test if Free application is already running
	$oqee = shell_exec("adb -s '".$setDevice."' shell 'dumpsys activity activities | grep mResumedActivity | grep oqee '");
	if ($oqee == NULL)
	{
		shell_exec("adb -s '".$setDevice."' shell am start -n net.oqee.androidtv/.ui.main.MainActivity; usleep 300000;");
	}

	//Change channel
	shell_exec("adb -s '".$setDevice."' shell input text '".$num."' ");
	if ($displayinfos == true)
	{
		echo "Channel changed to: ".$num;
		echo '<br/><br/>';
	}
	shell_exec("adb -s '".$setDevice."' disconnect");
}

?>
