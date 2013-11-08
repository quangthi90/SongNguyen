<?php
class ModelSubcriberSubcriber extends Model {
	public function addSubcriber($email) {
		if (!$this->isExistEmail($email)) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "subcriber SET status = '1', email = '" . $this->db->escape($email) . "'");
		}
	}

	public function isExistEmail($email) {
		$query = $this->db->query("SELECT email " . DB_PREFIX . "subcriber WHERE email = '" . $this->db->escape($email) . "'");

		if ($query->row) {
			return true;
		}else {
			return false;
		}
	}
/*	
	public function editSubcriber($subcriber_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "subcriber SET status = '" . (int)$data['status'] . "', email = '" . $this->db->escape($data['email']) . "' WHERE id = '" . $subcriber_id ."'");
	}
	
	public function deleteSubcriber($subcriber_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "subcriber WHERE id = '" . (int) $subcriber_id . "'");
	}
	
	public function getSubcriber($subcriber_id) {
		$sql = "SELECT s.id AS subcriber_id, s.email AS email, s.status AS status FROM " . DB_PREFIX . "subcriber s WHERE s.id ='" . (int)$subcriber_id . "'";
				
		return $this->db->query($sql)->row;
	}
	
	public function getSubcribers($data = array()) {
		$sql = "SELECT s.id AS subcriber_id, s.email AS email, s.status AS status FROM " . DB_PREFIX . "subcriber s";

		if (!empty($data['filter_email'])) {
			$sql .= " WHERE s.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			if (!empty($data['filter_email'])) {
				$sql .= " AND s.status = '" . (int)$data['filter_status'] . "'";
			}else {
				$sql .= " WHERE s.status = '" . (int)$data['filter_status'] . "'";
			}
		}
		
		$sql .= " GROUP BY s.id";
					
		$sort_data = array(
			's.email',
			's.status',
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY s.email";	
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
	
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	public function getAllSubcribers($data = array()) {
		$sql = "SELECT s.id AS subcriber_id, s.email AS email, s.status AS status FROM " . DB_PREFIX . "subcriber s";

		if (!empty($data['filter_email'])) {
			$sql .= " WHERE s.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			if (!empty($data['filter_email'])) {
				$sql .= " AND s.status = '" . (int)$data['filter_status'] . "'";
			}else {
				$sql .= " WHERE s.status = '" . (int)$data['filter_status'] . "'";
			}
		}
		
		$sql .= " GROUP BY s.id";
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}

	public function getTotalSubcribers($data = array()) {
		$sql = "SELECT COUNT(DISTINCT s.id) AS total FROM " . DB_PREFIX . "subcriber s";

		if (!empty($data['filter_email'])) {
			$sql .= " WHERE s.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			if (!empty($data['filter_email'])) {
				$sql .= " AND s.status = '" . (int)$data['filter_status'] . "'";
			}else {
				$sql .= " WHERE s.status = '" . (int)$data['filter_status'] . "'";
			}
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	*/
}
?>
