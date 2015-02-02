#!/bin/sh





echo "Instructions for Lubuntu (Ubuntu 14.04 LTS), Using a Windows or Linux Host -> Lubuntu Guest -> Vagrant sub guest"
#Install Virtualbox in your host system
#Setup two ethernet cards, one set for Bridged, The other set for Bridged with Permiscious Mode on

sudo apt-get -y install virtualbox-guest-x11
sudo apt-get -y install openjdk-7-jre openjdk-7-jdk vagrant openssh-server git mysql-workbench linux-headers-`uname -r` dkms build-essential virtualbox-dkms virtualbox 
sudo apt-get -y install chromium-browser hexchat filezilla



cd ~/Downloads
wget http://download.netbeans.org/netbeans/8.0.2/final/bundles/netbeans-8.0.2-linux.sh
sudo sh ./netbeans-8.0.2-linux.sh

cd ~/Downloads
wget https://dl.bintray.com/mitchellh/vagrant/vagrant_1.7.2_i686.deb
sudo dpkg -i ~/Downloads vagrant_1.7.2_i686.deb