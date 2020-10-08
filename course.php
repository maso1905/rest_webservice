<?php
/*
-------------------------------------------------------------------------------------------------------------------
| ID (int, AI, primary key) | name (Varchar(64)) | code (Varchar(64)) | prog (Char(1)) | syllabus (Varchar(2083)) |
-------------------------------------------------------------------------------------------------------------------

Request:
GET - http://studenter.miun.se/~maso1905/dt173g/rest/miun_courses/course.php
GET - http://studenter.miun.se/~maso1905/dt173g/rest/miun_courses/course.php?id=1
POST - http://studenter.miun.se/~maso1905/dt173g/rest/miun_courses/course.php '{"name": "coursename", "code": "coursecode", "prog": "A", "syllabus": "http link"}'
PUT - http://studenter.miun.se/~maso1905/dt173g/rest/miun_courses/course.php?id=1 '{"name": "coursename", "code": "coursecode", "prog": "A", "syllabus": "http link"}'
DELETE - http://studenter.miun.se/~maso1905/dt173g/rest/miun_courses/course.php?id=1
*/


require 'Database.php';
require 'classes/Courses.php';
// require 'errors.php';

// Header information
header('Content-Type: application/json;');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, x-Requested-With');

$method = $_SERVER['REQUEST_METHOD'];
// Om en parameter av id finns i urlen
if(isset($_GET['id'])){
    $id = $_GET['id'];
}

// Connect to server
$database = new Database();
$db = $database->connect();
// Create instance of Course-class for SQL commands with connection parameter
$course = new Courses($db);


switch ($method) {
    // Get posts
    case "GET":
        if(isset($id)){
            // Gets specific course if ID is requested
            $result = $course->readOne($id);
        }else {
            // Gets all courses from database
            $result = $course->read();
        }

        if(sizeof($result) > 0) {
            http_response_code(200);
        }else {
            http_response_code(404);
            $result = array("message" => "No courses found");
        }
        break;
    // Create new post
    case "POST":
        $data = json_decode(file_get_contents("php://input"));

        // Removes tags from input and sends to class properties
        $course->name = $data->name;
        $course->code = $data->code;
        $course->prog = $data->prog;
        $course->syllabus = $data->syllabus;

        // Creates new course-row in database, error message if creation failed
        if($course->create()) {
            http_response_code(201);
            $result = array("message" => "Course created");
        } else {
            http_response_code(503);
            $result = array("message" => "Creation failed");
        }
        break;
    // Update post
    case "PUT":
        if(!isset($id)){
            http_response_code(510);
            $result = array("message" => "No ID was sent");
        } else {
            $data = json_decode(file_get_contents("php://input"));
            
            // Removes tags from input and sends to class properties
            $course->name = $data->name;
            $course->code = $data->code;
            $course->prog = $data->prog;
            $course->syllabus = $data->syllabus;    

            // Updates course
            if($course->update($id)) {
                http_response_code(200);
                $result = array("message" => "Course updated");
            } else {
                http_response_code(503);
                $result = array("message" => "Course update failed");
            }
        }
        break;
    // Delete post
    case "DELETE":
        if(!isset($id)) {
            http_response_code(510);
            $result = array("message" => "No ID was sent");
        }else {
            // Deletes course with ID
            if($course->delete($id)) {
                http_response_code(200);
                $result = array("message" => "Course deleted");
            } else {
            // Error if delete fails
                http_response_code(503);
                $result = array("message" => "Delete course failed");
            }
        }
        break;
}

// Return data as JSON format
echo json_encode($result);

// Close database connection
$db = $database->close();
