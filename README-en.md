# VUTTR

![https://travis-ci.com/caiodomingues/vuttr-backend.svg?branch=master](https://travis-ci.com/caiodomingues/vuttr-backend.svg?branch=master)

Very Useful Tools to Remember - VUTTR is a testing application. In it, the user must be able to manage everyday tools containing information such as: name, description, link (url) and tags. The API is built using the PHP framework [Laravel 8](https://laravel.com), MySQL, Laravel Passport for authentication control with OAuth2 and JWT. Route tests were performed via [Insomnia](https://insomnia.rest/), and the file for importing the documentation is available in the [docs](docs) folder.

The API is structured around the Repository Pattern, takes into account Laravel's best practices (which are based on PSRs) of naming (both for migrations, as for Models and functions). The database was mounted via _migrations_, but it is still necessary to run the database creation command.

To facilitate development, the application was created with the help of the [tho-ca/rest](https://github.com/tho-ca/rest) package. The package streamlines the development of Laravel applications using the Repository Pattern.

## Setting

To configure the environment, it will be necessary to have PHP, Composer and MySQL installed on the computer. After cloning the repository, install the necessary packages with Composer:

```bash
composer install
```

When creating the database, use the command below, you can choose another name if you prefer:

```sql
CREATE DATABASE vuttr;
```

The configuration of the project must be done by copying the file `.env.example` to one with the name `.env` and configure it:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Just generate the application key, run the migrations, apply the Passport installation:

```bash
php artisan key:generate
php artisan migrate
php artisan passport:install
```

To run the application, just use the command:

```bash
php artisan serves --port=3000
```

> The `port` parameter is optional, it was included in the example above because the test requires the API to run on port 3000. The default value is 8000.

## Consuming the API

[Documentation at API Blueprint](https://caiodomingues.docs.apiary.io/#)

There is a sample application running on Heroku, you can check it out [here](https://vuttr-domingues.herokuapp.com/). Routes have the prefix `/api`, i.e <https://vuttr-domingues.herokuapp.com/api/route>.

In addition to the tool control routes, there are also the routes for creating new tags. Every system follows the REST standard, the response can also follow the paging metadata, just use the `per_page` and `page` parameters in the url.

### Auth

For account creation and system access:

```bash
POST /tools INDEX
POST /tools/{id} SHOW
POST /tools STORE
PUT /tools/{id} UPDATE
DELETE /tools/{id} DESTROY
```

It is possible to search tools by tag in the index route, using the `tag` parameter. The body for creating/editing a tool is defined by the following object:

```json
{
    "title": "Laravel",
    "link": "https://laravel.com",
    "description": "The PHP Framework for Web Artisans",
    "tags": ["PHP", "Laravel", "Framework"]
}
```

Fields expect a `string` as a value, the `tags` property expects an array of `strings`.

### Tools

For the tools:

```bash
GET /tools INDEX
GET /tools/{id} SHOW
POST /tools STORE
PUT /tools/{id} UPDATE
DELETE /tools/{id} DESTROY
```

It is possible to search tools by tag in the index route, using the `tag` parameter.

### Tags

For the tags:

```bash
GET / INDEX tags
GET /tags/{id} SHOW
POST / STORE tags
PUT /tags/{id} UPDATE
DELETE /tags/{id} DESTROY
```

It is possible to search for tags by name in the index route, using the `name` parameter. Tags cannot have the same name. The body for creating/editing a tag is defined by the following object:

```json
{
    "name": "PHP"
}
```

The field expects a `string` as a value.
