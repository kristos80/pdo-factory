# 🏭 pdo-factory

Factory utility that creates a `PDO` object from environment configuration.

---

## Work in Progress (WIP) — Do not use in production yet: ##

- It has not undergone extensive testing.
- Primarily intended for internal projects, subject to potential breaking changes without prior notice.
- There are likely many missing features.

---

The following environmental variables can be used:

* `PDO_FACTORY_ADAPTER` specifies which adapter will be used and how the rest of the environmental variables are going
  to be collected. Default 'mysql'
* `${PDO_FACTORY_ADAPTER}_HOSTNAME` default 'localhost'
* `${PDO_FACTORY_ADAPTER}_PORT` default `NULL`, fallbacks to the default port of each adapter
* `${PDO_FACTORY_ADAPTER}_USERNAME` default `NULL`
* `${PDO_FACTORY_ADAPTER}_PASSWORD` default `NULL`
* `${PDO_FACTORY_ADAPTER}_DATABASE` default `NULL`
* `${PDO_FACTORY_ADAPTER}_CHARSET` default `NULL`

`MySQL` specific

* `MYSQL_UNIX_SOCKET` default `NULL`. If it exists `MYSQL_HOSTNAME` and `MYSQL_PORT` are ommited

`Postgres` specific

* `POSTGRES_SSL_MODE` default `NULL`. [See more](https://www.php.net/manual/en/ref.pdo-pgsql.connection.php)

## Example usage

**.env**

```env
PDO_FACTORY_ADAPTER=mysql
MYSQL_HOSTNAME=127.0.0.1
MYSQL_PORT=23306
MYSQL_USERNAME=root
MYSQL_PASSWORD=mysql
MYSQL_DATABASE=slim
```

**db.php**

```PHP
<?php
declare(strict_types=1);

use Dotenv\Dotenv;
use Kristos80\PdoFactory\PdoFactory;

require_once __DIR__ . "/../../vendor/autoload.php";

# Load .env somehow
# `Dotenv\Dotenv` is not part of this library
$dotEnv = Dotenv::createImmutable(__DIR__);
$dotEnv->load();

$mysqlPdo = PdoFactory::createFromEnv();
```
