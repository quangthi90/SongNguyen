<?php
class ModelFaqFaqCategory extends Model {
	public function addFaqCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "faq_category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$faq_category_id = $this->db->getLastId();
		
		foreach ($data['faq_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "faq_category_description SET faq_category_id = '" . (int)$faq_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
		
		$this->cache->delete('faq_category');
	}
	
	public function editFaqCategory($faq_category_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "faq_category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE id = '" . (int)$faq_category_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "faq_category_description WHERE faq_category_id = '" . (int)$faq_category_id . "'");

		foreach ($data['faq_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "faq_category_description SET faq_category_id = '" . (int)$faq_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
		
		$this->cache->delete('faq_category');
	}
	
	public function deleteFaqCategory($faq_category_id) {
		$childern_ids = $this->db->query("SELECT id FROM " . DB_PREFIX . "faq_category WHERE parent_id = '" . (int)$faq_category_id . "'")->rows;
		foreach ($childern_ids as $childern) {
			$this->deleteFaqCategory( $childern['id'] );
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "faq_category WHERE id = '" . (int)$faq_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "faq_category_description WHERE faq_category_id = '" . (int)$faq_category_id . "'");
		
		$faqs = $this->db->query("SELECT id FROM faq WHERE faq_category_id = '" . $faq_category_id . "'")->rows;
		foreach ($faqs as $faq) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "faq WHERE id = '" . (int)$faq['id'] . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "faq_description WHERE faq_id = '" . (int)$faq['id'] . "'");
		}
		
		$this->cache->delete('faq_category');
	} 
			
	public function getFaqCategory($faq_category_id) {
		$query = $this->db->query("SELECT DISTINCT nc.id AS faq_category_id, nc.parent_id, nc.sort_order, nc.status, ncd.name FROM " . DB_PREFIX . "faq_category nc LEFT JOIN " . DB_PREFIX . "faq_category_description ncd ON (nc.id = ncd.faq_category_id) WHERE ncd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND nc.id = '" . (int)$faq_category_id . "'");
		
		return $query->row;
	} 
	
	public function getFaqCategories($data) {
		$sql = "SELECT fc.id AS faq_category_id, fcd.name AS name, fc.sort_order, fc.date_added, fc.date_modified, fc.status, fc.parent_id, fcd.language_id, pfcd.name AS parent_name FROM " . DB_PREFIX . "faq_category fc LEFT JOIN " . DB_PREFIX . "faq_category_description fcd ON (fc.id = fcd.faq_category_id) LEFT JOIN " . DB_PREFIX . "faq_category pfc ON (fc.parent_id = pfc.id) LEFT JOIN " . DB_PREFIX . "faq_category_description pfcd ON (pfc.id = pfcd.faq_category_id) WHERE fcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND (pfcd.language_id = '" . (int)$this->config->get('config_language_id') . "' OR fc.parent_id = '0')";
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND fcd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " ORDER BY fc.sort_order";
		
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
				
	public function getFaqCategoryDescriptions($faq_category_id) {
		$faq_category_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faq_category_description WHERE faq_category_id = '" . (int)$faq_category_id . "'");
		
		foreach ($query->rows as $result) {
			$faq_category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
			);
		}
		
		return $faq_category_description_data;
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
	public function getTotalFaqCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "faq_category");
		
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