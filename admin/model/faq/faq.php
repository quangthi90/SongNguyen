<?php
class ModelFaqFaq extends Model {
	public function addFaq($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "faq SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', faq_category_id = '" . (int)$data['faq_category_id'] . "', date_added = NOW(), date_modified = NOW()");
		
		$faq_id = $this->db->getLastId();
		
		foreach ($data['faq_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "faq_description SET faq_id = '" . (int)$faq_id . "', language_id = '" . (int)$language_id . "', question = '" . $this->db->escape($value['question']) . "', answer = '" . $this->db->escape($value['answer']) . "'");
		}
		
		$this->cache->delete('faq');
	}
	
	public function editFaq($faq_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "faq SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', faq_category_id = '" . (int)$data['faq_category_id'] . "', date_modified = NOW() WHERE id = '" . (int)$faq_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "faq_description WHERE faq_id = '" . (int)$faq_id . "'");
		
		foreach ($data['faq_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "faq_description SET faq_id = '" . (int)$faq_id . "', language_id = '" . (int)$language_id . "', question = '" . $this->db->escape($value['question']) . "', answer = '" . $this->db->escape($value['answer']) . "'");
		}
	}
	
	public function deleteFaq($faq_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "faq WHERE id = '" . (int) $faq_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "faq_description WHERE faq_id = '" . (int) $faq_id . "'");
		
		$this->cache->delete('faq');
	}
	
	public function getFaq($faq_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "faq n LEFT JOIN " . DB_PREFIX . "faq_description nd ON (n.id = nd.faq_id) WHERE n.id = '" . (int)$faq_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
		return $query->row;
	}

	public function getFaqCategory($faq_category_id) {
		$sql = "SELECT fc.id AS faq_category_id, (SELECT fcd.name FROM " . DB_PREFIX . "faq_category_description fcd WHERE fcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND fcd.faq_category_id = '" . (int)$faq_category_id . "') AS name FROM " . DB_PREFIX . "faq_category fc WHERE fc.id = '" . (int)$faq_category_id . "'";

		return $this->db->query($sql)->row;
	}
	
	public function getFaqs($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "faq n LEFT JOIN " . DB_PREFIX . "faq_description nd ON (n.id = nd.faq_id)";
				
		$sql .= " WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
		
		if (!empty($data['filter_faq_category_id'])) {
			$sql .= " AND n.faq_category_id = '" . (int)$data['filter_faq_category_id'] . "'";			
		}
		
		if (!empty($data['filter_question'])) {
			$sql .= " AND nd.question LIKE '" . $this->db->escape($data['filter_question']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND n.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$sql .= " GROUP BY n.id";
					
		$sort_data = array(
			'nd.question',
			'n.status',
			'n.sort_order'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY nd.question";	
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
	
	public function getFaqDescriptions($faq_id) {
		$faq_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faq_description WHERE faq_id = '" . (int)$faq_id . "'");
		
		foreach ($query->rows as $result) {
			$faq_description_data[$result['language_id']] = array(
				'question'             => $result['question'],
				'answer'      => $result['answer'],
			);
		}
		
		return $faq_description_data;
	}

	public function getTotalFaqs($data = array()) {
		$sql = "SELECT COUNT(DISTINCT n.id) AS total FROM " . DB_PREFIX . "faq n LEFT JOIN " . DB_PREFIX . "faq_description nd ON (n.id = nd.faq_id)";

		if (!empty($data['filter_faq_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "faq_to_faq_category n2nc ON (n.id = n2nc.faq_id)";			
		}
		 
		$sql .= " WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		 			
		if (!empty($data['filter_question'])) {
			$sql .= " AND nd.question LIKE '" . $this->db->escape($data['filter_question']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND n.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	
}
?>
