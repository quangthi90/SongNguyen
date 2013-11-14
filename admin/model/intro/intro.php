<?php
class ModelIntroIntro extends Model {
	public function addIntro($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "intro SET status = '0', name = '" . $this->db->escape($data['name']) . "', url = '" . $this->db->escape($data['url']) . "'");
	}
	
	public function editIntro($intro_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "intro SET name = '" . $this->db->escape($data['name']) . "', url = '" . $this->db->escape($data['url']) . "' WHERE id = '" . (int)$intro_id . "'");
	}

	public function activeIntro($intro_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "intro SET status = '0'");
		$this->db->query("UPDATE " . DB_PREFIX . "intro SET status = '1' WHERE id = '" . (int)$intro_id . "'");
	}

	public function deactiveIntro($intro_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "intro SET status = '0' WHERE id = '" . (int)$intro_id . "'");
	}
/*
	public function deleteIntro($intro_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "popup WHERE id = '" . (int)$popup_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "popup_description WHERE popup_id = '" . (int)$popup_id . "'");
		
		$this->cache->delete('popup');
	}
*/	
	public function getIntro($intro_id) {
		$query = $this->db->query("SELECT DISTINCT i.id AS intro_id, i.name AS name, i.url AS url, i.status AS status FROM " . DB_PREFIX . "intro i WHERE id = '" . $intro_id . "'");
				
		return $query->row;
	}
	
	public function getIntros($data = array()) {
		$sql = "SELECT i.id AS intro_id, i.status AS status, i.name AS name FROM " . DB_PREFIX . "intro i";
				
		$sql .= " WHERE i.id='*'";
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND i.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND i.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$sql .= " GROUP BY i.id";
					
		$sort_data = array(
			'i.name',
			'i.status',
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY i.name";	
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
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

	public function getTotalIntros($data = array()) {
		$sql = "SELECT COUNT(DISTINCT i.id) AS total FROM " . DB_PREFIX . "intro i";
		 		
		$sql .= " WHERE i.id='*'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND i.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND i.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	
}
?>
