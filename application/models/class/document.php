<?php 
class Document {

	public static function findById($id, $fields) {
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . CNP_DOCUMENT . "
			WHERE id = " . Mapper::safeSql($id) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findByIdAndParentId($id,$parent_id, $fields) {
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . CNP_DOCUMENT . "
			WHERE 
				id = " . Mapper::safeSql($id) . " AND
				parent_id = " . Mapper::safeSql($parent_id) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findAllActiveChild($parent_id) {
		$sql = " 
			SELECT * FROM " . CNP_DOCUMENT . "
			WHERE 
				parent_id 	= " . Mapper::safeSql($parent_id) . " AND
				is_archive 	= " . Mapper::safeSql(NO) . "
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAll($order = "", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");

		$sql = " 
			SELECT * FROM " . CNP_DOCUMENT . "
			{$order}
			{$limit}
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAllAvailableDocumentSets($params) {

		$order = ($params['order'] == "" ? "" : " ORDER BY " . $params['order']);
		$limit = ($params['limit'] == "" ? "" : " LIMIT " . $params['limit']);
		
		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . CNP_DOCUMENT . "
			WHERE
				firm_id 	= " . Mapper::safeSql($params['firm_id']) . " AND
				file_type 	= " . Mapper::safeSql(DOCUMENT_SET) . " AND
				is_archive 	= " . Mapper::safeSql(NO) . "

			{$order}
			{$limit}
		";

		return Mapper::runSql($sql,true,true);
	}

	public static function findAllActiveFirmSharedFiles($params) {

		$user_id 	= (int) $params['user_id'];
		$parent_id 	= (int) $params['parent_id'];
		$firm_id 	= (int) $params['firm_id'];

		$limit = ($params['limit'] == "" ? "" : " LIMIT " . $params['limit']);
		$order = ($params['order'] == "" ? "" : " ORDER BY " . $params['order']);


		if($params['query']) {
			$q = $params['query'];
			$sqlsearchstring = "
				AND 
				(
					title LIKE '%".$q."%' OR
					description LIKE '%".$q."%' OR
					file_type LIKE '%".$q."%' OR
					last_modified LIKE '%".$q."%'
				)
			";
		}

		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . CNP_DOCUMENT . "
			WHERE

			(
				(
					parent_id 	= " . Mapper::safeSql($parent_id) . " AND
					uploaded_by = " . Mapper::safeSql($user_id) . " AND
					is_archive 	= " . Mapper::safeSql(NO) . "
				)

				OR 

				(
					parent_id 	= " . Mapper::safeSql($parent_id) . " AND
					firm_id 	= " . Mapper::safeSql($firm_id) . " AND
					file_type 	= " . Mapper::safeSql(DOCUMENT_SET) . " AND
					is_archive 	= " . Mapper::safeSql(NO) . "
				)

				OR

				(
					parent_id 	= " . Mapper::safeSql($parent_id) . " AND
					firm_id 	= " . Mapper::safeSql($firm_id) . " AND
					file_type 	= " . Mapper::safeSql(DOCUMENT) . " AND
					is_visible  = " . Mapper::safeSql(YES) . " AND
					is_archive 	= " . Mapper::safeSql(NO) . "
				)
			)

			{$sqlsearchstring}

			{$order}
			{$limit}

		";
		return Mapper::runSql($sql,true,true);
	}

	public static function countAllActiveFirmSharedFiles($params) {

		$user_id 	= (int) $params['user_id'];
		$parent_id 	= (int) $params['parent_id'];
		$firm_id 	= (int) $params['firm_id'];

		$sql = " 
			SELECT COUNT(id) as total FROM " . CNP_DOCUMENT . "
			WHERE

			(
				parent_id 	= " . Mapper::safeSql($parent_id) . " AND
				uploaded_by = " . Mapper::safeSql($user_id) . " AND
				is_archive 	= " . Mapper::safeSql(NO) . "
			)

			OR 

			(
				parent_id 	= " . Mapper::safeSql($parent_id) . " AND
				firm_id 	= " . Mapper::safeSql($firm_id) . " AND
				file_type 	= " . Mapper::safeSql(DOCUMENT_SET) . " AND
				is_archive 	= " . Mapper::safeSql(NO) . "
			)

			OR

			(
				parent_id 	= " . Mapper::safeSql($parent_id) . " AND
				firm_id 	= " . Mapper::safeSql($firm_id) . " AND
				file_type 	= " . Mapper::safeSql(DOCUMENT) . " AND
				is_visible  = " . Mapper::safeSql(YES) . " AND
				is_archive 	= " . Mapper::safeSql(NO) . "
			)
		";

		$record = Mapper::runSql($sql,true,false);
		return $record['total'];
	}

	public static function findAllAdminDocument($user_id, $parent_id, $firm_id, $order = "", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");
		$sql = " 
			SELECT * FROM " . CNP_DOCUMENT . "
			WHERE

			(
				parent_id 	= " . Mapper::safeSql($parent_id) . " AND
				uploaded_by = " . Mapper::safeSql($user_id) . " AND
				is_archive 	= " . Mapper::safeSql(NO) . "
			)

			{$order}
			{$sort}

		";
		return Mapper::runSql($sql,true,true);
	}

	public static function countAllActiveFileByParentId($parent_id) {
		$sql = " 
			SELECT COUNT(*) as total FROM " . CNP_DOCUMENT . "
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

	public static function findAllActiveOwnDocumentSet($uploaded_by, $order = "", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");
		$sql = " 
			SELECT * FROM " . CNP_DOCUMENT . "
			WHERE
				uploaded_by = " . Mapper::safeSql($uploaded_by) . " AND
				file_type = " . Mapper::safeSql(DOCUMENT_SET) . " AND
				is_archive = " . Mapper::safeSql(NO) . "

			{$order}
			{$sort}
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findByEmailAddress($email_address) {
		$sql = " 
			SELECT * FROM " . CNP_DOCUMENT . "
			WHERE email_address = " . Mapper::safeSql($email_address) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findByParentId($parent_id, $fields) {
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . CNP_DOCUMENT . "
			WHERE email_address = " . Mapper::safeSql($parent_id) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findAllPublicSharedDocument($firm_id, $parent_id, $order = "", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");

		$sql = " 
			SELECT 
				d.id as id,
				d.title as title,
				d.description as description,  
				d.file_type as file_type,
				d.last_modified as last_modified
			FROM " . CNP_DOCUMENT . " d
			INNER JOIN " . CNP_DOCUMENT_PERMISSION . " dp 
			ON d.id = dp.document_id
			WHERE
				d.parent_id = " . Mapper::safeSql($parent_id) . " AND
				d.is_archive = " . Mapper::safeSql(NO) . " AND
				dp.firm_id = " . Mapper::safeSql($firm_id) . "

			{$order}
			{$limit}
		";
		return Mapper::runSql($sql,true,true);
	}


	public static function findAllOtherDocumentSet($id, $firm_id, $order = "", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");

		$sql = " 
			SELECT * FROM " . CNP_DOCUMENT . "
			WHERE
				(
					firm_id 	= " . Mapper::safeSql($firm_id) . " OR
					uploaded_by = " . Mapper::safeSql($user_id) . "
				)

				AND 

				file_type = " . Mapper::safeSql(DOCUMENT_SET) . " AND
				is_archive = " . Mapper::safeSql(NO) . " AND
				id != " . Mapper::safeSql($id) . "
			
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAllDocumentSets($firm_id, $user_id, $fields, $order = "", $limit = "") {
		$order = ($order == "" ? "" : " ORDER BY {$order}");
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");

		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . CNP_DOCUMENT . "
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

	public static function findAllDocumentCopies($params) {
		$id 				= (int) $params['id'];
		$main_document_id 	= (int) $params['main_document_id'];

		$order = ($order == "" ? "" : " ORDER BY {$order}");
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");

		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . CNP_DOCUMENT . "
			WHERE 
				(
					
					(
						id = " . Mapper::safeSql($id) . " AND
						document_type = " . Mapper::safeSql(ORIGINAL_DOC) . "
					)  
	
					OR

					(
						main_document_id = " . Mapper::safeSql($id) . " AND
						document_type = " . Mapper::safeSql(BRANCH_DOC) . "
					)
				)

				AND

				file_type = " . Mapper::safeSql(DOCUMENT) . " AND
				is_archive = " . Mapper::safeSql(NO) . "
		
			{$order}
			{$limit}
		";

		return Mapper::runSql($sql,true,true);
	}

	public static function generateUserDocumentsDatatable($params) {

		if($params['search']) {
			$q = $params['search'];
			$search = "
				(
					title LIKE  '%" . $q . "%' OR
					description LIKE  '%" . $q . "%' OR
					date_accepted LIKE  '%" . date("Y-m-d",strtotime($q)) . "%'
				)
				AND

			";
		}

		$order = ($params['order'] == "" ? "" : " ORDER BY " . $params['order']);
		$limit = ($params['limit'] == "" ? "" : " LIMIT " . $params['limit']);

		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . CNP_DOCUMENT . "
			WHERE
				{$search}
				firm_id 	= " . Mapper::safeSql($params['firm_id']) . " AND
				parent_id 	= " . Mapper::safeSql($params['parent_id']) . " AND
				is_visible 	= " . Mapper::safeSql(YES) . " AND
				file_type 	= " . Mapper::safeSql(DOCUMENT) . " AND
				is_archive 	= " . Mapper::safeSql(NO) . "

			{$order}
			{$limit}

		";
		
		return Mapper::runSql($sql,true,true);
	}

	public static function countUserDocumentsDatatable($params) {

		if($params['search']) {
			$q = $params['search'];
			$search = "
				(
					title LIKE  '%" . $q . "%' OR
					description LIKE  '%" . $q . "%' OR
					date_accepted LIKE  '%" . date("Y-m-d",strtotime($q)) . "%'
				) 
				AND

			";
		}

		$sql = " 
			SELECT COUNT(id) as total FROM " . CNP_DOCUMENT . "
			WHERE
				{$search}
				firm_id 	= " . Mapper::safeSql($params['firm_id']) . " AND
				parent_id 	= " . Mapper::safeSql($params['parent_id']) . " AND
				is_visible 	= " . Mapper::safeSql(YES) . " AND
				file_type 	= " . Mapper::safeSql(DOCUMENT) . " AND
				is_archive 	= " . Mapper::safeSql(NO) . "
		";

		$record = Mapper::runSql($sql,true,false);
		return $record['total'];
	}

	public static function save($record,$id) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		if($id) {
			$sqlstart 	= " UPDATE " . CNP_DOCUMENT . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . CNP_DOCUMENT . " SET ";
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
			DELETE FROM " . CNP_DOCUMENT . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

	public static function delete_sub($parent_id) {

	}

}

?>