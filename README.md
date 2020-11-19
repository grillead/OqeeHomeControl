# Freebox Android Home Control

Plugin pour contrôler les freebox "android" (Mini4K et POP) avec Google Home (Changement de chaine via leur Nom)
Les fonctions volume/extiction sont gérer en natif via google si vous avez ajouter la box à votre compte home.
Nécessite : 

  L'activation du mode développeurs et du Débogage USB sur la box
  
  La mise en place d'une VM sur le serveur delta pour faire tourné les outils adb,php,mysql( je pourrais fournir l'image pre-configurer apres une période de test)
  <br/>Edit 21/10 : Liens vers la VM : http://bit.ly/freeboxhomecontrol (identifiant: freebox / pwd: freebox )
  <br/>Merci de jouer le jeu et me faire un retour : https://github.com/grillead/freeboxandroidhomecontrol/issues/1
  
  La création d'un applet sur ifttt pour lancer les chaines avec leurs noms.
   
-----Partie Freebox Delta Serveur -----
<br/>Assigner un bail dhcp au player pop (param par defaut dans la vm : 192.168.0.1 si autre ip modifier le fichier /var/www/html/config.php) + reboot player
<br/>Mettre en place l image de la VM et la demarrer (http://bit.ly/freeboxhomecontrol)
<br/>Assigner un bail dhcp à la VM + reboot vm

Dans l interface freebox : Paramètre de la Freebox \ Gestion des ports => Ouvrir le port externe "1122 vers le port interne "1122" de la vm

-----Partie Player-----

Activation mod dev : 
<br/>Appuie 7 fois sur la touche "ok" sur le numeros de build dans la section "A propos"

Débogage USB:
<br/>A activé dans le menu "Options pour les développeurs"

Apparaige serveur : 
<br/>Un popup va s'afficher sur la box au moment de l envoie de la 1ere commande vocale,
<br/>il faut cocher la case se souvenir et autoriser la connexion une 1ere fois.

-----Création applet IFTTT -----

Créer un applet 

                "If This" Google Assistant > Phrase with TEXT incredient  (exemple chez moi : zappe sur la chaine $)

                "Then That" WebHooks vers l url : http://ip_de_la_box:1122/freebox.php?nom={{TextField}}
                
A la fin de ces manips, votre "ami google" doit etre en mesure de comprendre et zapper sur la chaine demandée (ne pas oublier les reboot dans la procédure !)
------------------------------------------------------------------------------------------------------------------------------------------------------------


Pour me remercier, buy me a beer ;) : <a href="http://paypal.me/adriengrillet"><img src="https://www.pngarts.com/files/4/Paypal-Donate-PNG-Transparent-Image.png" width="100"></a> ou 1 Ricard ^^


Pour ceux qui souhaitent créer leur propre serveur (à la place de la VM)
--------
il vous faudra :
<br/>Apache2
<br/>PHP5.6
<br/>Mariadb
<br/>ADB
<br/>une copie de mon GIT : https://github.com/grillead/freeboxandroidhomecontrol/archive/main.zip
  
edité le fichier config.php :

<br/>$setDevice="ip_player"; //si serveur non local redirigé un port au choix vers le port 5555 du player
<br/>$setPort="port ADB vers le player"; //defaut : 5555
<br/>$conn = mysql_connect("Adresse_Bdd:Port_Bdd", "user_Bdd", "pwd_Bdd") or die;
<br/>$db = mysql_select_db("nom_Bdd");

Créer ensuite une commande IFTTT Google Assistant type phrase with text incredient redirigant vers la page web de votre serveur http://@ipserveur/freebox.php?nom={{TextFiel}}


Merci a Aymkdn pour m'avoir donné l idée en voyant son assistant cloud (https://assistant.kodono.info/freebox/) de travailler sur le meme genre en compatible androidtv et merci pour son partage de la base sql afin de faire la relation nom<>numeros.



