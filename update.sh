#!/bin/bash
{
rm -Rf freeboxandroidhomecontrol-main
wget -O freeboxandroidhomecontrol.zip https://github.com/grillead/freeboxandroidhomecontrol/archive/main.zip
unzip -o freeboxandroidhomecontrol.zip
mv -f freeboxandroidhomecontrol-main/freebox.php /var/www/html/
rm -f update.sh
mysqladmin -ufreebox -pfreebox drop chaine -f
mysqladmin -ufreebox -pfreebox create chaine
mysql chaine -ufreebox -pfreebox < freeboxandroidhomecontrol-main/chaines.sql -f
rm -f freeboxandroidhomecontrol.zip
mv -f freeboxandroidhomecontrol-main/update.sh /home/freebox/
chmod +x update.sh
exit
}
