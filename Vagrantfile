### configuration parameters ###
IP_APPLICATION = "192.168.0.199"

SQL_HOSTNAME = "127.0.0.1"
SQL_USERNAME = "phpuser"
SQL_PASSWORD = "" ### Informar uma string de 16 Caracteres
SQL_DBNAME = "my_db"

ENCRYPT_KEY = "" ### Informar uma string de 16 Caracteres
ENCRYPT_HASH = "" ### Informar uma string de 16 Caracteres

EMAIL_HOST = "" ### Informar um host de email
EMAIL_USER = "" ### Email para login
EMAIL_PASSWORD = "" ### Senha para login do email
EMAIL_PORT = "587" 
EMAIL_NAME = "" ### Nome de remetente

Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/bionic64"

  config.vm.provider "virtualbox" do |vb|
    vb.memory = 512
    vb.cpus = 2
  end

  config.vm.define "server_listaTarefas" do |server_listaTarefas|
    server_listaTarefas.vm.network "public_network", ip: IP_APPLICATION
    
    server_listaTarefas.vm.provider "virtualbox" do |v|
      v.name = "ubuntu_bionic_server_listaTarefas"
    end

    server_listaTarefas.vm.provision "shell", inline:  "apt-get update"
    server_listaTarefas.vm.synced_folder ".", "/vagrant", disabled: true
    server_listaTarefas.vm.synced_folder "./", "/var/www"
    server_listaTarefas.vm.synced_folder "./vagrant-configs", "/vagrant"
    server_listaTarefas.vm.provision "shell", inline: "apt-get upgrade -y"
    server_listaTarefas.vm.provision "shell", inline: "apt-get install php7.2 -y"
    server_listaTarefas.vm.provision "shell", inline: "apt-get install apache2 -y"
    server_listaTarefas.vm.provision "shell", inline: "apt-get install php7.2-curl php7.2-gd php7.2-json php7.2-mbstring php7.2-intl php7.2-mysql php7.2-xml php7.2-zip -y"
    server_listaTarefas.vm.provision "shell", inline: "cat /vagrant/php.ini > /etc/php/7.2/apache2/php.ini"
    server_listaTarefas.vm.provision "shell", inline: "cat /vagrant/apache2.conf > /etc/apache2/apache2.conf"
    
    server_listaTarefas.vm.provision "shell", inline: "systemctl start apache2" 
    server_listaTarefas.vm.provision "shell", inline: "a2enmod rewrite" 
    server_listaTarefas.vm.provision "shell", inline: "systemctl restart apache2" 
    
    server_listaTarefas.vm.provision "shell", inline: "mkdir /var/www/configs"
    server_listaTarefas.vm.provision "shell", inline: "cat /vagrant/configs.php > /var/www/configs/configs.php"
    server_listaTarefas.vm.provision "shell", inline: "service apache2 restart" 

    server_listaTarefas.vm.provision "shell", inline: "apt-get install -y mysql-server-5.7"
    server_listaTarefas.vm.provision "shell", inline: "cat /vagrant/mysqld.cnf > /etc/mysql/mysql.conf.d/mysqld.cnf"
    server_listaTarefas.vm.provision "shell", inline: "mysql -e " + '"' + "create user '" + SQL_USERNAME + "'@'%' identified by '" + SQL_PASSWORD + "';" + '"'
    server_listaTarefas.vm.provision "shell", inline: "mysql -e " + '"' + "create database if not exists " + SQL_DBNAME + ";" + '"'
    server_listaTarefas.vm.provision "shell", inline: "mysql -e " + '"' + "GRANT ALL PRIVILEGES ON " + SQL_DBNAME + ".* TO '" + SQL_USERNAME + "'@'%';" + '"'
    server_listaTarefas.vm.provision "shell", inline: "mysql -h localhost " + SQL_DBNAME + " < /vagrant/sqlTables.sql"
    server_listaTarefas.vm.provision "shell", inline: "service mysql restart" 

    server_listaTarefas.vm.provision "shell", inline: "sed -i 's/-SQL_HOSTNAME-/" + SQL_HOSTNAME + "/g' /var/www/configs/configs.php" 
    server_listaTarefas.vm.provision "shell", inline: "sed -i 's/-SQL_USERNAME-/" + SQL_USERNAME + "/g' /var/www/configs/configs.php" 
    server_listaTarefas.vm.provision "shell", inline: "sed -i 's/-SQL_PASSWORD-/" + SQL_PASSWORD + "/g' /var/www/configs/configs.php" 
    server_listaTarefas.vm.provision "shell", inline: "sed -i 's/-SQL_DBNAME-/" + SQL_DBNAME + "/g' /var/www/configs/configs.php" 
    server_listaTarefas.vm.provision "shell", inline: "sed -i 's/-ENCRYPT_KEY-/" + ENCRYPT_KEY + "/g' /var/www/configs/configs.php" 
    server_listaTarefas.vm.provision "shell", inline: "sed -i 's/-ENCRYPT_HASH-/" + ENCRYPT_HASH + "/g' /var/www/configs/configs.php" 
    server_listaTarefas.vm.provision "shell", inline: "sed -i 's/-EMAIL_HOST-/" + EMAIL_HOST + "/g' /var/www/configs/configs.php" 
    server_listaTarefas.vm.provision "shell", inline: "sed -i 's/-EMAIL_USER-/" + EMAIL_USER + "/g' /var/www/configs/configs.php" 
    server_listaTarefas.vm.provision "shell", inline: "sed -i 's/-EMAIL_PASSWORD-/" + EMAIL_PASSWORD + "/g' /var/www/configs/configs.php" 
    server_listaTarefas.vm.provision "shell", inline: "sed -i 's/-EMAIL_PORT-/" + EMAIL_PORT + "/g' /var/www/configs/configs.php" 
    server_listaTarefas.vm.provision "shell", inline: "sed -i 's/-EMAIL_NAME-/" + EMAIL_NAME + "/g' /var/www/configs/configs.php" 

  end

end