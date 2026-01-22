<?php
	function getConnection() {
		$host = 'nuwebspace_db';
		$dbname = 'w21046657';
		$user = 'w21046657';
		$password = 'zQz1R8tI0HZ#';
		try {
			$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
			$pdo = new PDO($dsn, $user, $password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		} catch (PDOException $e) {
			error_log("Connection error: " . $e->getMessage());
			return null;
		}
	}
?>
		


