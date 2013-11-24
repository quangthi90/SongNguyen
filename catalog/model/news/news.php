<?php
class ModelNewsNews extends Model {
	public function getNews($news_id) {
		$query = $this->db->query("SELECT DISTINCT n.id AS news_id, n.sort_order AS sort_order, n.format AS format, nd.title AS title, n.status AS status, n.primary_image AS primary_image, n.second_image AS second_image, n.news_category_id AS news_category_id, n.date_added AS date_added, nd.content AS content FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.id = nd.news_id) WHERE n.id = '" . (int)$news_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
		return $query->row;
	}
	
	public function getNewses($data = array()) {
		$sql = "SELECT n.id AS news_id, n.sort_order AS sort_order, n.format AS format, n.status AS status, n.primary_image AS primary_image, n.second_image AS second_image, n.news_category_id AS news_category_id, nd.title AS title, ncd.name AS news_category_name, n.date_added AS date_added FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_category nc ON (nc.id = n.news_category_id) LEFT JOIN news_category_description ncd ON (nc.id = ncd.news_category_id)";
				
		$sql .= " WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND (ncd.language_id = '" . (int)$this->config->get('config_language_id') . "' OR n.news_category_id = '0')"; 
		
		if (!empty($data['filter_news_category_id'])) {
			$sql .= " AND n.news_category_id = '" . (int)$data['filter_news_category_id'] . "'";			
		}
		
		if (!empty($data['filter_news_category_name'])) {
			$sql .= " AND ncd.name LIKE '" . $this->db->escape($data['filter_news_category_name']) . "%'";
		}
		
		if (!empty($data['filter_title'])) {
			$sql .= " AND nd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND n.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$sql .= " GROUP BY n.id";
					
		$sort_data = array(
			'nd.title',
			'ncd.name',
			'n.status',
			'n.sort_order',
			'n.date_added',
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY n.date_added";	
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

	public function getTotalNewses($data = array()) {
		$sql = "SELECT COUNT(DISTINCT n.id) AS total FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.id = nd.news_id)";
				
		$sql .= " WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
		
		if (!empty($data['filter_news_category_id'])) {
			$sql .= " AND n.news_category_id = '" . (int)$data['filter_news_category_id'] . "'";			
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND n.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$query = $this->db->query($sql);
	
		return $query->row['total'];
	}
}
?>
