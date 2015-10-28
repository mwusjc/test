<?php
    class Products_model extends CI_Model {
        public function construct() {
            parent::__construct();
        }
        
        /**
        * Get Recipes (all or singular)
        * 
        * @param mixed $id
        * @param mixed $category - category id, null for all
        * @param mixed $form - short/long (Name,id,image) vs (All details)
        */
        public function get($id = null, $category = null, $form = "short") {
            if($form == "short") $this->db->select("products.id, products.name, products.image, category, description");
            else $this->db->select("products.*");
            
            $this->db->select("products_categories.name AS CategoryName");
            if( !empty($id) ) {
                $id = (int) $id; 
                $this->db->where("products.id",$id);
            } 
            if($category != null) $this->db->where('category', $category);
            $this->db->join("products_categories",'products.category = products_categories.id');
            $this->db->order_by("products.name", "asc");  
            
            $sql = $this->db->get('products')->result_object();
            $sql = $this->map_products($sql);

            if($sql) return $sql;  
        }

        
        /**
        * Map products - currently changing array keys to match IDs
        * 
        * @param mixed $array
        */
        private function map_products($array) {
            $new = new stdClass();
            foreach($array AS $item) {
                $item->seotitle = url_title($item->name);
                $new->{$item->id} = $item;
            }
            return $new;
        }
        
        
        /**
        * Return Recipe Categories
        * 
        */
        public function get_categories() {
            $sql = $this->db->query("SELECT * FROM products_categories ORDER BY name asc");
            $results = $sql->result_object();
            return $results;
        }
    }
?>
