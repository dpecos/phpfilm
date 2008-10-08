CREATE TABLE country (
	id		smallint AUTO_INCREMENT PRIMARY KEY,
	name 		varchar(70) UNIQUE NOT NULL 
);

CREATE TABLE genre (
	id		smallint AUTO_INCREMENT PRIMARY KEY,
	name		varchar(70) UNIQUE NOT NULL
);

CREATE TABLE director (
	id		smallint AUTO_INCREMENT PRIMARY KEY,
	name		varchar(70) NOT NULL,
	country 	smallint, -- refer. country
	year		year
);

CREATE TABLE actor (
	id		smallint AUTO_INCREMENT PRIMARY KEY,
        name            varchar(70) NOT NULL,
	country 	smallint, -- refer. country
        year		year
);

CREATE TABLE film (
	id		smallint AUTO_INCREMENT PRIMARY KEY,
	title		varchar(70) NOT NULL,
	vo		tinyint NOT NULL,
	vo_title	varchar(70),
	vo_lang		varchar(15),
	country 	smallint, -- refer. country
	year		year,
	length		mediumint,
	format		varchar(10) NOT NULL,
	web 		varchar(70),
	genre		smallint NOT NULL, -- refer. genre
	image		tinyint NOT NULL,
	creation_date	date NOT NULL
);

CREATE TABLE argument (
	id		smallint AUTO_INCREMENT PRIMARY KEY,
	film_id         smallint UNIQUE NOT NULL, -- refer. film
	argument	text
);

CREATE TABLE actor_film (
        id		smallint AUTO_INCREMENT PRIMARY KEY,
	film_id         smallint NOT NULL, -- refer. film
	actor_id        smallint NOT NULL -- refer. actor 
);

CREATE TABLE director_film (
        id		smallint AUTO_INCREMENT PRIMARY KEY,
	film_id         smallint NOT NULL, -- refer. film
	director_id     smallint NOT NULL -- refer. director
);

CREATE TABLE person (
	id		smallint AUTO_INCREMENT PRIMARY KEY,
	name		varchar(70) NOT NULL,
	phone	 	varchar(9),
	email		varchar(40)  
);

CREATE TABLE loan (
	id		smallint AUTO_INCREMENT PRIMARY KEY,
	film_id		smallint UNIQUE NOT NULL, -- refer. film
	person_id	smallint NOT NULL, -- refer. person
	loan_date	date NOT NULL
);
