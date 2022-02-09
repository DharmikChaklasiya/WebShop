CREATE TABLE user
(
    username varchar(32) PRIMARY KEY,
    pwd varchar(32),
    vorname varchar(32),
    nachname varchar(32),
	email varchar(64),
    is_admin boolean default FALSE,
    is_ldap boolean default FALSE
);