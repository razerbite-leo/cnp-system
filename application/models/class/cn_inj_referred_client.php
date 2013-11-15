<?php 
class CN_Inj_Referred_Client {

	public static function findById($id) {
		$sql = " 
			SELECT * FROM " . CNP_CASE_INJ_REFERRED_CLIENT . "
			WHERE
				id = " . Mapper::safeSql($id) . "

			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findAll() {
		$sql = " 
			SELECT * FROM " . CNP_CASE_INJ_REFERRED_CLIENT . "
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findByCaseCode($params) {
		$sql = " 
			SELECT * FROM " . CNP_CASE_INJ_REFERRED_CLIENT . "
			WHERE
				case_code = " . Mapper::safeSql($params['case_code']) . "
			LIMIT 1
		";

		return Mapper::runSql($sql,true,false);
	}


	public static function save($record,$id) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		if($id) {
			$sqlstart 	= " UPDATE " . CNP_CASE_INJ_REFERRED_CLIENT . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . CNP_CASE_INJ_REFERRED_CLIENT . " SET ";
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
			DELETE FROM " . CNP_CASE_INJ_REFERRED_CLIENT . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

	public static function deleteByCaseCode($params) {
		$sql = "
			DELETE FROM " . CNP_CASE_INJ_REFERRED_CLIENT . "
			WHERE case_code = " . Mapper::safeSql($params['case_code']) . "
		";
		Mapper::runSql($sql,false);
	}

}

?>