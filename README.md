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

## Cache

- O cache é invalidado para cada CPF em 90 dias, de forma que não haja consulta ao banco antes do tempo da regra da noventena
- Flush total do cache para efeito de teste:
  - `docker exec -it nps_memcached bash`
  - `echo flush_all > /dev/tcp/127.0.0.1/11211`
