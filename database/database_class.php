<?php

class MyDatabase {
	public static $db_path = './database/example.db';

	public static function get_one($person_id) {
		try {
			$pdo = new PDO("sqlite:" . self::$db_path);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stm = $pdo->prepare("SELECT * FROM example WHERE id = :id ");
			$stm->bindValue(":id", $person_id, PDO::PARAM_STR);
			$stm->execute();
			$res = [];
			while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
				$res[] = $row; 
			}
			$ok = count($res) > 0 ? true : false;
			return [
				"successful" => $ok,
				"queryResult" => $res,
				"message" => $ok ? NULL : "No match found",
				"status" => $ok ? 200 : 404
			];
		} catch(PDOException $e) {
			return [
				"successful" => false,
				"queryResult" => NULL,
				"message" => "Connection failed: " . $e->getMessage(),
				"status" => 500
			];
	       	}
	}

	public static function get_all() { 
		try {
			$pdo = new PDO("sqlite:" . self::$db_path);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$successful = $pdo->query('SELECT * FROM example');
			$pdo = NULL;
			$res = [];
			while($row = $successful->fetch(PDO::FETCH_ASSOC)) {
				$res[] = $row;
		       	}
			$ok = count($res) > 0 ? true : false;
			return [
				"successful" => true,
				"queryResult" => $res,
				"message" => $ok ? NULL : "Empty database",
				"status" => 200
			];
		} catch(PDOException $e) {
			return [
				"successful" => false,
				"queryResult" => NULL,
				"message" => "Connection failed: " . $e->getMessage(),
				"status" => 500
			]; 
		}

  	}

	public static function add_one($new_person) {
		$person_name = $new_person["name"];
		$person_age = $new_person["age"];
		$person_id = uniqid();
		try {
			$pdo = new PDO("sqlite:" . self::$db_path);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stm = $pdo->prepare("INSERT INTO example VALUES (:id, :name, :age)");
			$stm->bindValue(":id", $person_id, PDO::PARAM_STR);
			$stm->bindValue(":name", $person_name, PDO::PARAM_STR);
			$stm->bindValue(":age", $person_age, PDO::PARAM_INT);
			$successful = $stm->execute();
			$pdo = NULL;
			return [
				"successful" => $successful,
				"queryResult" => NULL,
				"message" => "Data added successfully",
				"status" => 201
			];
		} catch(PDOException $e) {
			return [
				"successful" => false,
				"queryResult" => NULL,
				"message" => "Connection failed: " . $e->getMessage(),
				"status" => 500
			]; 
		}
  	}

	public static function remove_one($target_id) {
		try {

			$pdo = new PDO("sqlite:" . self::$db_path);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stm = $pdo->prepare("DELETE FROM example WHERE id = :id");
			$stm->bindValue(":id", $target_id, PDO::PARAM_STR);
			$stm->execute();
			$pdo = NULL;
			return [
				"successful" => true,
				"queryResult" => NULL,
				"message" => "Data removed successfully",
				"status" => 200
			];
		} catch(PDOException $e) {
			return [
				"successful" => false,
				"queryResult" => NULL,
				"message" => "Connection failed: " . $e->getMessage(),
				"status" => 500
			]; 
		}
  	}

	public static function update_one($newp) {
		try {
			$pdo = new PDO("sqlite:" . self::$db_path);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //setting attributes to throw exeptions
			$stm = $pdo->prepare("UPDATE example SET name = :new_name, age = :new_age WHERE id = :id");
			$stm->bindValue(":new_name", $newp["name"], PDO::PARAM_STR);
			$stm->bindValue(":new_age", $newp["age"], PDO::PARAM_INT);
			$stm->bindValue(":id", $newp["id"], PDO::PARAM_STR);
			$pdo = NULL;
			$stm->execute();
			return [
				"successful" => true, 
				"queryResult" => NULL,
				"message" => "Data updated successfully",
				"status" => 201
			];
		} catch(PDOException $e) { 
			return [ 
			"successful" => false,
			"queryResult" => NULL,
			"message" => "Connection failed: " . $e->getMessage(),
			"status" => 500
			]; 
		}
	}

}



