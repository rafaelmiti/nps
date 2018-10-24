create database nps;
use nps;
create table quarantine(id bigint not null primary key auto_increment, cpf char(11) not null, date date not null);
