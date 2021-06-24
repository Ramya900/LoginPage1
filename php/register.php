<?php
session_start();

$data_res = 0;

$db_conn = parse_ini_file("PHPDBConnect.ini");
$mysql_conn = new mysqli($db_conn['host'], $db_conn['username'], $db_conn['password'], $db_conn['instance']);

if ($mysql_conn->connect_error) {
    die("FATAL ERROR: Unable to create a connection to the database");
}

$fetch_user_details_query = $mysql_conn->prepare("
    INSERT INTO user(user_email, user_password)
    VALUES (?, ?)
");

$fetch_user_details_query->bind_param(
    "ss", 
    $_POST['email'], $_POST['password']
);

$fetch_user_details_query->execute();

$fetch_user_details_query->store_result();

if ($fetch_user_details_query->num_rows <= 0) {
    $data_res = 1;
} 
else {
    $data_res = 0;
}


$fetch_user_details_query->close();

$mysql_conn->close();

echo $data_res;

//echo json_encode($result_arr);

?>