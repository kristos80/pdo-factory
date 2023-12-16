<?php
declare(strict_types=1);

namespace Kristos80\PdoFactory;

use PDO;
use Exception;

final class PdoFactory {

	/**
	 *
	 */
	private const ADAPTER_MYSQL = "MYSQL";

	/**
	 *
	 */
	private const ADAPTER_POSTGRES = "POSTGRES";

	/**
	 *
	 */
	private const DEFAULT_HOSTNAME = "localhost";

	/**
	 *
	 */
	private const DEFAULT_ADAPTER = self::ADAPTER_MYSQL;

	/**
	 *
	 */
	private const SUPPORTED_ADAPTERS = [
		self::ADAPTER_MYSQL,
		self::ADAPTER_POSTGRES,
	];

	/**
	 * @return PDO
	 * @throws Exception
	 */
	public static function createFromEnv(): PDO {
		$pdoSettings = self::getSettingsFromEnv();
		$pdo = NULL;
		switch($pdoSettings->getAdapter()) {
			case self::ADAPTER_MYSQL:
				$pdo = self::createMySqlPdo($pdoSettings);
			break;
			case self::ADAPTER_POSTGRES:
				$pdo = self::createPostgresPdo($pdoSettings);
			break;
		}

		$supportedAdapters = implode(", ", self::SUPPORTED_ADAPTERS);
		!$pdo && throw new PdoAdapterNotFoundException("PDO adapter not found. Supported adapters are [$supportedAdapters]");

		return $pdo;
	}

	/**
	 * @return PdoSettings
	 */
	public static function getSettingsFromEnv(): PdoSettings {
		$adapter = strtoupper($_ENV["PDO_FACTORY_ADAPTER"] ?? self::DEFAULT_ADAPTER);

		// Generic settings
		$hostname = $_ENV["{$adapter}_HOSTNAME"] ?? NULL;
		$port = $_ENV["{$adapter}_PORT"] ?? NULL;
		$username = $_ENV["{$adapter}_USERNAME"] ?? NULL;
		$password = $_ENV["{$adapter}_PASSWORD"] ?? NULL;
		$database = $_ENV["{$adapter}_DATABASE"] ?? NULL;
		$charset = $_ENV["{$adapter}_CHARSET"] ?? NULL;

		// Mysql specific
		$mysqlUnixSocket = $_ENV["MYSQL_UNIX_SOCKET"] ?? NULL;

		// Postgres specific
		$postgresSslMode = $_ENV["POSTGRES_SSL_MODE"] ?? NULL;

		return new PdoSettings(adapter: $adapter,
			hostname: $hostname,
			port: $port,
			username: $username,
			password: $password,
			database: $database,
			charset: $charset,
			mysqlUnixSocket: $mysqlUnixSocket,
			postgresSslMode: $postgresSslMode);
	}

	/**
	 * @param PdoSettings $pdoSettings
	 * @return PDO
	 */
	public static function createMySqlPdo(PdoSettings $pdoSettings): PDO {
		$dsn = "mysql:unix_socket={$pdoSettings->getMysqlUnixSocket()};";
		if(!$pdoSettings->getMysqlUnixSocket()) {
			$hostname = $pdoSettings->getHostname() ?: self::DEFAULT_HOSTNAME;
			$port = $pdoSettings->getPort() ?: "3306";
			$dsn = "mysql:host=$hostname;port=$port;";
		}

		$pdoSettings->getDatabase() && $dsn .= "dbname={$pdoSettings->getDatabase()};";
		$pdoSettings->getCharset() && $dsn .= "charset={$pdoSettings->getCharset()}";

		return new PDO($dsn, $pdoSettings->getUsername(), $pdoSettings->getPassword());
	}

	/**
	 * @param PdoSettings $pdoSettings
	 * @return PDO
	 */
	public static function createPostgresPdo(PdoSettings $pdoSettings): PDO {
		$hostname = $pdoSettings->getHostname() ?: self::DEFAULT_HOSTNAME;
		$port = $pdoSettings->getPort() ?: "5432";
		$dsn = "postgres:host=$hostname;port=$port;";

		$pdoSettings->getDatabase() && $dsn .= "dbname={$pdoSettings->getDatabase()};";
		$pdoSettings->getPostgresSslMode() && $dsn .= "sslmode={$pdoSettings->getPostgresSslMode()};";

		return new PDO($dsn, $pdoSettings->getUsername(), $pdoSettings->getPassword());
	}
}