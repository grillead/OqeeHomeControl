rm -Rf freeboxandroidhomecontrol-main.zip
wget -O freeboxandroidhomecontrol.zip https://github.com/grillead/freeboxandroidhomecontrol/archive/main.zip
unzip freeboxandroidhomecontrol.zip
mv -f freeboxandroidhomecontrol-main/freebox.php /var/www/html/
mysqladmin -ufreebox -pfreebox drop chaine -f
mysqladmin -ufreebox -pfreebox create chaine
mysql chaine -ufreebox -pfreebox < freeboxandroidhomecontrol-main/chaines.sql -f
rm -f freeboxandroidhomecontrol.zip
exit && mv -f freeboxandroidhomecontrol-main/update.sh /home/freebox/ 

