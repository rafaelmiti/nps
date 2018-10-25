## Subir o ambiente

- `docker-compose up -d`

## Instalar dependências e executar os testes unitários

- `docker exec -it nps_app sh`
- `php composer.phar install`
- `./phpunit`

## Endpoint

- `POST http://localhost:8080/clients/{cpf}/survey`: considerando que o cliente foi impactado por uma pesquisa, o inclui pelo cpf em "quarentena", ou seja, na regra da noventena

## Conferir o banco de dados

- `docker exec -it nps_mysql bash`
- `mysql -u root -p` (senha: `root`)
- `use nps;`
- `select * from quarantine;`
