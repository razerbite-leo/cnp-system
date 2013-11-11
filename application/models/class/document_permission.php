<?php 
class Document_Permission {

	public static function findById($id) {
		$sql = " 
			SELECT * FROM " . CNP_DOCUMENT_PERMISSION . "
			WHERE id = " . Mapper::safeSql($id) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findAll() {
		$sql = " 
			SELECT * FROM " . CNP_DOCUMENT_PERMISSION . "
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAllByDocumentId($document_id, $order = "", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");

		$sql = " 
			SELECT * FROM " . CNP_DOCUMENT_PERMISSION . "
			WHERE document_id = " . Mapper::safeSql($document_id) . "
			{$order}
			{$sort}
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAllActiveOwnDocumentSet($uploaded_by, $order = "", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");
		$sql = " 
			SELECT * FROM " . CNP_DOCUMENT_PERMISSION . "
			WHERE
				uploaded_by = " . Mapper::safeSql($uploaded_by) . " AND
				file_type = " . Mapper::safeSql(DOCUMENT_SET) . " AND
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
			$sqlstart 	= " UPDATE " . CNP_DOCUMENT_PERMISSION . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . CNP_DOCUMENT_PERMISSION . " SET ";
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
			DELETE FROM " . CNP_DOCUMENT_PERMISSION . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

}

?>