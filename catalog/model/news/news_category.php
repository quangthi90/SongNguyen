<?php
class ModelNewsNewsCategory extends Model {
	/*public function addNewsCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "news_category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$news_category_id = $this->db->getLastId();

		if (isset($data['primary_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news_category SET primary_image = '" . $this->db->escape(html_entity_decode($data['primary_image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$news_category_id . "'");
		}

		if (isset($data['second_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news_category SET second_image = '" . $this->db->escape(html_entity_decode($data['second_image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$news_category_id . "'");
		}
		
		foreach ($data['news_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_category_description SET news_category_id = '" . (int)$news_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_category_id=" . (int) $news_category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('news_category');
	}
	
	public function editNewsCategory($news_category_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "news_category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE id = '" . (int)$news_category_id . "'");

		if (isset($data['primary_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news_category SET primary_image = '" . $this->db->escape(html_entity_decode($data['primary_image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$news_category_id . "'");
		}

		if (isset($data['second_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news_category SET second_image = '" . $this->db->escape(html_entity_decode($data['second_image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$news_category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "news_category_description WHERE news_category_id = '" . (int)$news_category_id . "'");

		foreach ($data['news_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_category_description SET news_category_id = '" . (int)$news_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_category_id=" . (int)$news_category_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_category_id=" . (int) $news_category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('news_category');
	}
	
	public function deleteNewsCategory($news_category_id) {
		$childern_ids = $this->db->query("SELECT id FROM " . DB_PREFIX . "news_category WHERE parent_id = '" . (int)$news_category_id . "'")->rows;
		foreach ($childern_ids as $childern) {
			$this->deleteNewsCategory( $childern['id'] );
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "news_category WHERE id = '" . (int)$news_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_category_description WHERE news_category_id = '" . (int)$news_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_category_id=" . (int)$news_category_id . "'");
		
		$newses = $this->db->query("SELECT id FROM news WHERE news_category_id = '" . (int)$news_category_id . "'")->rows;
		foreach ($newses as $news) {	
			$this->db->query("DELETE FROM " . DB_PREFIX . "news WHERE id = '" . $news['id'] . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "news_description WHERE id = '" . $news['id'] . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "news_option WHERE news_id = '" . $news['id'] . "'");
		}
		
		$this->cache->delete('news_category');
		$this->cache->delete('news');
	} 
*/		
	public function getNewsCategory($news_category_id) {
		$query = $this->db->query("SELECT DISTINCT nc.id AS news_category_id, nc.parent_id, nc.sort_order, nc.status, ncd.name, nc.primary_image AS primary_image, nc.second_image AS second_image, nc.popup_id AS popup_id, (SELECT ua.keyword FROM url_alias ua WHERE query = 'news_category_id=" . (int)$news_category_id . "') AS keyword FROM " . DB_PREFIX . "news_category nc LEFT JOIN " . DB_PREFIX . "news_category_description ncd ON (nc.id = ncd.news_category_id) WHERE nc.id = '" . (int)$news_category_id . "'");
		
		return $query->row;
	} 
	
	public function getNewsCategories($data) {
		$sql = "SELECT nc.id AS news_category_id, ncd.name, ncd.description, nc.sort_order, nc.date_added, nc.date_modified, nc.status, nc.parent_id, nc.popup_id AS popup_id, ncd.language_id, pncd.name AS parent_name FROM " . DB_PREFIX . "news_category nc LEFT JOIN " . DB_PREFIX . "news_category_description ncd ON (nc.id = ncd.news_category_id) LEFT JOIN " . DB_PREFIX . "news_category pnc ON (nc.parent_id = pnc.id) LEFT JOIN " . DB_PREFIX . "news_category_description pncd ON (pnc.id = pncd.news_category_id) WHERE ncd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND (pncd.language_id = '" . (int)$this->config->get('config_language_id') . "' OR nc.parent_id = '0')";
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND ncd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_parent_id'])) {
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
	public function getNewsCategoryDescriptions($news_category_id) {
		$news_category_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_category_description WHERE news_category_id = '" . (int)$news_category_id . "'");
		
		foreach ($query->rows as $result) {
			$news_category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'             => $result['description'],
			);
		}
		
		return $news_category_description_data;
	}	
		
	public function getTotalNewsCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_category");
		
		return $query->row['total'];
	}	*/
}
?>