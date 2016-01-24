HTML4PHP
/*
 * @version 2015-01-04
 * @category PHP Framework
 * @copyright (c) microuser 1014, macro_user@outlook.com
 * @author microuser
 * @link https://github.com/microuser/HTML4PHP 
 * @license https://github.com/microuser/HTML4PHP/blob/master/LICENSE MIT
 */


========
A Lightweight PHP Framework, where as shown in this example:
 - the controller is the index.php file in the right directory
 - the view/non-template is denoted in index.php named Html4PhpSamplePage structured by using Html4PhpPage generator functions
 - the model


Pre Install Instructions On Ubuntu 14.04(Updated 2016)
=====================
```sh
sudo apt-get -y install virtualbox vagrant nfs-kernel-server nfs-common git
```
//Download the newest netbeans from Oracle's website
```sh
cd ~/Downloads
sudo chmod +x netbeans8.1-php-linux-x86.sh
sudo ./netbeans-8.1-php-linux-x64.sh
mkdir -p ~/NetBeansProjects
```sh
//SSH Keys for git
//https://help.github.com/articles/generating-an-ssh-key/
```sh
ssh-keygen -t rsa -b 4096 -C "macro_user@outlook.com" -f ~/.ssh/id_rsa_github
```
#Option 1)look at the last lines, it should give you your fingerprint

//Option 2)print the public portion of the key you just generated
//If you already have a key you like, you can just give github your public key
 ```sh
 cat id_rsa_github.pub
```
//Copy above to you github ssh-keys.
//https://help.github.com/articles/adding-a-new-ssh-key-to-your-github-account/
//Github.com -> Edit Profile -> SSh-Keys -> Add Key

Start SSH Agent with keys
```sh
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/id_rsa_github
```

Install Instructions for Ubuntu 14.04
=======================
cd ~/NetBeansProjects
git clone 


To test sample page
======================
Run the following linux commands
```sh
sudo apt-get install virtualbox nfs-kerbel-server nfs-common
cd ./install
#Link: https://www.vagrantup.com/downloads.html
wget https://dl.bintray.com/mitchellh/vagrant/vagrant_1.7.1_i686.deb
sudo dpkg -i vagrant_1.7.1_i686.deb

cd ~/NetBeansProjects/HTML4PHP
sudo vagrant plugin install vagrant-bindfs

sudo chmod -Rv 777 .



vagrant up


#make hostfile entry
sudo su 
echo "192.168.56.156 html4php.dev www.html4php.dev" >> /etc/hosts
exit

```

Fix Initial-setup.sh
=======================
In the guest...
```sh
vagrant ssh
rm -Rfv /var/www/default/
sudo ln -s /vagrant/ /var/www/default
sudo sed -iv "s#/var/www/default#/var/www/default/webroot#g" /etc/apache2/sites-enabled/10-default_vhost_80.conf
sudo sed -iv "s#/var/www/default#/var/www/default/webroot#g" /etc/apache2/sites-enabled/10-default_vhost_443.conf
sudo service apache2 restart
```

Make your database




Regenerate Phphet configuration
===============================
GOTO: https://puphpet.com/


Providor: Virtualbox
LocalVMOperatingSyStem: Ubuntu Trusty 14.04 LTS x32 PHP
LocalVMIPAddress: 192.168.56.156
LocalVMMemory: 512
LocalVMCpus: 1

LocalVM Forwareded Ports Host Port: 9325
LocalVM Forwareded Ports Guest Port: 22

Box Sync Folder Source: ./
Box Sync FOlder Target: /vagrant

System Installed Packages:

Users & Groups:

Install Apache2: [x]
Apache Modules: rewrite

Apache Virtual Host
ServerName: html4php.dev
Server Aliases: www.html4php.dev
DocumentRoot: /vagrant
Port: 80
EnvironmentVariables: APP_ENV dev

DirectoryOptions: Indexes FollowSymlinks Multiviews
AllowOverride: All
Require: all granted
Engine: php
Enable SSL: [];

Install Php: [X]
PHP Version: 5.6
Install Composer: [X]
INI Settings: display_errors=ON, error_reporting=-1, session.save_path=/var/lib/php/session
PHPTimezone: America/Chicago
PHP Modules: cli, intl, mcrypt
PEAR Moduels:
Pecl Modules: pecl_http

Use mod_php: []


PHP Libraries
Install XDebug: [X]
Settings: <untouched>

MySQL Quick Settings
Install MySQL: [X]
rootpassword: 123456
Install Adminer :[X]

DBName: dbname
DBHost: localhost
Username: dbuser
Password: password

Import Database from file: /vagrant/dbname.sql

Install MailCatcher: [X]
HTTP Port: 1080


Makde export. download. unzip

#fix error, puppet/nodes/apache.pp.42
$webroot_location_group = undef

Maybe we don't want puphpet
config.vm.synced_folder "#{folder['source']}", "#{folder['target']}", id: "#{folder['id']}", type: nfs, :linux__nfs_options => ["rw","no_root_squash","no_subtree_check"]

also maybe https://github.com/puphpet/puphpet/wiki/Shared-Folder:-Permission-Denied
The issue is complex and after having tried a million and one things, a few PuPHPet users have discovered that adding the following to your Vagrantfile:

, :linux__nfs_options => ["rw","no_root_squash","no_subtree_check"]
on the same line as:

config.vm.synced_folder "#{folder['source']}", "#{folder['target']}", id: "#{i}", type: 'nfs'



Other Project Dependencies
===================================
- MIT
-    - https://github.com/arshaw/fullcalendar
-    - Jquery
-    - Jqueryui
-    - tablesorter
-    - Jquery Form Validator - https://github.com/victorjonsson/jQuery-Form-Validator
- Want: http://malsup.com/jquery/form/#file-upload
- Want: https://github.com/malsup/form/


Enable X-Debug
=================
Not validated:::

- Option 1, Allow all computers to connect
```sh
sudo sed -i 's#;xdebug.remote_connect_back = 0#xdebug.remote_connect_back = 1#g' /.puphpet-stuff/xdebug/xdebug.ini
```
- Option 2, Allow just your comptuer to connect
Be sure to change 192.168.56.1 to represent your development IP.
```sh
sudo sed -i 's#;xdebug.remote_host = localhost#xdebug.remote_host = 192.168.56.1#g' /.puphpet-stuff/xdebug/xdebug.ini
```


Create Documentation using api-gen
====================================
On your host
```sh
sudo apt-et install php-apigen
```


Allow Public Network in Vagrant File
========================================
```Vagrantfile
  if data['vm']['network']['public_network'].to_s != ''
        config.vm.network 'public_network', ip: "#{data['vm']['network']['public_network']}"
  end

  if data['vm']['network']['public_bridge'].to_s != ''
         config.vm.network 'public_network', bridge: "#{data['vm']['network']['public_bridge']}"
  end
```
Add `public_network: dhcp` to your config.yaml
