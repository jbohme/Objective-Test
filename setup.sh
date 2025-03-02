#!/bin/bash

set -e

echo "Montando container..."
docker-compose build
docker-compose up -d

echo "Instalando dependências via Composer..."
docker exec -ti php83_objective composer install --no-interaction --prefer-dist

echo "Criando banco de dados SQLite e importando schema..."
docker exec -ti php83_objective sh -c 'touch /application/database/database.sqlite'
docker exec -ti php83_objective sh -c 'cat /application/database/schema.sql | sqlite3 /application/database/database.sqlite'

echo "Rodando testes..."
docker exec -ti php83_objective ./vendor/bin/phpunit

echo "Ambiente preparado com sucesso!"
