drop database if exists Ahorcado;
create database Ahorcado;

use Ahorcado;

create table Usuario(
	id int auto_increment,
	nombre varchar(20),
	password varchar(20),
	partidaFK int,
	constraint usuarioPK primary key (id)
);

create table Partida(
	id int auto_increment,
        palabraSecreta varchar(20),
        palabraDescubierta varchar(20),
        erroresMax int,
        errores int,
        fin int(1),
	constraint PartidaPK primary key (id)
);

create table Jugada(
	id int auto_increment,
	letra varchar(1),
	partidaFK int,
	constraint JugadaPK primary key (id)
);


create table Palabra(
	url varchar(100),
	palabraFK int
);

alter table Usuario
	add constraint UsuarioPartidaFK foreign key (partidaFK) references Partida (id);
	
alter table Jugada
	add constraint JugadaPartidaFK foreign key (partidaFK) references Partida (id);

alter table Palabra
	add constraint JugadaPalabraFK foreign key (palabraFK) references Partida (id);

	