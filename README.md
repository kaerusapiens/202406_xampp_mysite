# Database
## users
| Field  | Data Type | Constrainsts  | Default Value | Special Attributes|
| ------------- | ------------- | ------------- | ------------- | ------------- |
| id  | int  |  PRIMARY KEY | | AUTO_INCREMENT |
| user_id  |  VARCHAR(10)  | NOT NULL, UNIQUE|
| password  | VARCHAR(255)  | NOT NULL |
| password_salt  | VARCHAR(64)  | NOT NULL |
| create_at | TIMESTAMPE |  |DEAFULT CURRENT_TIMESTAMP


## sessions
| Field  | Data Type | Constrainsts  | Default Value | Special Attributes|
| ------------- | ------------- | ------------- | ------------- | ------------- |
| id  | int  |  PRIMARY KEY | | AUTO_INCREMENT |
| user_id  |  int | NOT NULL, FOREIGN KEY REFERENCES users(id) ON DELETE CASCADE| NOT NULL| 
| session_id  | VARCHAR(255)  | NOT NULL |
| create_at | TIMESTAMPE |  |CURRENT_TIMESTAMP



## error_log

* /reigster, /login 404 page error
-> sloved by the .htaccess issue 

* yaml error

>Fatal error: Uncaught TypeError: Cannot access offset of type string on string in C:\xampp\htdocs\public\app\models\database.php:14 Stack trace: #0 C:\xampp\htdocs\public\app\models\users.php(9): Database->__construct() #1 C:\xampp\htdocs\public\app\controllers\auth.php(9): User->__construct() #2 C:\xampp\htdocs\public\index.php(17): AuthController->__construct() #3 {main} thrown in C:\xampp\htdocs\public\app\models\database.php on line 14
