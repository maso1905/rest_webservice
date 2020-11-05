<?php

class Websites{

    // database connection and table name
    private $db;
    private $table = "website";
  
    // object properties
    public $id;
    public $title;
    public $url;
    public $description;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->db = $db;
    }
    
    // Read all websites
    public function read(){

        $this->sql = "SELECT * FROM $this->table";
        $this->result = $this->db->query($this->sql);
        $website_arr = array();
        //Loop through result and stores in an array
        foreach($this->result->FetchAll() as $row) {
            
            extract($row);
            $website = array(
                'id' => $id,
                'title' => $title,
                'url' => $url,
                'description' => $description
            );
            // Push every array to another array.
            array_push($website_arr, $website);
        }
        return $website_arr;
    }
    
    // Read one website from ID
    public function readOne($id){
        $id = intval($id);
        $this->sql = "SELECT * FROM $this->table WHERE id='$id'";
        $this->result = $this->db->query($this->sql);
        $website = array();
        //Loop through result and stores in an array
        foreach($this->result->FetchAll() as $row) {
            
            extract($row);
            $website = array(
                'id' => $id,
                'title' => $title,
                'url' => $url,
                'description' => $description
            );
            // Push every array to another array.
            array_push($website_arr, $website);
        }
        return $website_arr;
    }

    // Create new website
    public function create(){ 
        $this->sql = "INSERT INTO $this->table(title, url, description)VALUES('$this->title', '$this->url', '$this->description')";
        return $this->db->query($this->sql);
    }
    
    // Update website
    public function update($id){
        $id = intval($id);
        $this->sql = "UPDATE $this->table SET title='$this->title', url='$this->url', description='$this->description' WHERE id='$id'";
        return $this->result = $this->db->query($this->sql);
   }

    // Delete website
    public function delete($id){
        $id = intval($id);
        $this->sql = "DELETE FROM $this->table WHERE id='$id'";
        return $this->db->query($this->sql);
    }

}