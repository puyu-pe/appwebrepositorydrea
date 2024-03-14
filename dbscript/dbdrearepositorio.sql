create database dbdrearepositorio;

use dbdrearepositorio;

create table tuser
(
idUser char(13) not null,
email varchar(100) not null,
password varchar(700) not null,
numberDni char(8) not null,
firstName varchar(60) not null,
surName varchar(60) not null,
avatarExtension varchar(7) not null,
state varchar(20) not null,
created_at datetime not null,
updated_at datetime not null,
primary key(idUser)
) engine=innodb;

create table trole
(
idRole char(13) not null,
nameRole varchar(50) not null,
descriptionRole varchar(200) not null,
created_at datetime not null,
updated_at datetime not null,
primary key(idRole)
) engine=innodb;

insert into trole values ('5ece4797eaf5e', 'Administrador', 'Acceso total al sistema', now(), now());
insert into trole values ('651508865dd1e', 'Supervisor', 'Posibilidad de manipular las evaluaciones, aprobar la publicación de las mismas', now(), now());
insert into trole values ('6515073a329ac', 'Registrador', 'Acceso para poder registrar evaluaciones y/o respuestas y solo se puede publicar previa aprobación', now(), now());
insert into trole values ('6515074f590dc', 'Normal', 'Acceso básico para un usuario que desee crearse un usuario en el sistema', now(), now());


create table tuserrole
(
idUserRole char(13) not null,
idUser char(13) not null,
idRole char(13) not null,
created_at datetime not null,
updated_at datetime not null,
foreign key(idUser) references tuser(idUser) on delete cascade on update cascade,
foreign key(idRole) references trole(idRole) on delete cascade on update cascade,
primary key(idUserRole)
) engine=innodb;

-- tabla para resetear contraseñas
create table tresetpassword(
idResetPassword char(13) not null,
idUser char(13) not null,
token text not null,
isRecuperate tinyint not null,
created_at datetime not null,
updated_at datetime not null,
foreign key(idUser) references tuser(idUser) on delete cascade on update cascade,
primary key(idResetPassword)
)engine=innodb;

create table ttypeexam
(
idTypeExam char(13) not null,
nameTypeExam varchar(100) not null,
acronymTypeExam varchar(10) not null,
descriptionTypeExam varchar(200) not null,
numberExecuteYear int not null DEFAULT 1,
extensionImageType varchar(7) not null,
created_at datetime not null,
updated_at datetime not null,
primary key(idTypeExam)
) engine=innodb;

-- ALTER TABLE ttypeexam ADD COLUMN numberExecuteYear INT DEFAULT 1 AFTER descriptionTypeExam;

create table tgrade
(
idGrade char(13) not null,
nameGrade varchar(50) not null,
numberGrade int not null,
created_at datetime not null,
updated_at datetime not null,
primary key(idGrade)
) engine=innodb;

create table tsubject
(
idSubject char(13) not null,
nameSubject varchar(50) not null,
created_at datetime not null,
updated_at datetime not null,
primary key(idSubject)
) engine=innodb;

create table tdirection
(
idDirection char(13) not null,
namecompleteDirection varchar(400) not null,
namesortDirection varchar(100) not null,
nameRegion varchar(200) not null,
logoExtension varchar(7) not null,
created_at datetime not null,
updated_at datetime not null,
primary key(idDirection)
) engine=innodb;

create table texam
(
idExam char(13) not null,
idTypeExam char(13) not null,
idGrade char(13) not null,
idSubject char(13) not null,
idDirection char(13) null,
codeExam varchar(30) not null,
nameExam text not null,
descriptionExam text not null,
totalPageExam int not null,
yearExam int not null,
numberEvaluation int not null DEFAULT 1,
stateExam varchar(20) not null,
keywordExam text not null,
extensionExam varchar(7) not null,
statusAnwser tinyint not null,
created_at datetime not null,
updated_at datetime not null,
foreign key(idTypeExam) references ttypeexam(idTypeExam) on delete cascade on update cascade,
foreign key(idGrade) references tgrade(idGrade) on delete cascade on update cascade,
foreign key(idSubject) references tsubject(idSubject) on delete cascade on update cascade,
foreign key(idDirection) references tdirection(idDirection),
primary key(idExam)
) engine=innodb;

-- alter table texam add column idDirection char(13) null after idSubject;
## ALTER TABLE texam
## ADD CONSTRAINT fk_idDirection
## FOREIGN KEY (idDirection) REFERENCES tdirection(idDirection);
## ALTER TABLE texam add column numberEvaluation INT NOT NULL DEFAULT 1 AFTER yearExam;

-- falta evaluar
-- create table tkeywordexam
-- (
-- idKeywordExam char(13) not null,
-- idExam char(13) not null,
-- descriptionKeyword varchar(100) not null,
-- created_at datetime not null,
-- updated_at datetime not null,
-- foreign key(idExam) references texam(idExam) on delete cascade on update cascade,
-- primary key(idKeywordExam)
-- ) engine=innodb;

create table tuserexam
(
idUserExam char(13) not null,
idUser char(13) not null,
idExam char(13) not null,
typeFunctionExam varchar(50) not null,
dataExam text not null,
dateUserExam date not null,
created_at datetime not null,
updated_at datetime not null,
foreign key(idUser) references tuser(idUser) on delete cascade on update cascade,
foreign key(idExam) references texam(idExam) on delete cascade on update cascade,
primary key(idUserExam)
) engine=innodb;

create table tanswer
(
idAnswer char(13) not null,
idExam char(13) not null,
numberAnswer int not null,
descriptionAnswer text not null,
created_at datetime not null,
updated_at datetime not null,
foreign key(idExam) references texam(idExam) on delete cascade on update cascade,
primary key(idAnswer)
) engine=innodb;

create table tsetting
(
idSetting char(13) not null,
key_setting varchar(30) not null,
type_data varchar(200),
description_setting varchar(100) not null,
value_setting text,
created_at datetime not null,
updated_at datetime not null,
primary key(idSetting)
) engine=innodb;

create table tdocument
(
idDocument char(13) not null,
key_document varchar(30) not null,
number_document int not null,
state tinyint not null,
created_at datetime not null,
updated_at datetime not null,
primary key(idDocument)
) engine=innodb;

create table tcontact
(
idContact char(13) not null,
completeNameContact varchar (300) not null,
emailContact varchar(100) not null,
affairContact varchar(200) not null,
messageContact text not null,
dateContact date not null,
statusContact tinyint not null,
created_at datetime not null,
updated_at datetime not null,
primary key(idContact)
) engine=innodb;

insert into tdocument values('5ece4797eaf5e', 'exam', 0, 1, now(), now());




