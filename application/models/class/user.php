<?php 
class User {

	public static function findById($id) {
		$sql = " 
			SELECT * FROM " . CNP_USER . "
			WHERE id = " . Mapper::safeSql($id) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findAll() {
		$sql = " 
			SELECT * FROM " . CNP_USER . "
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findByEmailAddress($email_address, $fields) {
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . CNP_USER . "
			WHERE email_address = " . Mapper::safeSql($email_address) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findDuplicateEmail($user_id,$email_address) {
		$sql = " 
			SELECT * FROM " . CNP_USER . "
			WHERE
				id != " . Mapper::safeSql($user_id) . " AND
				email_address = " . Mapper::safeSql($email_address) . "
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findByUsername($username) {
		$sql = " 
			SELECT * FROM " . CNP_USER . "
			WHERE username = " . Mapper::safeSql($username) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findActiveUserByUsername($username="") {
		$sql = " 
			SELECT * FROM " . CNP_USER . "
			WHERE 
				username = " . Mapper::safeSql($username) . " AND
				account_status = 'Active'
				LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findActiveUserByUsernameOrEmail($username="") {
		$sql = " 
			SELECT * FROM " . CNP_USER . "
			WHERE
				(
					username = " . Mapper::safeSql($username) . " OR
					email_address = " . Mapper::safeSql($username) . "
				) AND
				account_status = 'Active'
				LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findAllActiveUser($fields, $order ="", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . CNP_USER . "
			WHERE 
				account_status = 'Active'
			{$order}
			{$sort}
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAllActiveUserByFirmId($firm_id, $fields, $order ="", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");

		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . CNP_USER . "
			WHERE
				firm_id = " . Mapper::safeSql($firm_id) . " AND
				account_status = 'Active'
			{$order}
			{$sort}
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAllActiveOrdinaryUsersByFirmId($firm_id, $fields, $order ="", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");

		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . CNP_USER . "
			WHERE
				firm_id = " . Mapper::safeSql($firm_id) . " AND
				account_status = 'Active' AND
				account_type != " . Mapper::safeSql(SUPER_ADMIN) . "
			{$order}
			{$sort}
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function save($record,$id) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		if($id) {
			$sqlstart 	= " UPDATE " . CNP_USER . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . CNP_USER . " SET ";
			$sqlend		= "";
		}

		$sqlbody 	= implode($arr," , ");
		$sql 		= $sqlstart.$sqlbody.$sqlend;

		Mapper::runSql($sql,false);
		if($id) {
			return $id;
		} else {
			return mysql_insert_id();
		}
	}

	public static function delete($id) {
		$sql = "
			DELETE FROM " . CNP_USER . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

}

?>