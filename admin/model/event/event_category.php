<?php
class ModelEventEventCategory extends Model {
	public function addEventCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "event_category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$event_category_id = $this->db->getLastId();
		
		foreach ($data['event_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "event_category_description SET event_category_id = '" . (int)$event_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
		
		$this->cache->delete('event_category');
	}
	
	public function editEventCategory($event_category_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "event_category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE id = '" . (int)$event_category_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "event_category_description WHERE event_category_id = '" . (int)$event_category_id . "'");

		foreach ($data['event_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "event_category_description SET event_category_id = '" . (int)$event_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
		
		$this->cache->delete('event_category');
	}
	
	public function deleteEventCategory($event_category_id) {
		$childern_ids = $this->db->query("SELECT id FROM " . DB_PREFIX . "event_category WHERE parent_id = '" . (int)$event_category_id . "'")->rows;
		foreach ($childern_ids as $childern) {
			$this->deleteEventCategory( $childern['id'] );
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "event_category WHERE id = '" . (int)$event_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "event_category_description WHERE event_category_id = '" . (int)$event_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "event_to_event_category WHERE event_category_id = '" . (int)$event_category_id . "'");
		
		$this->cache->delete('event_category');
	} 
/*	
	// Function to repair any erroneous categories that are not in the category path table.
	public function repairCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$parent_id . "'");
		
		foreach ($query->rows as $category) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category['category_id'] . "'");
			
			// Fix for records with no paths
			$level = 0;
			
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$parent_id . "' ORDER BY level ASC");
			
			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");
				
				$level++;
			}
			
			$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$category['category_id'] . "', level = '" . (int)$level . "'");
						
			$this->repairCategories($category['category_id']);
		}
	}
*/			
	public function getEventCategory($event_category_id) {
		$query = $this->db->query("SELECT DISTINCT nc.id AS event_category_id, nc.parent_id, nc.sort_order, nc.status, ncd.name FROM " . DB_PREFIX . "event_category nc LEFT JOIN " . DB_PREFIX . "event_category_description ncd ON (nc.id = ncd.event_category_id) WHERE nc.id = '" . (int)$event_category_id . "'");
		
		return $query->row;
	} 
	
	public function getEventCategories($data) {
		$sql = "SELECT nc.id AS event_category_id, ncd.name, nc.sort_order, nc.date_added, nc.date_modified, nc.status, nc.parent_id, ncd.language_id FROM " . DB_PREFIX . "event_category nc LEFT JOIN " . DB_PREFIX . "event_category_description ncd ON (nc.id = ncd.event_category_id) WHERE ncd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND ncd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " ORDER BY nc.sort_order";
		
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
				
	public function getEventCategoryDescriptions($event_category_id) {
		$event_category_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "event_category_description WHERE event_category_id = '" . (int)$event_category_id . "'");
		
		foreach ($query->rows as $result) {
			$event_category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
			);
		}
		
		return $event_category_description_data;
	}	
/*	
	public function getCategoryFilters($category_id) {
		$category_filter_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");
		
		foreach ($query->rows as $result) {
			$category_filter_data[] = $result['filter_id'];
		}

		return $category_filter_data;
	}

	
	public function getCategoryStores($category_id) {
		$category_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_store_data[] = $result['store_id'];
		}
		
		return $category_store_data;
	}

	public function getCategoryLayouts($category_id) {
		$category_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");
		
		foreach ($query->rows as $result) {
			$category_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $category_layout_data;
	}
*/		
	public function getTotalEventCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "event_category");
		
		return $query->row['total'];
	}	
/*
	public function getTotalCategoriesByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category WHERE image_id = '" . (int)$image_id . "'");
		
		return $query->row['total'];
	}

	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}*/	
}
?>