# Используем официальный образ MySQL
FROM mysql:latest

COPY ./taro.sql /docker-entrypoint-initdb.d/taro.sql
COPY ./init.sh /docker-entrypoint-initdb.d/init.sh

# Установка прав на выполнение скрипта
RUN chmod +x /docker-entrypoint-initdb.d/init.sh

# Устанавливаем параметры для улучшения производительности
RUN echo "[mysqld]\ninnodb_flush_log_at_trx_commit=2\nsync_binlog=0\ninnodb_buffer_pool_size=1G" >> /etc/mysql/my.cnf

# Команда по умолчанию для запуска MySQL сервера
CMD ["mysqld"]