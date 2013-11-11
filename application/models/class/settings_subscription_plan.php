<?php 
class Settings_Subscription_Plan {

	public static function findById($id) {
		$sql = " 
			SELECT * FROM " . CNP_SETTINGS_SUBSCRIPTION_PLAN . "
			WHERE id = " . Mapper::safeSql($id) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findAll() {
		$sql = " 
			SELECT * FROM " . CNP_SETTINGS_SUBSCRIPTION_PLAN . "
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAllActive($order ="", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$sql = " 
			SELECT * FROM " . CNP_SETTINGS_SUBSCRIPTION_PLAN . "
			WHERE
				is_active = " . Mapper::safeSql(YES) . "

			{$order}
			{$sort}
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function save($record) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		$sqlstart 	=  " INSERT INTO " . CNP_SETTINGS_SUBSCRIPTION_PLAN . " SET ";
		$sqlbody 	= implode($arr," , ");
		$sqlend		= "";
		$sql 		= $sqlstart.$sqlbody.$sqlend;
		
		Mapper::runSql($sql,false);
		return mysql_insert_id();
	}

}

?>