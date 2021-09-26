<?php
function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);

    return $value;
}

function check_length($value = "", $min, $max) {
    $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
    return !$result;
}

function isValid() {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $subject = $_POST['subject'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];

        $name = clean($name);
        $subject = clean($subject);
        $email = clean($email);
        $phone = clean($phone);
        $message = clean($message);

        if(!empty($name) && !empty($subject) && !empty($email) && !empty($phone) && !empty($message)) {
            $email_validate = filter_var($email, FILTER_VALIDATE_EMAIL);

            if(check_length($name, 2, 25) &&  check_length($subject, 2, 50) &&  check_length($phone, 5, 15) &&  check_length($message, 2, 1000) && $email_validate) {

                $email_message = "

				Name: ".$name."
				Subject: ".$subject."
				Email: ".$email."
				Phone: ".$phone."
				Message: ".$message."

			";

                mail ("YOUR_EMAIL" , "New Message", $email_message);

                return true;
            } else {
                //echo "Введено невірні дані";
                return false;
            }
        } else {
            //echo "Заповніть порожні поля";
            return false;
        }
    } else {
        header("Location: /");
    }
}

$error_output = '';
$success_output = '';

if(isValid()) {
    // Build POST request to get the reCAPTCHA v3 score from Google
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = 'YOUR_recaptcha3_SECRET_KEY'; // Insert your secret key here
    $recaptcha_response = $_POST['recaptcha_response'];

    // Make the POST request
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);

    $recaptcha = json_decode($recaptcha);
    // Take action based on the score returned
    if ($recaptcha->success == true && $recaptcha->score >= 0.5 && $recaptcha->action == 'sendform') {
        // This is a human. Insert the message into database OR send a mail
        $success_output = "Дякуємо за повідомлення";
    } else {
        // Score less than 0.5 indicates suspicious activity. Return an error
        $error_output = "Щось зламалось, спробуйте пізніше";
    }
    //$success_output = "Your message sent successfully";
} else {
    // Server side validation failed
    $error_output = "Будь ласка, заповніть всі поля";
}

$output = array(
    'error'     =>  $error_output,
    'success'   =>  $success_output
);

// Output needs to be in JSON format
echo json_encode($output);
