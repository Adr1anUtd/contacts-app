<?php

require "database.php";

session_start();

if(!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id AND user_id= :user_id");
$statement->execute([
  ":id"=> $id,
  ":user_id"=> $_SESSION["user"]["id"],
]);
$contact = $statement->fetch(PDO::FETCH_ASSOC);
$_SESSION["contact"]["id"] = $contact["id"];

if($statement->rowCount() == 0){
    header("Location: home.php");
    return;
}


$addressesStatement = $conn->prepare("SELECT * FROM addresses WHERE contact_id = :contact_id");
$addressesStatement -> execute([
  ":contact_id"=> $contact["id"],
]);
$addresses = $addressesStatement;

?>

<?php require "partials/header.php" ?>


<div class="container pt-4 p-3">
  <div class="row">
    
    <?php if ($addresses->rowCount() == 0): ?>
      <div class="col-md-4 mx-auto">
        <div class="card card-body text-center">
          <p>No addresses saved for this contact yet</p>
          <a href="newAddress.php"> Add Address!</a>
        </div>
      </div>
    <?php else: ?>
    <a href="newAddress.php?id=<?= $_SESSION["user"]["id"] ?>" class="btn btn-info mb-2">Add new address</a>
    <?php foreach ($addresses as $address): ?>
      <div class="col-md-4 mb-3">
        <div class="card text-center">
          <div class="card-body">
            <h3 class="card-title text-capitalize">Address</h3>
            <p class="m-2"><?= $address["country"] ?></p>
            <p class="m-2"><?= $address["city"] ?></p>
            <p class="m-2"><?= $address["street"] ?></p>
            <p class="m-2"><?= $address["zipcode"] ?></p>
            <a href="editAddress.php?id=<?= $address["id"] ?>" class="btn btn-secondary mb-2">Edit Address</a>
            <a href="deleteAddress.php?id=<?= $address["id"] ?>" class="btn btn-danger mb-2">Delete Address</a>
          </div>
        </div>
      </div>
    <?php endforeach ?>
    <?php endif ?>

  </div>
</div>

<?php require "partials/footer.php" ?>