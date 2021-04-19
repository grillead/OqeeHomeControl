#!/bin/bash
#Auto update script
{
wget -O freeboxandroidhomecontrol.zip https://github.com/grillead/freeboxandroidhomecontrol/archive/main.zip
unzip -o freeboxandroidhomecontrol.zip
chmod +x freeboxandroidhomecontrol-main/update2.sh
sudo ./freeboxandroidhomecontrol-main/update2.sh
exit
}

