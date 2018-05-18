create database taki DEFAULT CHARACTER SET UTF8 DEFAULT COLLATE utf8_general_ci;
use taki;

create table admin(
	id_user INT NOT NULL AUTO_INCREMENT,	
	name VARCHAR(50) NOT NULL,
	username VARCHAR(50) NOT NULL UNIQUE,
	password VARCHAR(100) NOT NULL,	
	primary key(id_user)	
);	


insert into admin(name, username, password) values ('Luis Paulo', 'lp', md5('123456'));