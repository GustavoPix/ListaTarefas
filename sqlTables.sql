use  my_db;

create table users(
	id INT primary key auto_increment not null,
    name VARCHAR(255) not null,
    email VARCHAR(255) not null,
    pass VARCHAR(255) not null,
    data_criacao TIMESTAMP default now()
);

create  table tasks(
	id INT primary key auto_increment not null,
    id_user INT NOT  NULL,
    task VARCHAR(255),
    data_criacao TIMESTAMP default now(),
    data_conclusao TIMESTAMP default "2000-01-01"
);

create table sessions(
	id INT primary key auto_increment not null,
    id_user INT NOT  NULL,
    data_criacao TIMESTAMP default now(),
    token VARCHAR(255) NOT NULL
);