<?php

class register {
    var $first_name;
    var $infix;
    var $last_name;
    var $email;
    var $username;
    var $conn;
    function sanitize($raw_data) {
            global $conn;
            $data = htmlspecialchars($raw_data);
            $data = mysqli_real_escape_string($conn, $data);
            return $data;
    }

    function check_for_registration_email(){
        $clean_email = $this->sanitize($this->email);
        $sql_mail = "SELECT * from  `users` WHERE `e-mail` = '{$clean_email}'";
        $result_mail = mysqli_query($this->conn, $sql_mail);
        return $result_mail;        
        return mysqli_num_rows($result_mail);
        
    }

        function check_for_registration_username(){
        $clean_username = $this->sanitize($this->username);           
        $sql_username = "SELECT * from  `users` WHERE `e-mail` = '{$clean_username}'";        
        $result_username = mysqli_query($this->conn, $sql_username);
        return $result_username;
        return mysqli_num_rows($result_username);
    }

    function enter_DB(){
        $clean_first_name = $this->sanitize($this->first_name); 
        $clean_infix = $this->sanitize($this->infix);
        $clean_last_name = $this->sanitize($this->last_name);        
        $clean_email = $this->sanitize($this->email);
        $clean_username = $this->sanitize($this->username);
        
        $ut = time();
        $mut = microtime();
        $time = explode(" ", $mut);
        $onehour = mktime(2, 0 , 0 , 1 , 1 , 1970);


        $t = date("H:i:s D-d-M-Y", ($ut + $onehour));
        $d = date("l d-M-Y", ($ut + $onehour));

        $password = $time[1] * $time[0] * 1000000;
        echo $password;
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        // id	first_name	infix	last_name	email	role	username
        $sql = "INSERT INTO `users` (`id`,
                                    `first_name`,
                                    `infix`,
                                    `last_name`,
                                    `email`,
                                    `role`,
                                    `username`)
                                VALUES (NUll,
                                        '$clean_first_name',
                                        '$clean_infix',
                                        '$clean_last_name',
                                        '$clean_email',
                                        'user',
                                        '$password_hash')";
        // vuur de query af op de database
        // deze functie haalt het laats gegenerreerde id op uit de database

        $result = mysqli_query($this->conn, $sql);
        $id = mysqli_insert_id($this->conn);
        $id = mysqli_insert_id($this->conn);
        $this->enter_DB();
        $to = $clean_email;
        $message = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>
        <body>
        <div style="color: rgb(0, 255, 0)">
        <b>
            <h1>dear user</h1>
            </b>
            <div style="color: rgb(0, 0, 0)">
                <p>' . $d . '</p>
                <p>You have succesfully signed up for our website.</p>
                <p>Click here to activate your email</p>
                <a href="http://laptopshop.tv//index.php?content=activate&pwh=' . $password_hash . '&id=' . $id . '">activate</a>
            </div>
        </div>
        </body>
        </html>';
        $subject = "activation link";
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: t.v.surksum@afasie.tv\r\n";
        $headers .= "Cc: \r\n";
        $headers .= "Bcc: ";
        $parameters = '';
        mail($to, $subject, $message, $headers);
        header("location: ./index.php?content=message&alert=succes");
    }

}
?>