<?php
class ModelNewsNewsCategory extends Model {	
	public function getNewsCategory($news_category_id) {
		$query = $this->db->query("SELECT DISTINCT nc.id AS news_category_id, nc.parent_id, nc.sort_order, nc.status, nc.have_popup, ncd.name, nc.primary_image AS primary_image, nc.second_image AS second_image, nc.link AS link, (SELECT ua.keyword FROM url_alias ua WHERE query = 'news_category_id=" . (int)$news_category_id . "') AS keyword FROM " . DB_PREFIX . "news_category nc LEFT JOIN " . DB_PREFIX . "news_category_description ncd ON (nc.id = ncd.news_category_id) WHERE nc.id = '" . (int)$news_category_id . "' AND ncd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	} 
	
	public function getNewsCategories($data) {
		$sql = "SELECT nc.id AS news_category_id, ncd.name, ncd.description, nc.sort_order, nc.date_added, nc.date_modified, nc.status, nc.have_popup, nc.parent_id, nc.link AS link, ncd.language_id FROM " . DB_PREFIX . "news_category nc LEFT JOIN " . DB_PREFIX . "news_category_description ncd ON (nc.id = ncd.news_category_id) WHERE ncd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND ncd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_parent_id'])) {
			$sql .= " AND nc.parent_id = '" . (int)$data['filter_parent_id'] . "'";
		}

		if (!empty($data['filter_status'])) {
			$sql .= " AND nc.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['sort'])) {
			$sql .= " ORDER BY " . $this->db->escape($data['sort']);
		}else {
			$sql .= " ORDER BY nc.sort_order";
		}

		if (!empty($data['order']) && $data['order'] == 'DESC') {
			$sql .= " DESC";
		}else {
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
	
	public function getTotalNewsCategories($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_category nc LEFT JOIN " . DB_PREFIX . "news_category_description ncd ON (nc.id = ncd.news_category_id) WHERE ncd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND ncd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_parent_id'])) {
			$sql .= " AND nc.parent_id = '" . (int)$data['filter_parent_id'] . "'";
		}

		if (!empty($data['filter_status'])) {
			$sql .= " AND nc.status = '" . (int)$data['filter_status'] . "'";
		}
					
		$query = $this->db->query($sql);
		return $query->row['total'];
	}	
}
?>