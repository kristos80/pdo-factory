# 📘 pdo-factory

Factory utility that creates a `PDO` object from environment configuration.

---
### Please do not use in production yet as: ###
* It's not tested extensively
* More adapters needs to be added
---

The following environmental variables can be used:

* `PDO_FACTORY_ADAPTER` specifies which adapter will be used and how the rest of the environmental variables are going to be collected. Default 'mysql'
* `${PDO_FACTORY_ADAPTER}_HOSTNAME` default 'localhost'
* `${PDO_FACTORY_ADAPTER}_PORT` default `NULL`, fallbacks to the default port of each adapter
* `${PDO_FACTORY_ADAPTER}_USERNAME` default `NULL`
* `${PDO_FACTORY_ADAPTER}_PASSWORD` default `NULL`
* `${PDO_FACTORY_ADAPTER}_DATABASE` default `NULL`
* `${PDO_FACTORY_ADAPTER}_CHARSET` default `NULL`

`MySQL` specific 
* `MYSQL_UNIX_SOCKET`

`Postgres` specific
* `POSTGRES_SSL_MODE`

## Example usage
```env
PDO_FACTORY_ADAPTER=mysql
MYSQL_HOSTNAME=127.0.0.1
MYSQL_PORT=23306
MYSQL_USERNAME=root
MYSQL_PASSWORD=mysql
MYSQL_DATABASE=slim
```
```PHP
<?php
declare(strict_types=1);

use Dotenv\Dotenv;
use Kristos80\PdoFactory\PdoFactory;

require_once __DIR__ . "/../../vendor/autoload.php";

$dotEnv = Dotenv::createImmutable(__DIR__);
$dotEnv->load();

$mysqlPdo = PdoFactory::createFromEnv();
```
