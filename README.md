# Freebox Android Home Control

Plugin pour contrôler la freebox POP avec Google Home (Changement de chaine via le Nom ou le numéros)

Les fonctions volume/extiction sont gérer en natif via google (grace à l option Chromecast) si vous avez ajouter la box à votre compte home.

Pre-requis : 

  L'activation du mode développeurs et du Débogage USB sur la box
  
  La mise en place d'une VM sur le serveur delta pour faire tourné les outils adb et php
  
  La création d'un applet sur ifttt pour lancer les chaines avec leurs noms.
  
  <br/>Liens vers la VM : http://bit.ly/freeboxhomecontrol (identifiant: freebox / pwd: freebox ) (Edit 24/11 MAJ Vm avec ip player : 192.168.0.1 par défaut)
  <br/>Merci de jouer le jeu et me faire un retour : https://github.com/grillead/freeboxandroidhomecontrol/issues/1
  
-----Partie Freebox Delta Serveur -----
<br/><strong>1/</strong> Assigner un bail dhcp au player pop (param par defaut dans la vm : 192.168.0.1 si autre ip modifier le fichier /var/www/html/config.php) + reboot player
<br/><strong>2/</strong> Mettre en place l image de la VM et la demarrer (http://bit.ly/freeboxhomecontrol)
<br/><strong>3/</strong> Assigner un bail dhcp à la VM + reboot vm
<br/><strong>4/</strong> Dans l interface freebox : Paramètre de la Freebox \ Gestion des ports => Ouvrir le port externe "1122"(ou un autre au choix) vers le port interne "1122" de la vm

-----Partie Player-----

<strong>5/</strong> Activation mod dev : 
<br/>Appuie 7 fois sur la touche "ok" sur le numeros de build dans la section "A propos"

<strong>6/</strong> Débogage USB:
<br/>A activé dans le menu "Options pour les développeurs"

<strong>7/</strong> Apparaige serveur : 
<br/>Un popup va s'afficher sur la box au moment de l envoie de la 1ere commande vocale,
<br/>il faut cocher la case se souvenir et autoriser la connexion une 1ere fois.

-----Création applet IFTTT -----

<strong>8/</strong> Créer un applet 

                "If This" Google Assistant > Phrase with TEXT incredient  (exemple chez moi : zappe sur la chaine $)

                "Then That" WebHooks vers l url : http://ip_externe_box:port-externe/freebox.php?nom={{TextField}}
                
</br><strong>ip_externe_box</strong> : votre adresse ip internet ou reverse DNS, si besoin : http://monip.org/
</br><strong>port-externe</strong> : le port ouvert sur la freebox vers le port 1122 de la VM
                
A la fin de ces manips, votre "ami google" doit etre en mesure de comprendre et zapper sur la chaine demandée (ne pas oublier les reboot dans la procédure !)

<strong><font color=red>**EDIT 21/01/2021 ** Pour ceux qui ont un soucis pour allumé la box apres son arret (veille profondre) l'option est desactivable dans les menus de la pop afin que pouvoir lancer des cast ou l allumer avec la commande "Ok GOOGLE, allume la freebox" (ou autre si vous avez changer son nom a l install)</strong></font>

! <strong>**EDIT 21/04/2021 ** En cas de soucis de perte de connexion entre google et votre freebox, penser à vérifier votre adresse ip pour la requette IFTTT, il se peut que celle-ci soit différente suite à un reboot du freebox serveur (possible de demander une ip fixe via "Espace Abonné > Ma freebox > Demander une adresse IP fixe V4 full-stack" ET/OU d'utiliser un reverse dns, option disponoble aussi via "Espace Abonné > Ma Freebox > Personnaliser mon reverse DNS > Entrée DNS personnalisée" )</strong>


------------------------------------------------------------------------------------------------------------------------------------------------------------


Si jamais un don vous tente ;) : <a href="http://paypal.me/adriengrillet"><img src="https://www.pngarts.com/files/4/Paypal-Donate-PNG-Transparent-Image.png" width="100"></a>


Pour ceux qui souhaitent créer leur propre serveur (à la place de la VM)
--------
il vous faudra :
<br/>Apache2
<br/>ADB
<br/>une copie de mon GIT : https://github.com/grillead/freeboxandroidhomecontrol/archive/main.zip
  
edité le fichier config.php :

<br/>$setDevice="ip_player"; //si serveur non local redirigé un port au choix vers le port 5555 du player
<br/>$setPort="port ADB vers le player"; //defaut : 5555


Créer ensuite une commande IFTTT Google Assistant type phrase with text incredient redirigant vers la page web de votre serveur http://@ipserveur/freebox.php?nom={{TextFiel}}


Merci a Aymkdn pour m'avoir donné l idée en voyant son assistant cloud (https://assistant.kodono.info/freebox/) de travailler sur le meme genre en compatible androidtv et merci pour son partage de la base sql afin de faire la relation nom<>numeros.



