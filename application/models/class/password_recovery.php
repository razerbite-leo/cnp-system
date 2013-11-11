<?php 
class Password_Recovery {

	public static function findById($id) {
		$sql = " 
			SELECT * FROM " . CNP_PASSWORD_RECOVERY . "
			WHERE id = " . Mapper::safeSql($id) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findCurrentTransactByUserId($user_id) {
		$sql = " 
			SELECT * FROM " . CNP_PASSWORD_RECOVERY . "
			WHERE 
				user_id = " . Mapper::safeSql($user_id) . " AND
				is_active = " . Mapper::safeSql(YES) . "
				ORDER BY id DESC 
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findByUserIdKey($user_id, $url_key) {
		$sql = " 
			SELECT * FROM " . CNP_PASSWORD_RECOVERY . "
			WHERE 
				user_id = " . Mapper::safeSql($user_id) . " AND
				url_key = " . Mapper::safeSql($url_key) . " AND
				is_active = " . Mapper::safeSql(YES) . "
				ORDER BY id DESC 
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findAll() {
		$sql = " 
			SELECT * FROM " . CNP_PASSWORD_RECOVERY . "
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function save($record,$id) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		if($id) {
			$sqlstart 	= " UPDATE " . CNP_PASSWORD_RECOVERY . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . CNP_PASSWORD_RECOVERY . " SET ";
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
			DELETE FROM " . CNP_PASSWORD_RECOVERY . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

}

?>