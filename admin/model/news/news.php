<?php
class ModelNewsNews extends Model {
	public function addNews($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "news SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', news_category_id = '" . (int)$data['news_category_id'] . "', format = '" . (int)$data['format'] . "', date_added = NOW(), date_modified = NOW()");
		
		$news_id = $this->db->getLastId();
		
		if (isset($data['primary_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news SET primary_image = '" . $this->db->escape(html_entity_decode($data['primary_image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$news_id . "'");
		}

		if (isset($data['second_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news SET second_image = '" . $this->db->escape(html_entity_decode($data['second_image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$news_id . "'");
		}
		
		foreach ($data['news_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_description SET news_id = '" . (int)$news_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', content = '" . $this->db->escape($value['content']) . "'");
		}
		
		$this->cache->delete('news');
	}
	
	public function editNews($news_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "news SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', news_category_id = '" . (int)$data['news_category_id'] . "', format = '" . (int)$data['format'] . "', date_modified = NOW() WHERE id = '" . (int)$news_id . "'");

		if (isset($data['primary_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news SET primary_image = '" . $this->db->escape(html_entity_decode($data['primary_image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$news_id . "'");
		}

		if (isset($data['second_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news SET second_image = '" . $this->db->escape(html_entity_decode($data['second_image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$news_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($data['news_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_description SET news_id = '" . (int)$news_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', content = '" . $this->db->escape($value['content']) . "'");
		}
	}

	public function deleteNews($news_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "news WHERE id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'");
		
		$this->cache->delete('news');
	}
	
	public function getNews($news_id) {
		$query = $this->db->query("SELECT DISTINCT n.id AS news_id, n.sort_order AS sort_order, n.format AS format, nd.title AS title, n.status AS status, n.primary_image AS primary_image, n.second_image AS second_image, n.news_category_id AS news_category_id FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.id = nd.news_id) WHERE n.id = '" . (int)$news_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
		return $query->row;
	}
	
	public function getNewses($data = array()) {
		$sql = "SELECT n.id AS news_id, n.sort_order AS sort_order, n.format AS format, n.status AS status, n.primary_image AS primary_image, n.second_image AS second_image, n.news_category_id AS news_category_id, nd.title AS title, ncd.name AS news_category_name FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_category nc ON (nc.id = n.news_category_id) LEFT JOIN news_category_description ncd ON (nc.id = ncd.news_category_id)";
				
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

	public function getNewsDescriptions($news_id) {
		$news_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($query->rows as $result) {
			$news_description_data[$result['language_id']] = array(
				'title'             => $result['title'],
				'content'      => $result['content'],
			);
		}
		
		return $news_description_data;
	}

	public function getTotalNewses($data = array()) {
		$sql = "SELECT COUNT(DISTINCT n.id) AS total FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_category nc ON (nc.id = n.news_category_id) LEFT JOIN news_category_description ncd ON (nc.id = ncd.news_category_id)";
				
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
		
		$query = $this->db->query($sql);
	
		return $query->row['total'];
	}	
}
?>
