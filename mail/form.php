<?php

require_once('../include/db.class.php');
include_once('../include/fxns.inc.php');

// MENSAJE SETTER

$data           = array();      // array to pass back data

if(isset($_POST['email']) && $_POST['email'] != "") {

    $db = new DBConnection();

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $query_rsCheckUser = "SELECT * FROM entries WHERE email = '" . strip_tags($email) . "'";

    $rsCheckUser = $db->sendQuery($query_rsCheckUser);
    $row_rsCheckUser = $db->fetchMysqlObject($rsCheckUser);
    $rsCheckUser_numRows = $db->numRows($rsCheckUser);


    if($rsCheckUser_numRows > 0) {

        $Result1 = false;

    } else {

        $insertUser = sprintf("INSERT INTO entries (name, phone, email) VALUES (%s, %s, %s)",
                             GetSQLValueString($name, "text"),
                             GetSQLValueString($phone, "text"),
                             GetSQLValueString($email, "text"));

        $Result1 = $db->sendQuery($insertUser);

    }


    if($Result1) {
        $data['success'] = true;
        echo json_encode($data);

    } else {
        $data['success'] = false;
        echo json_encode($data);

    }

} else {

    // ERROR
    $data['success'] = false;
    echo json_encode($data);

}
