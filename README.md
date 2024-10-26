# 10News

Uma API Rest da aplicação de notícias [10News](https://github.com/rodrigofontesdev/investidor10), o projeto foi elaborado como solução para o teste técnico da **Investidor10**.

Neste repositório está localizado o back-end do projeto, como requisito do desafio foi utilizado o framework **Laravel**.

## Pré-requisitos

- Git
- Docker

## Como iniciar

Clone o repositório em um novo diretório:

```sh
git clone git@github.com:rodrigofontesdev/investidor10-api.git
```

Inicie o Docker container:

```sh
docker compose up -d
```

```sh
docker container ls
```

Abra um terminal `shell` do serviço `php-fpm`:

```sh
docker exec -it investidor10-api-php-fpm-1 sh
```

```sh
composer install
```

_Nota: `investidor10-api` é o nome da pasta do projeto._

Crie o arquivo `.env`:

```sh
cp .env.example .env
```

Execute as migrations do banco de dados:

```sh
touch database/database.sqlite
```

```sh
php artisan migrate --seed
```

Para finalizar verifique se a aplicação subiu com sucesso, visite: [http://localhost/up](http://localhost/up).

## Funcionalidades

- [x] Retornar as notícias por categoria
- [x] Retornar todas as notícias
- [x] Retornar o contéudo da notícia
- [x] Paginação de resultados
- [x] Ordenação de resultados
- [x] Versionamento da API

## Testes

Para executar os testes, digite o comando abaixo no terminal do serviço `php-fpm`:

```sh
php artisan test
```

## Considerações

Para construção da API Rest, segui uma arquitetura para versionamento da API, imaginando um cenário onde o projeto continuasse crescendo.

Os endpoints foram desenvolvidos sob a metodologia TDD, essa abordagem permite a detecção precoce de bugs, a criação de código mais robusto e a manutenção da integridade da API mesmo diante de modificações.

Pensando no aperfeiçoamento do projeto, pode ser interessante integrar uma ferramenta de Logging e a criação de uma classe para ser responsável por criar novas instâncias de erros da API.

## Construído com

- Laravel 11.x
- Docker

## Licença

Este projeto está licenciado sob a licença MIT - consulte o arquivo [LICENSE.md](LICENSE) para obter detalhes.
