<?php
class ModelPopupPopupVideo extends Model {
	public function addPopupVideo($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "popup_video SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', embbed = '" . $this->db->escape($data['embbed']) . "'");
		
		$popup_video_id = $this->db->getLastId();
		
		foreach ($data['popup_video_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "popup_video_description SET popup_video_id = '" . (int)$popup_video_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		$this->cache->delete('popup_video');
	}
	
	public function editPopupVideo($popup_video_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "popup_video SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', embbed = '" . $this->db->escape($data['embbed']) . "' WHERE id = '" . (int)$popup_video_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "popup_video_description WHERE popup_video_id = '" . (int)$popup_video_id . "'");
		
		foreach ($data['popup_video_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "popup_video_description SET popup_video_id = '" . (int)$popup_video_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
	}

	public function deletePopupVideo($popup_video_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "popup_video WHERE id = '" . (int)$popup_video_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "popup_video_description WHERE popup_video_id = '" . (int)$popup_video_id . "'");
		
		$this->cache->delete('popup_video');
	}
	
	public function getPopupVideo($popup_video_id) {
		$query = $this->db->query("SELECT DISTINCT pt.id AS popup_video_id, pt.sort_order AS sort_order, pt.status AS status, pt.embbed AS embbed FROM " . DB_PREFIX . "popup_video pt WHERE id = '" . $popup_video_id . "'");
				
		return $query->row;
	}
	
	public function getPopupVideos($data = array()) {
		$sql = "SELECT pt.id AS popup_video_id, pt.sort_order AS sort_order, pt.status AS status, pt.embbed AS embbed, ptd.title AS title FROM " . DB_PREFIX . "popup_video pt LEFT JOIN " . DB_PREFIX . "popup_video_description ptd ON (pt.id = ptd.popup_video_id)";
				
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

	public function getPopupVideoDescriptions($popup_video_id) {
		$popup_video_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "popup_video_description WHERE popup_video_id = '" . (int)$popup_video_id . "'");
		
		foreach ($query->rows as $result) {
			$popup_video_description_data[$result['language_id']] = array(
				'title'             => $result['title'],
				'description'      => $result['description'],
			);
		}
		
		return $popup_video_description_data;
	}

	public function getTotalPopupVideos($data = array()) {
		$sql = "SELECT COUNT(DISTINCT pt.id) AS total FROM " . DB_PREFIX . "popup_video pt LEFT JOIN " . DB_PREFIX . "popup_video_description ptd ON (pt.id = ptd.popup_video_id)";
		 
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