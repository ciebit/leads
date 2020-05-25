# Leads

Modulo de conteúdo e captura de leads


## Testes

```
docker-compose run tests --testsuite entities
```

Se quiser executar o teste dos Storages usar o comando:

```
docker-compose run tests --testsuite storages
```

Devido o tempo de inicialização do container do banco de dados o teste irá falhar, portanto é adequado executar antes o comando:

```
docker-compose up -d db
```