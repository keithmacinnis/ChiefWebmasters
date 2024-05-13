<?php
require 'vendor/autoload.php';
$error_output = '';
$success_output = '';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
// Build POST request to get the reCAPTCHA v3 score from Google
$recaptcha_url = $_ENV['RECAPTCHA_URL'];
$recaptcha_secret = $_ENV['RECAPTCHA_SECRET'];
$recaptcha_response = $_POST['recaptcha_response'];
$to_email = $_ENV['TO_EMAIL'];

// Make and decode POST request

$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
$recaptcha = json_decode($recaptcha);

// Take action based on the score returned
if ($recaptcha->success == true && $recaptcha->score >= 0.5 && $recaptcha->action == 'contact') {
    // This is a human, send email
      $name;$email;$comment;
      $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
      $visitor_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
      $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
      $email_from = $to_email;
      $email_subject = "New Form submission";
      $email_body = "You have received a new message from the user $name ($visitor_email) via chief webmasters website with a score of $recaptcha->score.\n\n".
          "Here is the message:\n\n $message \n\n".
      $to = $to_email;
      $headers = "From: $email_from \r\n";
      $headers .= "Reply-To: $visitor_email \r\n";
      mail($to,$email_subject,$email_body,$headers);
    $success_output = "Your message sent successfully";
} else {
    // Score less than 0.5 indicates suspicious activity. Return an error
    $error_output = "Something went wrong. Please try again later";
}

$output = array(
    'error'     =>  $error_output,
    'success'   =>  $success_output
);

// Output needs to be in JSON format
echo json_encode($output);

?>