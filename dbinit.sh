#!/bin/bash

# The host running the http application (from which the user is going to connect)
DJIF_HOST="localhost"
# The host running SGBD
DB_HOST="localhost"
# Mysql default is 3306
DB_PORT="3306"
DB_NAME="djif"
# You must choose a user and password to access your DB
DB_USER=""
DB_PASS=""

CONFIG="config/config.php"

function fail() {
	echo "${@}"
	exit 1
}

if [ -z "${DJIF_HOST}" ]
then
	fail "Variable DJIF_HOST is not defined."
fi
if [ -z "${DB_HOST}" ]
then
	fail "Variable DB_HOST is not defined."
fi
if [ -z "${DB_PORT}" ]
then
	fail "Variable DB_PORT is not defined."
fi
if [ -z "${DB_NAME}" ]
then
	fail "Variable DB_NAME is not defined."
fi
if [ -z "${DB_USER}" ]
then
	fail "Variable DB_USER is not defined."
fi
if [ -z "${DB_PASS}" ]
then
	fail "Variable DB_PASS is not defined."
fi

sed -i \
	-e "s|'DB_HOST','\(.*\)');$|'DB_HOST','${DB_HOST}');|" \
	-e "s|'DB_PORT','\(.*\)');$|'DB_PORT','${DB_PORT}');|" \
	-e "s|'DB_NAME','\(.*\)');$|'DB_NAME','${DB_NAME}');|" \
	-e "s|'DB_USER','\(.*\)');$|'DB_USER','${DB_USER}');|" \
	-e "s|'DB_PASS','\(.*\)');$|'DB_PASS','${DB_PASS}');|" \
"${CONFIG}"


echo "Mysql root password is required to create the database and user required to run Djif"
mysql -u root -h ${DB_HOST} -P ${DB_PORT} -p <<EOF
DROP DATABASE IF EXISTS \`${DB_NAME}\`;
CREATE DATABASE \`${DB_NAME}\`;
USE \`${DB_NAME}\`;
CREATE TABLE \`urls\` (
  \`gif\` text NOT NULL,
  \`audio\` text NOT NULL,
  \`ip\` int(11) DEFAULT NULL,
  \`hash\` char(5) CHARACTER SET ascii NOT NULL,
  \`date\` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  \`visits\` int(11) DEFAULT '0',
  PRIMARY KEY (\`hash\`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

GRANT INSERT, SELECT, UPDATE ON \`urls\`.* TO \`${DB_USER}\`@\`${DJIF_HOST}\` IDENTIFIED BY '${DB_PASS}';

LOCK TABLES \`urls\` WRITE;
INSERT INTO \`urls\` VALUES ('http://media.tumblr.com/5fdc0c14b8a571f4e5923a6f9c32de82/tumblr_mky1tiLMhz1rjdfzto1_400.gif','https://www.youtube.com/watch?v=WaIJKM0sjdo',2130706433,'first','2013-04-29 12:19:47',0);
UNLOCK TABLES;

EOF
