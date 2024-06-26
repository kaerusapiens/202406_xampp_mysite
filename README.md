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

```mermaid
graph TD;
    A-->B;
    A-->C;
    B-->D;
    C-->D;
```