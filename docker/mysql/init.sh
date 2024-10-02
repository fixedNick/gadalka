#!/bin/bash

# Проверка наличия базы данных
if mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "USE $MYSQL_DATABASE" 2>/dev/null; then
  echo "База данных $MYSQL_DATABASE уже существует."
else
  echo "База данных $MYSQL_DATABASE не существует. Создание и импорт данных..."
  mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "CREATE DATABASE $MYSQL_DATABASE;"
  mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "ALTER USER 'root'@'%' IDENTIFIED WITH mysql_native_password BY '$MYSQL_ROOT_PASSWORD';"
  mysql -u root -p"$MYSQL_ROOT_PASSWORD" $MYSQL_DATABASE < /docker-entrypoint-initdb.d/taro.sql
  echo "База данных $MYSQL_DATABASE создана и данные импортированы."
fi