# FreeboxAndroidHomeControl

Plugin pour contrôler les freebox "android" (Mini4K et POP) avec Google Home

Necessite l'activation du mode développeurs sur la box (appuie 7 fois sur la touche ok sur le numeros de build dans la section "A propos")
et du Débogage USB (à activé dans le menu "Options pour les développeurs")

Une fois l activation du debug fait il faut procéder à l appairage ,un popup va s afficher sur la box au moment de l envoie de la 1ere commande vocale,
il faut cocher la case se souvenir et autoriser la connexion une 1ere fois.

Dans l interface freebox : Paramètre de la Freebox \ Gestion des ports => Ouvrir un port externe (ex "1122) vers le port interne "5555" du freebox player 
Dans le fichier freebox.php : definir l'ip publique de la box + le port ouvert vers le player, exemple : 
          $setDevice = $adb->setDevice(['host' => 'ip_publique', 'port' => 1122]);

Créer ensuite une commande IFTTT Google Assistant type phrase with numbers redirigant vers la page web heberger de la box ex: http://ipduserveurweb/freebox.php?cmd=#

Le control vocal via le nom est en cours d'étude.

Merci ikkysleepy pour son fichier php adb : https://github.com/ikkysleepy/adb

et 

Merci a Aymkdn pour m'avoir donné l idée en voyant son assistant cloud de travaillé sur le meme genre en compatible androidtv https://assistant.kodono.info/freebox/



