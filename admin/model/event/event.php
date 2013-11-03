<?php
class ModelEventEvent extends Model {
	public function addEvent($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "event SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW(), date_modified = NOW()");
		
		$event_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "event SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$event_id . "'");
		}
		
		foreach ($data['event_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "event_description SET event_id = '" . (int)$event_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', content = '" . $this->db->escape($value['content']) . "'");
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'event_id=" . $event_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		/*if (isset($data['event_category'])) {
			foreach ($data['event_category'] as $event_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "event_to_event_category SET event_id = '" . (int)$event_id . "', event_category_id = '" . (int)$event_category_id . "'");
			}
		}*/
		
		$this->cache->delete('event');
	}
	
	public function editEvent($event_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "event SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE id = '" . (int)$event_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "event SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$event_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "event_description WHERE event_id = '" . (int)$event_id . "'");
		
		foreach ($data['event_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "event_description SET event_id = '" . (int)$event_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', content = '" . $this->db->escape($value['content']) . "'");
		}
		
		/*$this->db->query("DELETE FROM " . DB_PREFIX . "event_to_event_category WHERE event_id = '" . (int)$event_id . "'");
		
		if (isset($data['event_category'])) {
			foreach ($data['event_category'] as $event_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "event_to_event_category SET event_id = '" . (int)$event_id . "', event_category_id = '" . (int)$event_category_id . "'");
			}		
		}*/

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'event_id=" . (int)$event_id . "'");
		
		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'event_id=" . $event_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
	}
/*	
	public function copyProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['sku'] = '';
			$data['upc'] = '';
			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';
						
			$data = array_merge($data, array('product_attribute' => $this->getProductAttributes($product_id)));
			$data = array_merge($data, array('product_description' => $this->getProductDescriptions($product_id)));			
			$data = array_merge($data, array('product_discount' => $this->getProductDiscounts($product_id)));
			$data = array_merge($data, array('product_filter' => $this->getProductFilters($product_id)));
			$data = array_merge($data, array('product_image' => $this->getProductImages($product_id)));		
			$data = array_merge($data, array('product_option' => $this->getProductOptions($product_id)));
			$data = array_merge($data, array('product_related' => $this->getProductRelated($product_id)));
			$data = array_merge($data, array('product_reward' => $this->getProductRewards($product_id)));
			$data = array_merge($data, array('product_special' => $this->getProductSpecials($product_id)));
			$data = array_merge($data, array('product_category' => $this->getProductCategories($product_id)));
			$data = array_merge($data, array('product_download' => $this->getProductDownloads($product_id)));
			$data = array_merge($data, array('product_layout' => $this->getProductLayouts($product_id)));
			$data = array_merge($data, array('product_store' => $this->getProductStores($product_id)));
			$data = array_merge($data, array('product_profiles' => $this->getProfiles($product_id)));
			$this->addProduct($data);
		}
	}
*/	
	public function deleteEvent($event_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "event WHERE id = '" . (int) $event_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "event_description WHERE event_id = '" . (int) $event_id . "'");
		//$this->db->query("DELETE FROM " . DB_PREFIX . "event_to_event_category WHERE event_id = '" . (int) $event_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'event_id=" . (int)$event_id . "'");
		
		$this->cache->delete('event');
	}
	
	public function getEvent($event_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT ua.keyword FROM " . DB_PREFIX . "url_alias ua WHERE ua.query = 'event_id=" . $event_id . "') AS keyword FROM " . DB_PREFIX . "event n LEFT JOIN " . DB_PREFIX . "event_description nd ON (n.id = nd.event_id) WHERE n.id = '" . (int)$event_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
		return $query->row;
	}
	
	public function getEvents($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "event n LEFT JOIN " . DB_PREFIX . "event_description nd ON (n.id = nd.event_id)";
		
		/*if (!empty($data['filter_event_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "event_to_event_category n2nc ON (n.id = n2nc.event_id)";			
		}*/
				
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
	public function getProductsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");
								  
		return $query->rows;
	} 
*/	
	public function getEventDescriptions($event_id) {
		$event_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "event_description WHERE event_id = '" . (int)$event_id . "'");
		
		foreach ($query->rows as $result) {
			$event_description_data[$result['language_id']] = array(
				'title'             => $result['title'],
				'content'      => $result['content'],
			);
		}
		
		return $event_description_data;
	}
		
	/*public function getEventCategories($event_id) {
		$event_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "event_to_event_category WHERE event_id = '" . (int)$event_id . "'");
		
		foreach ($query->rows as $result) {
			$event_category_data[] = $result['event_category_id'];
		}

		return $event_category_data;
	}*/

	public function getTotalEvents($data = array()) {
		$sql = "SELECT COUNT(DISTINCT n.id) AS total FROM " . DB_PREFIX . "event n LEFT JOIN " . DB_PREFIX . "event_description nd ON (n.id = nd.event_id)";

		/*if (!empty($data['filter_event_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "event_to_event_category n2nc ON (n.id = n2nc.event_id)";			
		}*/
		 
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
