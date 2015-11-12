<?php
    class Platters_model extends CI_Model {
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
            if($form == "short") $this->db->select("platters.ID, platters.Name, Image, CategoryID, Price, Quantity, Price2, Quantity2, Price3, Quantity3, Description");
            else $this->db->select("platters.*");
            
            $this->db->select("platters_categories.Name AS CategoryName");
            if( !empty($id) ) {
                $id = (int) $id; 
                $this->db->where("platters.ID",$id);
            } 
            if($category != null) $this->db->where('category', $category);
            $this->db->join("platters_categories",'platters.CategoryID = platters_categories.ID');
            $this->db->order_by("platters.Name", "asc");  
            $this->db->where('platters.Status','enabled');
            
            $sql = $this->db->get('platters')->result_object();
            $sql = $this->map_platters($sql);

            if($sql) return $sql;  
        }
        
        /**
        * Selects $limit number of random platters from the database
        * 
        * @param mixed $id
        * @param mixed $limit
        */
        public function get_recommended($id = null, $limit = 4) {
            $this->db->select("platters.*"); 
            $this->db->order_by("RAND()");  
            $this->db->where('platters.Status','enabled');
            
            if(!empty($id)) $this->db->where_not_in('platters.ID', array($id));
            $sql = $this->db->get('platters',$limit,0)->result_object();
            $sql = $this->map_platters($sql);

            if($sql) return $sql; 
        }
        
        /**
        * Map platters - currently changing array keys to match IDs
        * 
        * @param mixed $array
        */
        private function map_platters($array) {
            $new = new stdClass();
            foreach($array AS $item) {
                $item->seotitle = url_title($item->Name);
                $new->{$item->ID} = $item;
            }
            return $new;
        }
        
        
        /**
        * Return Recipe Categories
        * 
        */
        public function get_categories() {
            $sql = $this->db->query("SELECT * FROM platters_categories ORDER BY Name asc");
            $results = $sql->result_object();
            return $results;
        }
    }
?>
