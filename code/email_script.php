<?php

// this includes the code that includes the functions
include("classes.php");

// this creates a new instance for the class register
$register1 = new register();
$register1->first_name = $_POST["first_name"];
$register1->infix = $_POST["infix"];
$register1->last_name = $_POST["last_name"];
$register1->email = $_POST["email"];
$register1->username = $_POST["username"];

    // checks if the email adress was actually filled in
    if (empty($_POST["email"])) {

            // if there is no email the user will be redirected to a alert reminding them to enter their email adress
        header("Location: ./index.php?content=message&alert=no-email");
    } 
    else {
        if (empty($_POST["username"])) {

                // if there is no username the user will be redirected to a alert reminding them to enter their username adress
            header("Location: ./index.php?content=message&alert=no-username");
        }
        else {

                // checks if this email is in the users table already
            if ($register1->check_for_registration_email()) {

                    // if this email already exists within the table the user will be redirected to a alert telling them there is already an account with this email
                header("location: ./index.php?content=message&alert=emailexists");
            }
            else {

                    // checks if this username is in the users table already
                if ($register1->check_for_registration_username()) {
                        // if this username already exists within the table the user will be redirected to a alert telling them there is already an account with this username
                    header("location: ./index.php?content=message&alert=username-exists&username=$register1->username");
                } 
                else {
                        // if both the username and email dont exist already the register-confirm function will be called to add them to the database and send a confirmation mail
                    $register1->register_confirm();
                }
            }
        }
    }