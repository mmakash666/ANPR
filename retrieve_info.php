<?php


include ('connection.php');

if(isset($_POST["sub"])) {
    
    $license_plate = $_POST['license_plate'];

    
    $sql = "SELECT * FROM carowner WHERE BINARY licence = '$license_plate'";
   
    
    $result = $conn->query($sql);
    

    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {


            $mail_sentTo = $row["email"];
            $user_name = $row["username"];
            
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


             //error handling of amount i will do this later

             
            

             




            
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








// using mail service to notify the user about the collected toll


// Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Path to PHPMailer autoload.php file

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = ''; // email address
    $mail->Password = ''; // Gmail password generated on the google account app password section
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Recipients
    
    $mail->setFrom('', '');
    $mail->addAddress($mail_sentTo);

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Toll plaza';
    $mail->Body = "<p> 

    Dear $user_name
    
    We hope this message finds you well.
    
    'We are writing to inform you about a recent toll deduction from your account associated with license plate number  $license_plate The deducted amount from your wallet was $var
    
    Your current wallet balance is $after_deduct Please note that this balance reflects the remaining amount after the recent toll deduction.
    
    If you have any questions or concerns regarding this deduction or your wallet balance, please dont hesitate to contact us mmakash666@gmail.com.
    
    Thank you for your attention to this matter.
    
     Best regards,
     
     Director of Toll plaza
    
    </p>";

    // Send email
    $mail->send();
    echo 'Email has been sent successfully!';
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}






?>
