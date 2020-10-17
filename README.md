# Freebox Android Home Control

Plugin pour contrôler les freebox "android" (Mini4K et POP) avec Google Home (Changement de chaine via leur Nom)
Les fonctions volume/extiction sont gérer en natif via google si vous avez ajouter la box à votre compte home.
Nécessite : 
  L'activation du mode développeurs et du Débogage USB sur la box
  La mise en place d'une VM sur le serveur delta pour faire tourné les outils adb,php,mysql( je pourrais fournir l'image pre-configurer apres une période de test)
  La création d'un applet sur ifttt pour lancer les chaines avec leurs noms.
  
-----Partie Freebox Delta Serveur -----

Mettre en place l image de la VM et la demarrer (liens vers la vm à venir ultérieurement)
Assigner un bail dhcp à la VM.
Dans l interface freebox : Paramètre de la Freebox \ Gestion des ports => Ouvrir le port externe "1122 vers le port interne "1122" de la vm

-----Partie Player-----

Activation mod dev : 
Appuie 7 fois sur la touche "ok" sur le numeros de build dans la section "A propos"
Débogage USB:
A activé dans le menu "Options pour les développeurs"
Apparaige serveur : 
Un popup va s'afficher sur la box au moment de l envoie de la 1ere commande vocale,
il faut cocher la case se souvenir et autoriser la connexion une 1ere fois.

-----Creation applet IFTTT -----

Créer un applet "If This" Google Assistant > Phrase with TEXT incredient  (exemple chez moi : zappe sur la chaine $)
                "Then That" WebHooks vers l url : http://ip_de_la_box:1122/freebox.php?nom={{TextField}}
                
                
Pour ceux qui souhaitent créer leur propre serveur : 
Nécessaire : 
  Apache2
  PHP5.6
  Mariadb
  ADB
  
Dans le 
config BDD + player : 
edité le fichier config.php

$setDevice="ip_publique_box";
$setPort="port ADB vers le player";
$conn = mysql_connect("Adresse_Bdd:Port_Bdd", "user_Bdd", "pwd_Bdd") or die;
$db = mysql_select_db("nom_Bdd");

Le port externe pour etre definie au choix, mais il devra imperativement rediriger vers le port 5555 du player

Créer ensuite une commande IFTTT Google Assistant type phrase with text incredient redirigant vers la page web de votre serveur


Merci a Aymkdn pour m'avoir donné l idée en voyant son assistant cloud (https://assistant.kodono.info/freebox/) de travailler sur le meme genre en compatible androidtv et merci pour son partage de la base sql afin de faire la relation nom<>numeros.



