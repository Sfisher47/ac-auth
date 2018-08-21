FROM mysql/mysql-server:latest
WORKDIR /var/www/html
COPY create_tokens_table.sql .
COPY install.sh .
ARG MYSQL_ROOT_PASSWORD=test
ENV MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD}
ENV DBNAME=ac_authentication
ENTRYPOINT sh install.sh ${MYSQL_ROOT_PASSWORD} ${DBNAME}
