<?php
/*
-------------------------------------------------------------------------------------------------------------------
| ID (int, AI, primary key) | school (Varchar(64)) | program (Varchar(64)) | start (DATE(64)) | end (DATE(64)) |
-------------------------------------------------------------------------------------------------------------------

Request:
GET - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/education.php
GET - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/education.php?id=1
POST - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/education.php '{"school": "schoolname", "program": "programname", "start": "2000-01-01", "end": "2000-02-02"}'
PUT - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/education.php?id=1 '{"school": "schoolname", "program": "programname", "start": "2000-01-01", "end": "2000-02-02"}'
DELETE - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/education.php?id=1
*/

require 'Database.php';
require 'classes/Educations.php';
require 'errors.php';

// Header information
header('Content-Type: application/json;');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, x-Requested-With');

$method = $_SERVER['REQUEST_METHOD'];
// If an ID is used in the URL
if(isset($_GET['id'])){
    $id = $_GET['id'];
}

// Connect to server
$database = new Database();
$db = $database->connect();
// Create instance of Education-class for SQL commands with connection parameter
$edu = new Educations($db);


switch ($method) {
    // Get posts
    case "GET":
        if(isset($id)){
            // Gets specific course if ID is requested
            $result = $edu->readOne($id);
        }else {
            // Gets all educations from database
            $result = $edu->read();
        }

        if(sizeof($result) > 0) {
            http_response_code(200);
        }else {
            http_response_code(404);
            $result = array("message" => "No education found");
        }
        break;
    // Create new post
    case "POST":
        $data = json_decode(file_get_contents("php://input"));

        // Removes tags from input and sends to class properties
        $edu->school = $data->school;
        $edu->program = $data->program;
        $edu->start = $data->start;
        $edu->end = $data->end;

        // Creates new course-row in database, error message if creation failed
        if($edu->create()) {
            http_response_code(201);
            $result = array("message" => "Education created");
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
            $edu->school = $data->school;
            $edu->program = $data->program;
            $edu->start = $data->start;
            $edu->end = $data->end;  

            // Updates education
            if($edu->update($id)) {
                http_response_code(200);
                $result = array("message" => "Education updated");
            } else {
                http_response_code(503);
                $result = array("message" => "Education update failed");
            }
        }
        break;
    // Delete post
    case "DELETE":
        if(!isset($id)) {
            http_response_code(510);
            $result = array("message" => "No ID was sent");
        }else {
            // Deletes education with ID
            if($edu->delete($id)) {
                http_response_code(200);
                $result = array("message" => "Education deleted");
            } else {
            // Error if delete fails
                http_response_code(503);
                $result = array("message" => "Delete education failed");
            }
        }
        break;
}

// Return data as JSON format
echo json_encode($result);

// Close database connection
$db = $database->close();
