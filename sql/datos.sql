use Ahorcado;

INSERT INTO Usuario (nombre, password, partidaFK) 
VALUES
("Maria", "mariamv", null),
("Gema", "gemiis", null),
("Paz", "1032", null),
("Alvar", "alvar01", null),
("Dani", "enano", null);


insert into Partida (
	nombre
) values (
	"Goya"
);

insert into Partida (
	nombre
) values (
	"Velazquez"
);

insert into Partida (
	nombre
) values (
	"Van Gogh"
);


insert into Jugada (
	titulo,
	img,
	partidaFK
) values (
	"Saturno devorando a su hijo",
	"img/goya1.jpg",
	"1"
);  

insert into Jugada (
	titulo,
	img,
	partidaFK
) values (
	"Fusilamientos del 3 de mayo",
	"img/goya2.jpg",
	"1"
);  

insert into Jugada (
	titulo,
	img,
	partidaFK
) values (
	"Las Meninas",
	"img/velazquez1.png",
	"2"
);

insert into Jugada (
	titulo,
	img,
	partidaFK
) values (
	"Las Hilanderas",
	"img/velazquez2.jpg",
	"2"
);

insert into Jugada (
	titulo,
	img,
	partidaFK
) values (
	"Noche estrellada sobre el Ródano",
	"img/vangogh1.jpg",
	"3"
);

insert into Jugada (
	titulo,
	img,
	partidaFK
) values (
	"Noche estrellada",
	"img/vangogh2.png",
	"3"
);




insert into Jugada (
	titulo,
	img,
	partidaFK
) values (
	"Carlos IV y su familia",
	"img/goya3.jpg",
	"1"
);  

insert into Jugada (
	titulo,
	img,
	partidaFK
) values (
	"Venus del Espejo",
	"img/velazquez3.jpg",
	"2"
);

insert into Jugada (
	titulo,
	img,
	partidaFK
) values (
	"Campo de trigo con cipreses",
	"img/vangogh3.png",
	"3"
);











insert into Partida (
	nombre
) values (
	"Dali"
);



insert into Jugada (
	titulo,
	img,
	partidaFK
) values (
	"La persistencia de la memoria",
	"img/dali1.jpg",
	"4"
);  

insert into Jugada (
	titulo,
	img,
	partidaFK
) values (
	"La tentación de San Antonio",
	"img/dali2.jpg",
	"4"
);  

insert into Jugada (
	titulo,
	img,
	partidaFK
) values (
	"Construcción blanda con judías hervidas",
	"img/dali3.jpg",
	"4"
);  



