# VUTTR

![https://travis-ci.com/caiodomingues/vuttr-backend.svg?branch=master](https://travis-ci.com/caiodomingues/vuttr-backend.svg?branch=master)

[English version](README-en.md)

O Very Useful Tools to Remember - VUTTR, é uma aplicação de testes. Nela o usuário deverá ser capaz de gerenciar ferramentas do dia a dia contendo informações como: nome, descrição, link (url) e tags. A API é construída utilizando o framework PHP [Laravel 8](https://laravel.com), MySQL, Laravel Passport para controle de autenticação com OAuth2 e JWT. Os testes das rotas foram realizados via [Insomnia](https://insomnia.rest/), e o arquivo para importação da documentação está disponível na pasta [docs](docs).

A API está estruturada com base no Repository Pattern, leva em consideração as boas práticas do Laravel (que são baseadas em PSRs) de nomenclatura (tanto para migrations, quanto para Models e funções). O banco de dados foi montado via _migrations_, porém ainda é necessário rodar o comando de criação de database.

Para facilitar o desenvolvimento, a aplicação foi criada com ajuda do pacote [tho-ca/rest](https://github.com/tho-ca/rest). O pacote agiliza o desenvolvimento de aplicações Laravel utilizando o Repository Pattern.

## Configurando

Para configurarmos o ambiente, será necessário ter PHP, Composer e MySQL instalados no computador. Após clonar o repositório, instale os pacotes necessários com o Composer:

```bash
composer install
```

Na criação do banco de dados, utilize o comando abaixo, você pode escolher outro nome se preferir:

```sql
CREATE DATABASE vuttr;
```

A configuração do projeto deve ser feita copiando o arquivo `.env.example` para um com nome `.env` e configure-o:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Basta gerar a chave da aplicação, rodar as migrações, aplicar a instalação do Passport:

```bash
php artisan key:generate
php artisan migrate
php artisan passport:install
```

Para rodar a aplicação, basta utilizar o comando:

```bash
php artisan serve --port=3000
```

> O parâmetro `port` é opcional, foi incluído no exemplo acima pois o teste requisita que a API rode na porta 3000. O valor padrão é 8000.

## Exemplo

Há uma aplicação exemplo rodando no Heroku, você pode conferir por [aqui](.).

Além das rotas para controle de ferramentas, há também as rotas para criação de novas tags. Todo sistema segue o padrão REST, a resposta também pode acompanhar os metadados para paginação, basta utilizar os parâmetros `per_page` e `page` na url.

### Auth

Para a criação de conta e acesso ao sistema:

```bash
POST    /tools          INDEX
POST    /tools/{id}     SHOW
POST    /tools          STORE
PUT     /tools/{id}     UPDATE
DELETE  /tools/{id}     DESTROY
```

É possível buscar ferramentas por tag na rota index, utilizando o parâmetro `tag`. O corpo para a criação/edição de uma ferramenta é definido pelo seguinte objeto:

```json
{
    "title": "Laravel",
    "link": "https://laravel.com",
    "description": "The PHP Framework for Web Artisans",
    "tags": ["PHP", "Laravel", "Framework"]
}
```

Os campos esperam uma `string` como valor, a propriedade `tags` espera um array de `strings`.

### Tools

Para as ferramentas:

```bash
GET     /tools          INDEX
GET     /tools/{id}     SHOW
POST    /tools          STORE
PUT     /tools/{id}     UPDATE
DELETE  /tools/{id}     DESTROY
```

É possível buscar ferramentas por tag na rota index, utilizando o parâmetro `tag`.

### Tags

Para as tags:

```bash
GET     /tags          INDEX
GET     /tags/{id}     SHOW
POST    /tags          STORE
PUT     /tags/{id}     UPDATE
DELETE  /tags/{id}     DESTROY
```

É possível buscar tags por nome na rota index, utilizando o parâmetro `name`. Tags não podem possuir o mesmo nome. O corpo para a criação/edição de uma tag é definido pelo seguinte objeto:

```json
{
    "name": "PHP"
}
```

O campo espera uma `string` como valor.
