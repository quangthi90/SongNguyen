<?php
class ModelPopupPopupText extends Model {
	public function addPopupText($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "popup_text SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "'");
		
		$popup_text_id = $this->db->getLastId();
		
		foreach ($data['popup_text_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "popup_text_description SET popup_text_id = '" . (int)$popup_text_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', content = '" . $this->db->escape($value['content']) . "'");
		}
		
		$this->cache->delete('popup_text');
	}
	
	public function editPopupText($popup_text_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "popup_text SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE id = '" . (int)$popup_text_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "popup_text_description WHERE popup_text_id = '" . (int)$popup_text_id . "'");
		
		foreach ($data['popup_text_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "popup_text_description SET popup_text_id = '" . (int)$popup_text_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', content = '" . $this->db->escape($value['content']) . "'");
		}
	}

	public function deletePopupText($popup_text_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "popup_text WHERE id = '" . (int)$popup_text_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "popup_text_description WHERE popup_text_id = '" . (int)$popup_text_id . "'");
		
		$this->cache->delete('popup_text');
	}
	
	public function getPopupText($popup_text_id) {
		$query = $this->db->query("SELECT DISTINCT pt.id AS popup_text_id, pt.sort_order AS sort_order, pt.status AS status FROM " . DB_PREFIX . "popup_text pt WHERE id = '" . $popup_text_id . "'");
				
		return $query->row;
	}
	
	public function getPopupTexts($data = array()) {
		$sql = "SELECT pt.id AS popup_text_id, pt.sort_order AS sort_order, pt.status AS status, ptd.title AS title FROM " . DB_PREFIX . "popup_text pt LEFT JOIN " . DB_PREFIX . "popup_text_description ptd ON (pt.id = ptd.popup_text_id)";
				
		$sql .= " WHERE ptd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
		
		if (!empty($data['filter_title'])) {
			$sql .= " AND ptd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
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

	public function getPopupTextDescriptions($popup_text_id) {
		$popup_text_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "popup_text_description WHERE popup_text_id = '" . (int)$popup_text_id . "'");
		
		foreach ($query->rows as $result) {
			$popup_text_description_data[$result['language_id']] = array(
				'title'             => $result['title'],
				'content'      => $result['content'],
			);
		}
		
		return $popup_text_description_data;
	}

	public function getTotalPopupTexts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT pt.id) AS total FROM " . DB_PREFIX . "popup_text pt LEFT JOIN " . DB_PREFIX . "popup_text_description ptd ON (pt.id = ptd.popup_text_id)";
		 
		$sql .= " WHERE ptd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		 			
		if (!empty($data['filter_title'])) {
			$sql .= " AND ptd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND pt.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	
}
?>
