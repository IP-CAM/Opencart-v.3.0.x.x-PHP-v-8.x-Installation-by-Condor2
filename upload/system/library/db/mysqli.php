<?php
namespace DB;
class MySQLi {
	private $connection;

	public function __construct($hostname, $username, $password, $database, $port = '') {
		if (!$port) {
			$port = '3306';
		}

		try {
			$mysqli = @new \mysqli($hostname, $username, $password, $database, $port);

			$this->connection = $mysqli;
			$this->connection->set_charset('utf8');
			$this->connection->query("SET SESSION sql_mode = 'NO_ZERO_IN_DATE,NO_ENGINE_SUBSTITUTION'");
			$this->connection->query("SET FOREIGN_KEY_CHECKS = 0");
		} catch (\mysqli_sql_exception $e) {
			throw new \Exception('Error: Could not make a database link using ' . $username . '@' . $hostname . '!');
		}
	}

	public function query($sql) {
		try {
			$query = $this->connection->query($sql);

			if ($query instanceof \mysqli_result) {
				$data = array();

				while ($row = $query->fetch_assoc()) {
					$data[] = $row;
				}

				$result = new \stdClass();
				$result->num_rows = $query->num_rows;
				$result->row = $data[0] ?? array();
				$result->rows = $data;

				$query->close();

				unset($data);

				return $result;
			} else {
				return true;
			}
		} catch (\mysqli_sql_exception $e) {
			throw new \Exception('Error: ' . $this->connection->error . '<br />Error No: ' . $this->connection->errno . '<br />' . $sql);
		}
	}

	public function escape($value) {
		return $this->connection->real_escape_string($value);
	}

	public function countAffected() {
		return $this->connection->affected_rows;
	}

	public function getLastId() {
		return $this->connection->insert_id;
	}

	public function isConnected() {
		if ($this->connection) {
			return $this->connection->ping();
		} else {
			return false;
		}
	}

	/**
	 * __destruct
	 *
	 * Closes the DB connection when this object is destroyed.
	 */
	public function __destruct() {
		if ($this->connection) {
			$this->connection->close();

			$this->connection = null;
		}
	}
}
