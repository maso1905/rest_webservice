<?php
/*
-------------------------------------------------------------------------------------------------------------------
| ID (int, AI, primary key) | company (Varchar(64)) | title (Varchar(64)) | start (DATE(64)) | end (DATE(64)) |
-------------------------------------------------------------------------------------------------------------------

Request:
GET - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/work.php
GET - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/work.php?id=1
POST - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/work.php '{"company": "companyname", "title": "titlename", "start": "20000101", "end": "20000202"}'
PUT - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/work.php?id=1 '{"company": "companyname", "title": "titlename", "start": "20000101", "end": "20000202"}'
DELETE - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/work.php?id=1
*/


require 'Database.php';
require 'classes/Work.php';
// require 'errors.php';

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
// Create instance of Work-class for SQL commands with connection parameter
$wrk = new Work($db);


switch ($method) {
    // Get posts
    case "GET":
        if(isset($id)){
            // Gets specific course if ID is requested
            $result = $wrk->readOne($id);
        }else {
            // Gets all courses from database
            $result = $wrk->read();
        }

        if(sizeof($result) > 0) {
            http_response_code(200);
        }else {
            http_response_code(404);
            $result = array("message" => "No work found");
        }
        break;
    // Create new post
    case "POST":
        $data = json_decode(file_get_contents("php://input"));

        // Removes tags from input and sends to class properties
        $wrk->company = $data->company;
        $wrk->title = $data->title;
        $wrk->start = $data->start;
        $wrk->end = $data->end;

        // Creates new course-row in database, error message if creation failed
        if($wrk->create()) {
            http_response_code(201);
            $result = array("message" => "work created");
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
            $wrk->company = $data->company;
            $wrk->title = $data->title;
            $wrk->start = $data->start;
            $wrk->end = $data->end;  

            // Updates course
            if($wrk->update($id)) {
                http_response_code(200);
                $result = array("message" => "work updated");
            } else {
                http_response_code(503);
                $result = array("message" => "work update failed");
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
            if($wrk->delete($id)) {
                http_response_code(200);
                $result = array("message" => "work deleted");
            } else {
            // Error if delete fails
                http_response_code(503);
                $result = array("message" => "Delete work failed");
            }
        }
        break;
}

// Return data as JSON format
echo json_encode($result);

// Close database connection
$db = $database->close();
