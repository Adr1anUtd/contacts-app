<?php

require "database.php";

session_start();

if(!isset($_SESSION["user"])){
    header("Location: login.php");
    return;
}

$id = $_GET["id"];
$statement = $conn->prepare("SELECT * FROM addresses WHERE id = :id LIMIT 1");
$statement->execute([
    ":id"=> $id,
]);
$address = $statement -> fetch(PDO::FETCH_ASSOC);

if($address["contact_id"] !== $_SESSION["contact"]["id"]){
    http_response_code(404);
    echo("404 NOT FOUND");
    return;
}

$statement = $conn->prepare("DELETE FROM addresses WHERE id=:id");
$statement->execute([":id" => $id]);
header("Location: addresses.php?id=". $_SESSION["contact"]["id"]);
return

?>