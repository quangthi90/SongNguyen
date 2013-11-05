<?php
class ModelPopupPopup extends Model {
	public function addPopup($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "popup SET type = '" . (int)$data['type'] . "', banner_id = '" . (int)$data['banner_id'] . "', status = '0', sort_order = '" . (int)$data['sort_order'] . "', embbed = '" . $this->db->escape($data['embbed']) . "'");
		
		$popup_id = $this->db->getLastId();
		
		foreach ($data['popup_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "popup_description SET popup_id = '" . (int)$popup_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', content = '" . $this->db->escape($value['content']) . "'");
		}
		
		$this->cache->delete('popup');
	}
	
	public function editPopup($popup_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "popup SET type = '" . (int)$data['type'] . "', banner_id = '" . (int)$data['banner_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', embbed = '" . $this->db->escape($data['embbed']) . "' WHERE id = '" . (int)$popup_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "popup_description WHERE popup_id = '" . (int)$popup_id . "'");
		
		foreach ($data['popup_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "popup_description SET popup_id = '" . (int)$popup_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', content = '" . $this->db->escape($value['content']) . "'");
		}
	}

	public function activePopup($popup_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "popup SET status = '0'");
		$this->db->query("UPDATE " . DB_PREFIX . "popup SET status = '1' WHERE id = '" . (int)$popup_id . "'");
	}

	public function deactivePopup($popup_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "popup SET status = '0' WHERE id = '" . (int)$popup_id . "'");
	}

	public function deletePopup($popup_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "popup WHERE id = '" . (int)$popup_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "popup_description WHERE popup_id = '" . (int)$popup_id . "'");
		
		$this->cache->delete('popup');
	}
	
	public function getPopup($popup_id) {
		$query = $this->db->query("SELECT DISTINCT pt.id AS popup_id, pt.type AS type, pt.banner_id AS banner_id, pt.sort_order AS sort_order, pt.status AS status, pt.embbed AS embbed FROM " . DB_PREFIX . "popup pt WHERE id = '" . $popup_id . "'");
				
		return $query->row;
	}
	
	public function getPopups($data = array()) {
		$sql = "SELECT pt.id AS popup_id, pt.type AS type, pt.banner_id AS banner_id, pt.sort_order AS sort_order, pt.status AS status, pt.embbed AS embbed, ptd.title AS title FROM " . DB_PREFIX . "popup pt LEFT JOIN " . DB_PREFIX . "popup_description ptd ON (pt.id = ptd.popup_id)";
				
		$sql .= " WHERE ptd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
		
		if (!empty($data['filter_title'])) {
			$sql .= " AND ptd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}
		
		if (isset($data['filter_type']) && !is_null($data['filter_type'])) {
			$sql .= " AND pt.type = '" . (int)$data['filter_type'] . "'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND pt.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$sql .= " GROUP BY pt.id";
					
		$sort_data = array(
			'ptd.title',
			'pt.status',
			'pt.sort_order',
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY pt.sort_order";	
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

	public function getPopupDescriptions($popup_id) {
		$popup_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "popup_description WHERE popup_id = '" . (int)$popup_id . "'");
		
		foreach ($query->rows as $result) {
			$popup_description_data[$result['language_id']] = array(
				'title'             => $result['title'],
				'description'      => $result['description'],
				'content'      => $result['content'],
			);
		}
		
		return $popup_description_data;
	}

	public function getTotalPopups($data = array()) {
		$sql = "SELECT COUNT(DISTINCT pt.id) AS total FROM " . DB_PREFIX . "popup pt LEFT JOIN " . DB_PREFIX . "popup_description ptd ON (pt.id = ptd.popup_id)";
		 
		$sql .= " WHERE ptd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		 			
		if (!empty($data['filter_title'])) {
			$sql .= " AND ptd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}
		
		if (isset($data['filter_type']) && !is_null($data['filter_type'])) {
			$sql .= " AND pt.type = '" . (int)$data['filter_type'] . "'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND pt.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	
}
?>
