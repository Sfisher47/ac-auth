CREATE TABLE tokens (
	id INT UNSIGNED AUTO_INCREMENT NOT NULL,
	token VARCHAR(40) NOT NULL,
	userid INT UNSIGNED,
	expirationdate DATETIME NOT NULL,
	creationdate DATETIME NOT NULL,
	postmethod enum('all', 'own', 'none') NOT NULL DEFAULT 'none',
	patchmethod enum('all', 'own', 'none') NOT NULL DEFAULT 'none',
	getmethod enum('all', 'own', 'none') NOT NULL DEFAULT 'own',
	delmethod enum('all', 'own', 'none') NOT NULL DEFAULT 'none',
	requests INT UNSIGNED,
	PRIMARY KEY (id),
	UNIQUE KEY ix_token (token),
	UNIQUE KEY ix_userid (userid)
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARSET=utf8;
