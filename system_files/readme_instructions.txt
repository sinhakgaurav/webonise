>>>> configuring application
1.	download git repository from https://github.com/sinhakgaurav/webonise
	
	sudo mkdir /home/user/projects/
	cd /home/user/projects/
	git clone https://github.com/sinhakgaurav/webonise.git
	git checkout origin master
	sudo chmod -R 777 webonise/*
2.	configuring requirements
	#Copy virtual host file
	sudo cp /home/user/projects/webonise/system_files/webonise.loc.conf /etc/apache2/sites-available/

	#Enable the site as created above
	sudo a2ensite webonise.loc.conf

	#Enable mod rewrite
	sudo a2enmod rewrite

	#Restart apache2
	sudo service apache2 restart

	#login in database
	sudo mysql -u {username} -p
	#creating database
	create database webonise;
	
	#get out of mysql
	#importing tables
	mysql -u {username} -p webonise < /home/user/projects/webonise/system_files/webonise.sql
	
3.	changing config
	#go to folder
	cd /home/user/projects/webonise/
	sudo nano app/config/dbConfig.php # give your mysql credentials
	composer install
	




>>>>>>>>>>>>>>all good to go>>>>>>>>>>>>>>>>>>>>>>
	
