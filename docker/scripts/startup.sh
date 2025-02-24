#!/bin/bash

# Aguardar MySQL estar pronto
echo "Aguardando MySQL..."
while ! nc -z mysql 3306; do
    sleep 1
done
echo "MySQL está pronto!"

# Aguardar Redis estar pronto
echo "Aguardando Redis..."
while ! nc -z redis 6379; do
    sleep 1
done
echo "Redis está pronto!"

# Instalar dependências do Composer se necessário
if [ ! -d "/var/www/html/vendor" ]; then
    echo "Instalando dependências do Composer..."
    composer install --no-interaction --no-progress
fi

# Criar arquivo .env se não existir
if [ ! -f "/var/www/html/.env" ]; then
    echo "Criando arquivo .env..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Executar migrações do banco de dados
echo "Executando migrações do banco de dados..."
php /var/www/html/artisan migrate --force

# Ajustar permissões
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html

# Iniciar Apache em primeiro plano
echo "Iniciando Apache..."
apache2-foreground 