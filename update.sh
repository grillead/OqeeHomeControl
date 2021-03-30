#!/bin/bash
#Auto update script
{
wget -O freeboxandroidhomecontrol.zip https://github.com/grillead/freeboxandroidhomecontrol/archive/main.zip
unzip -o freeboxandroidhomecontrol.zip
chmod +x freeboxandroidhomecontrol-main/update.sh
mv -f freeboxandroidhomecontrol-main/freebox.php /var/www/html/
rm -f update.sh
echo 'AddDefaultCharset UTF-8' >> /etc/apache2/conf-enabled/charset.conf
service apache2 restart
#mysqladmin -ufreebox -pfreebox drop chaine -f
#mysqladmin -ufreebox -pfreebox create chaine
#mysql chaine -ufreebox -pfreebox < freeboxandroidhomecontrol-main/chaines.sql -f
rm -f freeboxandroidhomecontrol.zip
mv -f freeboxandroidhomecontrol-main/update.sh /home/freebox/
rm -Rf freeboxandroidhomecontrol-main
exit
}
