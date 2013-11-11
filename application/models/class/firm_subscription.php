<?php 
class Firm_Subscription {

	public static function findById($id) {
		$sql = " 
			SELECT * FROM " . CNP_CASE_FIRM_SUBSCRIPTION . "
			WHERE id = " . Mapper::safeSql($id) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function countAllActiveFileByParentId($parent_id) {
		$sql = " 
			SELECT COUNT(*) as total FROM " . CNP_CASE_FIRM_SUBSCRIPTION . "
			WHERE
				parent_id = " . Mapper::safeSql($parent_id) . " AND
				(
					file_type = " . Mapper::safeSql(DOCUMENT_IMAGE) . " OR
					file_type = " . Mapper::safeSql(DOCUMENT) . " 
				)
				AND
				is_archive 	= " . Mapper::safeSql(NO) . "
		";
		$record = Mapper::runSql($sql,true,false);
		return $record['total'];
	}

	public static function findAllDocumentSets($firm_id, $user_id, $fields, $order = "", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");

		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . CNP_CASE_FIRM_SUBSCRIPTION . "
			WHERE
				(
					firm_id 	= " . Mapper::safeSql($firm_id) . " OR
					uploaded_by = " . Mapper::safeSql($user_id) . "
				)

				AND 

				file_type = " . Mapper::safeSql(DOCUMENT_SET) . " AND
				is_archive = " . Mapper::safeSql(NO) . "
			
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function save($record,$id) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		if($id) {
			$sqlstart 	= " UPDATE " . CNP_CASE_FIRM_SUBSCRIPTION . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . CNP_CASE_FIRM_SUBSCRIPTION . " SET ";
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
			DELETE FROM " . CNP_CASE_FIRM_SUBSCRIPTION . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

	public static function delete_sub($parent_id) {

	}

}

?>