<?php
require "database.php";

session_start();

if(!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}

$statement = $conn->query("SELECT * FROM contacts WHERE user_id= {$_SESSION["user"]["id"]}");
$contacts = $statement->fetch(PDO::FETCH_ASSOC);

if($statement->rowCount() == 0){
    header("Location: home.php");
    return;
}

$error = null;

if($_SERVER["REQUEST_METHOD"] == "POST"){
  if (empty($_POST["country"]) || empty($_POST["city"]) || empty($_POST["street"]) || empty($_POST["zipcode"])){
    $error = "Please fill all the fields";
  }else{
  $country= $_POST["country"];
  $city = $_POST["city"];
  $street = $_POST["street"];
  $zipCode = $_POST["zipcode"];

  $statement = $conn->prepare("INSERT INTO addresses(contact_id, country, city, street, zipcode) VALUES({$contacts["id"]}, :country, :city, :street, :zipCode)");
  $statement->bindParam(":country", $country);
  $statement->bindParam(":city", $city);
  $statement->bindParam(":street", $street);
  $statement->bindParam(":zipCode", $zipCode);
  $statement->execute();

  $_SESSION["flash"] = ["message" => "Address added."];

  header("Location: home.php");
  return;
  }
}

?>

<?php require "partials/header.php"?>

<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add New Address</div>
        <div class="card-body">
          <?php if ($error): ?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <form method="post" action="newAddress.php">
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