HTML4PHP



========
A Lightweight PHP Framework, where as shown in this example:
 - the controller is the index.php file in the right directory
 - the view/non-template is denoted in index.php named Html4PhpSamplePage structured by using Html4PhpPage generator functions
 - the model



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
rm -Rfv /var/www/default/
sudo ln -s /vagrant/ /var/www/default
sudo sed -iv "s#DocumentRoot \"/var/www/default\"#DocumentRoot /vagrant#g" /etc/apache2/sites-enabled/10-default_vhost_80.conf
sudo sed -iv "s#DocumentRoot \"/var/www/default\"#DocumentRoot /vagrant#g" /etc/apache2/sites-enabled/10-default_vhost_443.conf

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