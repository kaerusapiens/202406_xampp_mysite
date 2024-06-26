<?php
class PasswordValidator {
    private static $frontText = "Passwordには少なくとも";
    private static $more_endText = "以上にしてください。";
    private static $less_endText = "以下にしてください。";
    private static $minLengthMessage =  self::$frontText . "%d文字" . self::$less_endText;
    private static $uppercaseMessage = self::$frontText . "1つの大文字" . self::$more_endText;
    private static $lowercaseMessage = self::$frontText . "1つの小文字" . self::$more_endText;
    private static $digitMessage = self::$frontText . "1つの数字" . self::$more_endText;
    private static $specialCharMessage = self::$frontText . "1つの特殊文字" . self::$more_endText;

    public static function validate($password) {
        // Check if password length is at least 8 characters
        if (strlen($password) > 8) {
            echo sprintf(self::$minLengthMessage, 8);
            return false;
        }

        // Check if password contains at least one uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            echo self::$uppercaseMessage;
            return false;
        }

        // Check if password contains at least one lowercase letter
        if (!preg_match('/[a-z]/', $password)) {
            echo self::$lowercaseMessage;
            return false;
        }

        // Check if password contains at least one digit
        if (!preg_match('/[0-9]/', $password)) {
            echo self::$digitMessage;
            return false;
        }

        // Check if password contains at least one special character
        if (!preg_match('/[!@#\^&*,.?]/', $password)) {  // Updated regex to include valid special characters
            echo self::$specialCharMessage;
            return false;
        }


        return true;
    }
}
?>