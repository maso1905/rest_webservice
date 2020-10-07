

<?php

class Courses{

    // database connection and table name
    private $db;
    private $table = "courses";
  
    // object properties
    public $id;
    public $name;
    public $code;
    public $prog;
    public $syllabus;
    public $sql;
    public $result;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->db = $db;
    }
    
    // Read all courses
    public function read(){

        $this->sql = "SELECT * FROM $this->table";
        $this->result = $this->db->query($this->sql);
        $courses_arr = array();
        //Loop through result and stores in an array
        foreach($this->result->FetchAll() as $row) {
            
            extract($row);
            $course = array(
                'id' => $id,
                'name' => $name,
                'code' => $code,
                'prog' => $prog,
                'syllabus' => $syllabus
            );
            // Push every array to another array.
            array_push($courses_arr, $course);
        }
        return $courses_arr;
    }
    
    // Read one course from ID
    public function readOne($id){
        $id = intval($id);
        $this->sql = "SELECT * FROM $this->table WHERE id='$id'";
        $this->result = $this->db->query($this->sql);
        $courses_arr = array();
        //Loop through result and stores in an array
        foreach($this->result->FetchAll() as $row) {
            
            extract($row);
            $course = array(
                'id' => $id,
                'name' => $name,
                'code' => $code,
                'prog' => $prog,
                'syllabus' => $syllabus
            );
            // Push every array to another array.
            array_push($courses_arr, $course);
        }
        return $courses_arr;
    }

    // Create new course
    public function create(){ 
        $this->sql = "INSERT INTO $this->table(name, code, prog, syllabus)VALUES('$this->name', '$this->code', '$this->prog', '$this->syllabus')";
        return $this->db->query($this->sql);
    }
    
    // Update course
    public function update($id){
        $id = intval($id);
        $this->sql = "UPDATE $this->table SET name='$this->name', code='$this->code', prog='$this->prog', syllabus='$this->syllabus' WHERE id='$id'";
        return $this->result = $this->db->query($this->sql);
   }

    // Delete course
    public function delete($id){
        $id = intval($id);
        $this->sql = "DELETE FROM $this->table WHERE id='$id'";
        return $this->db->query($this->sql);
    }

}