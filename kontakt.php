<?php
if (isset($_POST['Email'])) {

    // EDIT THE FOLLOWING TWO LINES:
    $email_to = "info@bonsai-club-hagen.de";
    $email_subject = "Neue Nachricht";

    function problem($error)
    {
        echo "Bitte entschuldigen Sie. Es sind leider Fehler aufgetreten";
        echo "Folgende Fehler sind aufgetreten.<br><br>";
        echo $error . "<br><br>";
        echo "Bitte versuchen Sie, die Fehler zu beheben oder melden Sie diese beim Bonsai Club Hagen.<br><br>";
        die();
    }

    // validation expected data exists
    if (
        !isset($_POST['Name']) ||
        !isset($_POST['Email']) ||
        !isset($_POST['Message'])
    ) {
        problem('Oje, es sieht aus, als wäre ein Fehler aufgetreten.');
    }

    $name = $_POST['Name']; // required
    $email = $_POST['Email']; // required
    $message = $_POST['Message']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= 'Die eingegebene Mailadresse scheint unplausibel zu sein.<br>';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $name)) {
        $error_message .= 'Ihr Name scheint nicht plausibel zu sein.<br>';
    }

    if (strlen($message) < 2) {
        $error_message .= 'Ihre Nachricht ist so kurz, dass wir denken, dass Sie noch nicht fertig sind.<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }

    $email_message = "Details:.\n\n";

    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "Name: " . clean_string($name) . "\n";
    $email_message .= "Email: " . clean_string($email) . "\n";
    $email_message .= "Nachricht: " . clean_string($message) . "\n";

    // create email headers
    $headers = 'From: ' . $email . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);
?>

    <!-- INCLUDE YOUR SUCCESS MESSAGE BELOW -->

    Vielen Dank für Ihre Nachricht. Wir werden uns zeitnah mit Ihnen in Verbindung setzen.

<?php
}
?>
