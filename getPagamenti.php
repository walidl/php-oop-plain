<?php

  class Pagamento {

    public $id;
    public $price;
    public $status;

    function __construct($id,$price,$status){

      $this->id = $id;
      $this->price = $price;
      $this->status = $status;

    }

    function printMe(){

      echo $this->id . ": " .
           $this->price . " $ <br>";
    }
  }

  // Chiamata SQL --------------------

  $servername = "localhost";
  $username = "root";
  $password = "taichow";
  $dbname = "prova1";

  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection - controlla la connessione
  if ($conn->connect_errno) {
    echo ("Connection failed: " . $conn->connect_error);
    return;
  }

  $sql = "
          SELECT id, price, status
          FROM pagamenti
  ";

  $result = $conn->query($sql);

  $pendingPay=[];
  $rejectedPay=[];
  $acceptedPay=[];

  if ($result->num_rows > 0) {

    // output data of each row
    while($row = $result->fetch_assoc()) {
      // var_dump($row); echo "<br>" ;

      $payment = new Pagamento(
                              $row["id"],
                              $row["price"],
                              $row["status"]
      );

      switch ( $payment->status  /*$row["status"]*/) {

        case 'pending':
          $pendingPay[] = $payment;
        break;

        case 'rejected':
          $rejectedPay[] = $payment;
        break;

        case 'accepted':
          $acceptedPay[] = $payment;
        break;
      }

    }
  } else {
    echo "0 results";
  }

  $conn->close();

  // Print Arrays ----------------------------

  function printArrays($title,$array){

    echo "<b> $title </b><br><br>";

    foreach ($array as $object) {

      $object-> printMe();
    }

    echo "<br><hr>";
  }

  printArrays("Pending Payments:",$pendingPay);
  printArrays("Rejected Payments:",$rejectedPay);
  printArrays("Accepted Payments:",$acceptedPay);

 ?>
