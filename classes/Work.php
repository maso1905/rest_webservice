
<?php

class Work{

    // database connection and table name
    private $db;
    private $table = "work";
  
    // object properties
    public $id;
    public $company;
    public $title;
    public $start;
    public $end;
    public $sql;
    public $result;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->db = $db;
    }
    
    // Read all work
    public function read(){

        $this->sql = "SELECT * FROM $this->table";
        $this->result = $this->db->query($this->sql);
        $work_arr = array();
        //Loop through result and stores in an array
        foreach($this->result->FetchAll() as $row) {
            
            extract($row);
            $work = array(
                'id' => $id,
                'company' => $company,
                'title' => $title,
                'start' => $start,
                'end' => $end
            );
            // Push every array to another array.
            array_push($work_arr, $work);
        }
        return $work_arr;
    }
    
    // Read one course from ID
    public function readOne($id){
        $id = intval($id);
        $this->sql = "SELECT * FROM $this->table WHERE id='$id'";
        $this->result = $this->db->query($this->sql);
        $work = array();
        //Loop through result and stores in an array
        foreach($this->result->FetchAll() as $row) {
            
            extract($row);
            $work = array(
                'id' => $id,
                'company' => $company,
                'title' => $title,
                'start' => $start,
                'end' => $end
            );
            // Push every array to another array.
            array_push($work_arr, $work);
        }
        return $work_arr;
    }

    // Create new course
    public function create(){ 
        $this->sql = "INSERT INTO $this->table(company, title, start, end)VALUES('$this->company', '$this->title', '$this->start', '$this->end')";
        return $this->db->query($this->sql);
    }
    
    // Update course
    public function update($id){
        $id = intval($id);
        $this->sql = "UPDATE $this->table SET company='$this->company', title='$this->title', start='$this->start', end='$this->end' WHERE id='$id'";
        return $this->result = $this->db->query($this->sql);
   }

    // Delete course
    public function delete($id){
        $id = intval($id);
        $this->sql = "DELETE FROM $this->table WHERE id='$id'";
        return $this->db->query($this->sql);
    }

}