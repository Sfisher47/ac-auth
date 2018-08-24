#!/bin/sh
function setup_db()
{
	mysql -r -p$1 --execute="ALTER USER 'root'@'localhost' IDENTIFIED BY '$1'" &>/dev/null
	mysql -r -p$1 --execute="UPDATE mysql.user SET host='%' WHERE user='root';
	GRANT ALL PRIVILEGES ON *.* TO 'root'@'%';
	FLUSH PRIVILEGES;" &>/dev/null
	mysql -r -p$1 --execute="CREATE DATABASE $2" &>/dev/null
	mysql -r -p$1 $2 --execute="SOURCE create_tokens_table.sql" &>/dev/null
	return $?
}

function setup_db_loop()
{
 	while ! setup_db $1 $2; do  sleep 1; done
	echo "$2 database successfully created !"
}

setup_db_loop $1 $2 &
sh /entrypoint.sh mysqld