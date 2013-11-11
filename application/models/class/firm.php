<?php 
class Firm {

	public static function findById($id) {
		$sql = " 
			SELECT * FROM " . CNP_FIRM . "
			WHERE id = " . Mapper::safeSql($id) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findAllActive($order ="", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$sql = " 
			SELECT * FROM " . CNP_FIRM . "
			WHERE 
				is_archive 		= '" . NO . "' AND
				account_status 	= '" . ACTIVE . "'

			{$order}
			{$sort}
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findByEmailAddress($email_address) {
		$sql = " 
			SELECT * FROM " . CNP_FIRM . "
			WHERE email_address = " . Mapper::safeSql($email_address) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findDuplicateEmail($firm_id,$email_address) {
		$sql = " 
			SELECT * FROM " . CNP_FIRM . "
			WHERE
				id != " . Mapper::safeSql($firm_id) . " AND
				email_address = " . Mapper::safeSql($email_address) . "
		";
		return Mapper::runSql($sql,true,true);
	}


	public static function findOtherActiveFirm($firm_id, $order = "", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");

		$sql = " 
			SELECT * FROM " . CNP_FIRM . "
			WHERE 
				id 	!= " . Mapper::safeSql($firm_id) . " AND
				is_archive 	= " . Mapper::safeSql(NO) . "
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findByUrlHash($url_hash) {
		$sql = " 
			SELECT * FROM " . CNP_FIRM . "
			WHERE url_hash = " . Mapper::safeSql($url_hash) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function isFirmActive($firm_id) {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$sql = " 
			SELECT * FROM " . CNP_FIRM . "
			WHERE 
				id 		= '" . Mapper::safeSql($firm_id) . "'  AND
				is_archive 		= " . Mapper::safeSql(NO) . " AND
				account_status 	= " . Mapper::safeSql(ACTIVE) . "
			LIMIT 1
		";

		$record = Mapper::runSql($sql,true,false);
		return ($record ? true : false);
	}

	public static function save($record,$id) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		if($id) {
			$sqlstart 	= " UPDATE " . CNP_FIRM . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . CNP_FIRM . " SET ";
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
			DELETE FROM " . CNP_FIRM . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

}

?>