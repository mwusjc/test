<?php
    class Recipes_model extends CI_Model {
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
            if($form == "short") $this->db->select("recipes.ID, recipes.Name, Image, CategoryID");
            else $this->db->select("recipes.*");
            
            $this->db->select("recipes_categories.Name AS CategoryName");
            if( !empty($id) ) {
                $id = (int) $id; 
                $this->db->where("recipes.ID",$id);
            } 
            if($category != null) $this->db->where('category', $category);
            $this->db->join("recipes_categories",'recipes.CategoryID = recipes_categories.ID');
            $this->db->order_by("recipes.Name", "asc");  
            $this->db->where('recipes.Status','enabled');
            
            $sql = $this->db->get('recipes')->result_object();
            $sql = $this->map_recipes($sql);

            if($sql) return $sql;  
        }
        
        /**
        * Selects $limit number of random recipes from the database
        * 
        * @param mixed $id
        * @param mixed $limit
        */
        public function get_recommended($id = null, $limit = 4) {
            $this->db->select("recipes.*"); 
            $this->db->order_by("RAND()");  
            $this->db->where('recipes.Status','enabled');
            
            if(!empty($id)) $this->db->where_not_in('recipes.ID', array($id));
            $sql = $this->db->get('recipes',$limit,0)->result_object();
            $sql = $this->map_recipes($sql);

            if($sql) return $sql; 
        }
        
        /**
        * Map recipes - currently changing array keys to match IDs
        * 
        * @param mixed $array
        */
        private function map_recipes($array) {
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
            $sql = $this->db->query("SELECT * FROM recipes_categories ORDER BY Name asc");
            $results = $sql->result_object();
            return $results;
        }
    }
?>
