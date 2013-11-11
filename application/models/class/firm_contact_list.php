<?php 
class Firm_Contact_List {

	public static function findById($id) {
		$sql = " 
			SELECT * FROM " . CNP_FIRM_CONTACT_LIST . "
			WHERE id = " . Mapper::safeSql($id) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findAll() {
		$sql = " 
			SELECT * FROM " . CNP_FIRM_CONTACT_LIST . "
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAllByFirmId($user_id, $order ="", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$sql = " 
			SELECT * FROM " . CNP_FIRM_CONTACT_LIST . "
			WHERE 
				firm_id = " . Mapper::safeSql($user_id) . " AND
				is_archive = " . Mapper::safeSql(NO) . "
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
			$sqlstart 	= " UPDATE " . CNP_FIRM_CONTACT_LIST . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	= " INSERT INTO " . CNP_FIRM_CONTACT_LIST . " SET ";
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
			DELETE FROM " . CNP_FIRM_CONTACT_LIST . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

}

?>