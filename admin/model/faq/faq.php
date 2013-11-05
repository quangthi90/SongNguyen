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
		$query = $this->db->query("SELECT DISTINCT f.id AS faq_id, f.sort_order AS sort_order, f.status AS status, f.faq_category_id AS faq_category_id FROM " . DB_PREFIX . "faq f LEFT JOIN " . DB_PREFIX . "faq_description fd ON (f.id = fd.faq_id) WHERE f.id = '" . (int)$faq_id . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
		return $query->row;
	}
	
	public function getFaqs($data = array()) {
		$sql = "SELECT f.id AS faq_id, f.sort_order AS sort_order, f.status AS status, f.faq_category_id AS faq_category_id, fd.question AS question, fd.answer AS answer, fcd.name AS faq_category_name FROM " . DB_PREFIX . "faq f LEFT JOIN " . DB_PREFIX . "faq_description fd ON (f.id = fd.faq_id) LEFT JOIN " . DB_PREFIX . "faq_category fc ON (fc.id = f.faq_category_id) LEFT JOIN faq_category_description fcd ON (fc.id = fcd.faq_category_id)";
				
		$sql .= " WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND (fcd.language_id = '" . (int)$this->config->get('config_language_id') . "' OR f.faq_category_id = '0')"; 
		
		if (!empty($data['filter_faq_category_id'])) {
			$sql .= " AND f.faq_category_id = '" . (int)$data['filter_faq_category_id'] . "'";	
		}
		
		if (!empty($data['filter_faq_category_name'])) {
			$sql .= " AND fcd.name LIKE '" . $this->db->escape($data['filter_faq_category_name']) . "%'";
		}
		
		if (!empty($data['filter_question'])) {
			$sql .= " AND fd.question LIKE '" . $this->db->escape($data['filter_question']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND f.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$sql .= " GROUP BY f.id";
					
		$sort_data = array(
			'fd.question',
			'f.status',
			'f.date_added',
			'f.sort_order'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY f.date_added";	
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
		$sql = "SELECT COUNT(DISTINCT f.id) AS total FROM " . DB_PREFIX . "faq f LEFT JOIN " . DB_PREFIX . "faq_description fd ON (f.id = fd.faq_id) LEFT JOIN " . DB_PREFIX . "faq_category fc ON (fc.id = f.faq_category_id) LEFT JOIN faq_category_description fcd ON (fc.id = fcd.faq_category_id)";
				
		$sql .= " WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND (fcd.language_id = '" . (int)$this->config->get('config_language_id') . "' OR f.faq_category_id = '0')"; 
		
		if (!empty($data['filter_faq_category_id'])) {
			$sql .= " AND f.faq_category_id = '" . (int)$data['filter_faq_category_id'] . "'";	
		}
		
		if (!empty($data['filter_faq_category_name'])) {
			$sql .= " AND fcd.name LIKE '" . $this->db->escape($data['filter_faq_category_name']) . "%'";
		}
		 			
		if (!empty($data['filter_question'])) {
			$sql .= " AND fd.question LIKE '" . $this->db->escape($data['filter_question']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND f.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	
}
?>
