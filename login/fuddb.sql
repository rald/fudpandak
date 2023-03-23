drop database if exists fuddb;

create database fuddb;

use fuddb;



create table user (
	id integer primary key auto_increment,
	email varchar(200),
	password varchar(20),
	role varchar(20)	
);


