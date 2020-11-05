<?php
/*
-----------------------------------------------------------------------------------------------------
| ID (int, AI, primary key) | title (Varchar(64)) | url (Varchar(128)) | description (Varchar(128)) | 
-----------------------------------------------------------------------------------------------------

Request:
GET - http://studenter.miun.se/~maso1905/dt173g/rest/miun_courses/website.php
GET - http://studenter.miun.se/~maso1905/dt173g/rest/miun_courses/website.php?id=1
POST - http://studenter.miun.se/~maso1905/dt173g/rest/miun_courses/website.php '{"title": "A Title", "url": "http://websitelinkdotcom", "description": "A description."}'
PUT - http://studenter.miun.se/~maso1905/dt173g/rest/miun_courses/website.php?id=1 '{"title": "A Title", "url": "http://websitelinkdotcom", "description": "A description."}'
DELETE - http://studenter.miun.se/~maso1905/dt173g/rest/miun_courses/website.php?id=1
*/

require 'Database.php';
require 'classes/Websites.php';
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
// Create instance of Website-class for SQL commands with connection parameter
$web = new Websites($db);

switch ($method) {
    // Get posts
    case "GET":
        if(isset($id)){
            // Gets specific website if ID is requested
            $result = $web->readOne($id);
        }else {
            // Gets all websites from database
            $result = $web->read();
        }

        if(sizeof($result) > 0) {
            http_response_code(200);
        }else {
            http_response_code(404);
            $result = array("message" => "No websites found");
        }
        break;
    // Create new post
    case "POST":
        $data = json_decode(file_get_contents("php://input"));

        // Removes tags from input and sends to class properties
        $web->title = $data->title;
        $web->url = $data->url;
        $web->description = $data->description;

        // Creates new website-row in database, error message if creation failed
        if($web->create()) {
            http_response_code(201);
            $result = array("message" => "Website info created");
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
            $web->title = $data->title;
            $web->url = $data->url;
            $web->description = $data->description;

            // Updates website info
            if($web->update($id)) {
                http_response_code(200);
                $result = array("message" => "Website info updated");
            } else {
                http_response_code(503);
                $result = array("message" => "Website info update failed");
            }
        }
        break;
    // Delete post
    case "DELETE":
        if(!isset($id)) {
            http_response_code(510);
            $result = array("message" => "No ID was sent");
        }else {
            // Deletes website info with ID
            if($web->delete($id)) {
                http_response_code(200);
                $result = array("message" => "Website info deleted");
            } else {
            // Error if delete fails
                http_response_code(503);
                $result = array("message" => "Delete website info failed");
            }
        }
        break;
}

// Return data as JSON format
echo json_encode($result);

// Close database connection
$db = $database->close();
