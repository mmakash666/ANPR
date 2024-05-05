<?php


include ('connection.php');

if(isset($_POST["sub"])) {
    
    $license_plate = $_POST['license_plate'];

    
    $sql = "SELECT * FROM carowner WHERE BINARY licence = '$license_plate'";
   
    
    $result = $conn->query($sql);
    

    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Displaying information from the database
            echo "NID: " . $row["nid"] . "<br>";
            echo "Car Owner Name: " . $row["username"] . "<br>";
            echo "Amount: " . $row["amount"] . "<br>";
    
            // Setting a variable for the amount to be deducted
            $var = 50;
            echo "Amount deducted: $var<br>";
    
            // Calculating the amount after deduction
            $after_deduct = $row["amount"] - $var;
            echo "Amount after deduction: $after_deduct<br>";


             //error handling of amount

             
            

             




            
            // Update the 'after_deduct' value in the database table
            $licence_plate = $row["licence"];
            $sql_update = "UPDATE carowner SET amount = $after_deduct WHERE BINARY licence = '$licence_plate'";

            if ($conn->query($sql_update) === TRUE) {
                echo "<br>";
            } else {
                echo "Error updating record: " . $conn->error . "<br>";
            }

          }


        
    }
    


}
?>
