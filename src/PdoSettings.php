<?php
declare(strict_types=1);

namespace Kristos80\PdoFactory;

final class PdoSettings {

	/**
	 * @param string $adapter
	 * @param string|null $hostname
	 * @param string|int|null $port
	 * @param string|null $username
	 * @param string|null $password
	 * @param string|null $database
	 * @param string|null $charset
	 * @param string|null $mysqlUnixSocket
	 * @param string|null $postgresSslMode
	 */
	public function __construct(private string $adapter,
		private ?string $hostname = NULL,
		private null|string|int $port = NULL,
		private ?string $username = NULL,
		private ?string $password = NULL,
		private ?string $database = NULL,
		private ?string $charset = NULL,
		private ?string $mysqlUnixSocket = NULL,
		private ?string $postgresSslMode = NULL) {}

	/**
	 * @return string|null
	 */
	public function getMysqlUnixSocket(): ?string {
		return $this->mysqlUnixSocket;
	}

	/**
	 * @return string|null
	 */
	public function getPostgresSslMode(): ?string {
		return $this->postgresSslMode;
	}

	/**
	 * @return string|null
	 */
	public function getCharset(): ?string {
		return $this->charset;
	}

	/**
	 * @return string
	 */
	public function getAdapter(): string {
		return $this->adapter;
	}

	/**
	 * @return string|null
	 */
	public function getHostname(): ?string {
		return $this->hostname;
	}

	/**
	 * @return int|string|null
	 */
	public function getPort(): int|string|null {
		return $this->port;
	}

	/**
	 * @return string|null
	 */
	public function getUsername(): ?string {
		return $this->username;
	}

	/**
	 * @return string|null
	 */
	public function getPassword(): ?string {
		return $this->password;
	}

	/**
	 * @return string|null
	 */
	public function getDatabase(): ?string {
		return $this->database;
	}
}