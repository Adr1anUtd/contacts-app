<?php

require "database.php";

session_start();

if(!isset($_SESSION["user"])){
  header("Location: login.php");
}

$error = null;

$id = $_GET["id"];
$addresses = $conn->prepare("SELECT * FROM addresses WHERE id=:id");
$addresses->execute([
  ":id"=> $id,
]);
$address = $addresses->fetch(PDO::FETCH_ASSOC);


if($_SERVER["REQUEST_METHOD"] == "POST"){
  $statement = $conn->prepare("UPDATE addresses SET country=:country, city=:city, street=:street,
  zipcode=:zipcode WHERE id = :id");
  $statement->execute([
  ":country" => $_POST["country"],
  ":city" => $_POST["city"],
  ":street" => $_POST["street"],
  ":zipcode" => $_POST["zipcode"],
  ":id" => $address["id"],
]);
header("Location: addresses.php?id=". $_SESSION["contact"]["id"]);
return;
}


?>

<?php require "partials/header.php"?>

<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Edit Address</div>
        <div class="card-body">
          <?php if ($error): ?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <form method="post" action="editAddress.php?id= <?= $address["id"] ?>">
            <div class="mb-3 row">
              <label for="country" class="col-md-4 col-form-label text-md-end">Country</label>

              <div class="col-md-6">
                <input id="country" type="text" class="form-control" name="country" autocomplete="country" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="city" class="col-md-4 col-form-label text-md-end">City</label>

              <div class="col-md-6">
                <input id="city" type="text" class="form-control" name="city" autocomplete="city" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="street" class="col-md-4 col-form-label text-md-end">Street</label>

              <div class="col-md-6">
                <input id="street" type="text" class="form-control" name="street" autocomplete="street" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="city" class="col-md-4 col-form-label text-md-end">Zip Code</label>

              <div class="col-md-6">
                <input id="zipcode" type="text" class="form-control" name="zipcode" autocomplete="zipcode" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require "partials/footer.php" ?>