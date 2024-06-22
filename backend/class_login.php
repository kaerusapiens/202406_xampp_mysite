<?php


class Validator {
    public static function validate($input, $minLength, $maxLength, $type) {
        // Validation
        $pattern = '/^[a-zA-Z0-9]+$/';
        $lengthErrorMsg = $type . "は5文字以上10以下である必要があります";
        $charsetErrorMsg =  $type . "には英数字のみが使用できます";

        $lengthValid = (strlen($input) >= $minLength && strlen($input) <= $maxLength);
        $charsetValid = preg_match($pattern, $input);

        if (!$lengthValid && !$charsetValid) {
            echo $lengthErrorMsg . "<br>" . $charsetErrorMsg;
            exit; // Stop process
        } elseif (!$lengthValid) {
            echo $lengthErrorMsg;
            exit; // Stop process
        } elseif (!$charsetValid) {
            echo $charsetErrorMsg;
            exit; // Stop process
        }
    }
}


class UserExistsChecker {
    public static function check($conn, $table, $username) {
        $check_sql = "SELECT * FROM $table WHERE username=?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        return $result->num_rows > 0;
    }
}



?>