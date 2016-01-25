
-- SELECT * FROM mysql.user;
-- DROP USER 'html4php'@'localhost';
CREATE DATABASE html4php;
CREATE USER 'html4php'@'localhost' IDENTIFIED BY 'html4php';
GRANT ALL PRIVILEGES ON * . * TO 'html4php'@'localhost';
FLUSH PRIVILEGES;

-- DROP TABLE html4php.user;

-- grant select, insert, delete on db_name.* to 'db_user'@'localhost' identified by 'db_password'


-- Max length of email = 254, http://www.rfc-editor.org/errata_search.php?rfc=3696&eid=1690
CREATE TABLE html4php.user (
	userid int(11) NOT NULL AUTO_INCREMENT,
	username varchar(128) NOT NULL UNIQUE,
	email varchar(255) NOT NULL UNIQUE,
	passhash varchar(255) NOT NULL,
        token varchar(255) NOT NULL,
	PRIMARY KEY (userid)
);

REPLACE INTO html4php.user 
	(userid, username, email, passhash) 
	VALUES 
		(1,'admin', 'admin@html4php.dev','444');
 
select * from html4php.user;
