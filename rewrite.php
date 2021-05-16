<?php 
if (strpos($nombrut, 'musique') !== false) {
$nombrut = str_replace("musique", "Music", $nombrut );
}
if (strpos($nombrut, 'plus 1') !== false) {
$nombrut = str_replace("plus 1", "+1", $nombrut );
}
if (strpos($nombrut, 'manga') !== false) {
$nombrut = str_replace("manga", "mangas", $nombrut );
}
if (strpos($nombrut, 'm 6') !== false) {
$nombrut = str_replace("m 6", "m6", $nombrut );
}
?>
