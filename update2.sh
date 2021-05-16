#!/bin/bash
#Auto update script
{
chmod +x freeboxandroidhomecontrol-main/update.sh
mv -f freeboxandroidhomecontrol-main/freebox.php /var/www/html/
mv -f freeboxandroidhomecontrol-main/rewrite.php /var/www/html/
rm -f update.sh
if grep -Fxq 'AddDefaultCharset UTF-8' /etc/apache2/conf-enabled/charset.conf
then 
echo $
else
echo 'AddDefaultCharset UTF-8' >> /etc/apache2/conf-enabled/charset.conf
fi
service apache2 restart
rm -f freeboxandroidhomecontrol.zip
mv -f freeboxandroidhomecontrol-main/update.sh /home/freebox/
rm -Rf freeboxandroidhomecontrol-main
exit
}
