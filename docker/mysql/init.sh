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

# Проверка, пуста ли таблица horoscope
if mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "SELECT 1 FROM $MYSQL_DATABASE.horoscope LIMIT 1" 2>/dev/null; then
  echo "Таблица horoscope не пуста. Данные не будут перенесены."
else
  echo "Таблица horoscope пуста. Перенос данных из taro.sql..."
   # Экспорт данных из таблицы taro.horoscope в файл SQL
  mysqldump -u root -p"$MYSQL_ROOT_PASSWORD" taro horoscope > /tmp/horoscope_data.sql

  # Импорт данных в таблицу horoscope в базе данных $MYSQL_DATABASE
  mysql -u root -p"$MYSQL_ROOT_PASSWORD" $MYSQL_DATABASE < /tmp/horoscope_data.sql

  echo "Данные успешно перенесены."
fi