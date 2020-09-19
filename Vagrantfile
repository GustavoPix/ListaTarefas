$script_mysql = <<-SCRIPT
  apt-get update && \
  apt-get install -y mysql-server-5.7 && \
  mysql -e "create user 'phpuser'@'%' identified by 'pass';" && \
  mysql -e "create database if not exists my_db;" && \
  mysql -e "GRANT ALL PRIVILEGES ON my_db.* TO 'phpuser'@'%';"
SCRIPT

Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/bionic64"

  config.vm.provider "virtualbox" do |vb|
    vb.memory = 512
    vb.cpus = 2
  end

  config.vm.define "server_listaTarefas" do |server_listaTarefas|
    server_listaTarefas.vm.network "public_network", ip: "192.168.0.199"
    
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

    server_listaTarefas.vm.provision "shell", inline: $script_mysql 
    server_listaTarefas.vm.provision "shell", inline: "cat /vagrant/mysqld.cnf > /etc/mysql/mysql.conf.d/mysqld.cnf"
    server_listaTarefas.vm.provision "shell", inline: "service mysql restart" 

  end

end