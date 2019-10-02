create table libri
(
	id int auto_increment,
	title text null,
	author text null,
	price float null,
	constraint libri_pk
		primary key (id)
);

