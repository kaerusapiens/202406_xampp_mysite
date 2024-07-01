<?php

class PasswordValidator {
    private static $frontText = "Passwordには少なくとも";
    private static $more_endText = "以上にしてください。";
    private static $less_endText = "以下にしてください。";
    private static $minLengthMessage;
    private static $uppercaseMessage;
    private static $lowercaseMessage;
    private static $digitMessage;
    private static $specialCharMessage;

    // Static initializer to set the messages
    private static function initializeMessages() {
        if (self::$minLengthMessage === null) { // Check if already initialized
            self::$minLengthMessage = self::$frontText . "%d文字" . self::$less_endText;
            self::$uppercaseMessage = self::$frontText . "1つの大文字" . self::$more_endText;
            self::$lowercaseMessage = self::$frontText . "1つの小文字" . self::$more_endText;
            self::$digitMessage = self::$frontText . "1つの数字" . self::$more_endText;
            self::$specialCharMessage = self::$frontText . "1つの特殊文字" . self::$more_endText;
        }
    }

    public static function validate($password) {
        self::initializeMessages();

        // Check if password length is at least 8 characters
        if (strlen($password) < 8) {
            return sprintf(self::$minLengthMessage, 8);
        }
        

        // Check if password contains at least one uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            return self::$uppercaseMessage;
        }

        // Check if password contains at least one lowercase letter
        if (!preg_match('/[a-z]/', $password)) {
            return self::$lowercaseMessage;
        }

        // Check if password contains at least one digit
        if (!preg_match('/[0-9]/', $password)) {
            return self::$digitMessage;
        }

        // Check if password contains at least one special character
        if (!preg_match('/[!@#\^&*,.?]/', $password)) {  // Updated regex to include valid special characters
            return self::$specialCharMessage;
        }

        return true; // Password is valid
    }
}
?>
