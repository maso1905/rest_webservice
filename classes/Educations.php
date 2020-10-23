
<?php

class Educations{

    // database connection and table name
    private $db;
    private $table = "education";
  
    // object properties
    public $id;
    public $school;
    public $program;
    public $start;
    public $end;
    public $sql;
    public $result;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->db = $db;
    }
    
    // Read all education
    public function read(){

        $this->sql = "SELECT * FROM $this->table ORDER BY start DESC";
        $this->result = $this->db->query($this->sql);
        $education_arr = array();
        //Loop through result and stores in an array
        foreach($this->result->FetchAll() as $row) {
            
            extract($row);
            $education = array(
                'id' => $id,
                'school' => $school,
                'program' => $program,
                'start' => $start,
                'end' => $end
            );
            // Push every array to another array.
            array_push($education_arr, $education);
        }
        return $education_arr;
    }
    
    // Read one education from ID
    public function readOne($id){
        $id = intval($id);
        $this->sql = "SELECT * FROM $this->table WHERE id='$id'";
        $this->result = $this->db->query($this->sql);
        $education = array();
        //Loop through result and stores in an array
        foreach($this->result->FetchAll() as $row) {
            
            extract($row);
            $education = array(
                'id' => $id,
                'school' => $school,
                'program' => $program,
                'start' => $start,
                'end' => $end
            );
            // Push every array to another array.
            array_push($education_arr, $education);
        }
        return $education_arr;
    }

    // Create new education
    public function create(){ 
        $this->sql = "INSERT INTO $this->table(school, program, start, end)VALUES('$this->school', '$this->program', '$this->start', '$this->end')";
        return $this->db->query($this->sql);
    }
    
    // Update education
    public function update($id){
        $id = intval($id);
        $this->sql = "UPDATE $this->table SET school='$this->school', program='$this->program', start='$this->start', end='$this->end' WHERE id='$id'";
        return $this->result = $this->db->query($this->sql);
   }

    // Delete education
    public function delete($id){
        $id = intval($id);
        $this->sql = "DELETE FROM $this->table WHERE id='$id'";
        return $this->db->query($this->sql);
    }

}