<?php 
// Load the database configuration file 
include 'dbConfig.php'; 
 
// Retrieve POST data and convert JSON to PHP array 
$userData = json_decode($_POST['userData']); 
 
if(!empty($userData)){ 
    $oauth_provider = $_POST['oauth_provider']; 
    $link = !empty($userData->link)?$userData->link:''; 
    $gender = !empty($userData->gender)?$userData->gender:''; 
     
    // Check whether user data already exists in database 
    $prevQuery = "SELECT id FROM users WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$userData->id."'"; 
 
    $prevResult = $db->query($prevQuery); 
    if($prevResult->num_rows > 0){  
        // Update user data if already exists 
        $query = "UPDATE users SET first_name = '".$userData->first_name."', last_name = '".$userData->last_name."', email = '".$userData->email."', gender = '".$gender."', picture = '".$userData->picture->data->url."', link = '".$link."', modified = NOW() WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$userData->id."'"; 
        $update = $db->query($query); 
    }else{ 
        // Insert user data 
        $query = "INSERT INTO users SET oauth_provider = '".$oauth_provider."', oauth_uid = '".$userData->id."', first_name = '".$userData->first_name."', last_name = '".$userData->last_name."', email = '".$userData->email."', gender = '".$gender."', picture = '".$userData->picture->data->url."', link = '".$link."', created = NOW(), modified = NOW()"; 
        $insert = $db->query($query); 
    } 
}
