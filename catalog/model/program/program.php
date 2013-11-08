<?php
class ModelProgramProgram extends Model {
/*	public function addProgram($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "program SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW(), date_modified = NOW()");
		
		$program_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "program SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$program_id . "'");
		}
		
		foreach ($data['program_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "program_description SET program_id = '" . (int)$program_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', content = '" . $this->db->escape($value['content']) . "'");
		}
		
		$this->cache->delete('program');
	}
	
	public function editProgram($program_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "program SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE id = '" . (int)$program_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "program SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$program_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "program_description WHERE program_id = '" . (int)$program_id . "'");
		
		foreach ($data['program_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "program_description SET program_id = '" . (int)$program_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', content = '" . $this->db->escape($value['content']) . "'");
		}
	}

	public function deleteProgram($program_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "program WHERE id = '" . (int) $program_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "program_description WHERE program_id = '" . (int) $program_id . "'");
		
		$this->cache->delete('program');
	}
*/	
	public function getProgram($program_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "program n LEFT JOIN " . DB_PREFIX . "program_description nd ON (n.id = nd.program_id) WHERE n.id = '" . (int)$program_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
		return $query->row;
	}
	
	public function getPrograms($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "program n LEFT JOIN " . DB_PREFIX . "program_description nd ON (n.id = nd.program_id)";
				
		$sql .= " WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
		
		if (!empty($data['filter_title'])) {
			$sql .= " AND nd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND n.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$sql .= " GROUP BY n.id";
					
		$sort_data = array(
			'nd.title',
			'n.status',
			'n.date_added',
			'n.sort_order'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY nd.title";	
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
/*
	public function getProgramDescriptions($program_id) {
		$program_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "program_description WHERE program_id = '" . (int)$program_id . "'");
		
		foreach ($query->rows as $result) {
			$program_description_data[$result['language_id']] = array(
				'title'             => $result['title'],
				'content'      => $result['content'],
			);
		}
		
		return $program_description_data;
	}
*/
	public function getTotalPrograms($data = array()) {
		$sql = "SELECT COUNT(DISTINCT n.id) AS total FROM " . DB_PREFIX . "program n LEFT JOIN " . DB_PREFIX . "program_description nd ON (n.id = nd.program_id)";
		 
		$sql .= " WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		 			
		if (!empty($data['filter_title'])) {
			$sql .= " AND nd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND n.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	
}
?>
