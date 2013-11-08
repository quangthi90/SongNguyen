<?php
class ModelContactContact extends Model {
	/*public function addSubcriber($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "subcriber SET status = '" . (int)$data['status'] . "', email = '" . $this->db->escape($data['email']) . "'");
	}
	
	public function editSubcriber($subcriber_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "subcriber SET status = '" . (int)$data['status'] . "', email = '" . $this->db->escape($data['email']) . "' WHERE id = '" . $subcriber_id ."'");
	}
*/	
	public function deleteContact($contact_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contact WHERE id = '" . (int) $contact_id . "'");
	}
	
	public function getContact($contact_id) {
		$sql = "SELECT c.id AS contact_id, c.email AS email, c.name AS name, c.phone AS phone, c.content AS content, c.date_posted AS date_posted, c.status AS status FROM " . DB_PREFIX . "contact c WHERE c.id ='" . (int)$contact_id . "'";
				
		return $this->db->query($sql)->row;
	}
		
	public function getContacts($data = array()) {
		$sql = "SELECT c.id AS contact_id, c.email AS email, c.name AS name, c.status AS status FROM " . DB_PREFIX . "contact c";

		/*if (!empty($data['filter_email'])) {
			$sql .= " WHERE c.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " AND c.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			if (!empty($data['filter_email'])) {
				$sql .= " AND s.status = '" . (int)$data['filter_status'] . "'";
			}else {
				$sql .= " WHERE s.status = '" . (int)$data['filter_status'] . "'";
			}
		}*/
		
		$sql .= " GROUP BY c.id";
					
		$sort_data = array(
			'c.email',
			'c.name',
			'c.date_posted',
			'c.status',
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY c.date_posted";	
		}
		
		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
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

	public function getTotalContacts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT c.id) AS total FROM " . DB_PREFIX . "contact c";

		/*if (!empty($data['filter_email'])) {
			$sql .= " WHERE s.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			if (!empty($data['filter_email'])) {
				$sql .= " AND s.status = '" . (int)$data['filter_status'] . "'";
			}else {
				$sql .= " WHERE s.status = '" . (int)$data['filter_status'] . "'";
			}
		}*/
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
}
?>
