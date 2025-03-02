# Desafio Técnico - Objective #

### Candidato: José Castro

---


## Configuração Inicial

Para rodar o projeto, siga os passos abaixo:

### Pré-requisitos
- Docker e Docker Compose instalados.

### Passo a passo

1. Clone o repositório: ``git clone git@github.com:jbohme/Objective-Test.git``
2. Entre no diretório: ``cd Objective-Test``
3. Execute o script de preparação do ambiente: ``./setup.sh``

Caso seja necessário realizar na mão, o passo a passo do script é:
- Criação do build do container: `` docker-compose build ``
- Execução do container: `` docker-compose up -d ``
- Instalação das dependências via Composer: `` docker exec -ti php83_objective composer install --no-interaction --prefer-dist ``
- Criação do banco de dados SQLite: `` docker exec -ti php83_objective sh -c 'touch /application/database/database.sqlite' ``
- Execução do schema.sql: `` docker exec -ti php83_objective sh -c 'cat /application/database/schema.sql | sqlite3 /application/database/database.sqlite' ``
- Execução dos testes unitários: `` docker exec -ti php83_objective ./vendor/bin/phpunit ``

Pronto! O projeto estará funcionando em: [http://localhost:8080](http://localhost:8080)

---

## Postman Collection

Para facilitar os testes eu deixei pronto os arquivos necessários para execução no postman.
- [Collection](./docs/postman/postman_collection.json)
- [Environment](./docs/postman/postman_environment.json)


