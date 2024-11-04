<?php
session_start();

function flash($name = '', $message = '')
{
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }
            $_SESSION[$name] = $message;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            echo  $_SESSION[$name] ;
            unset($_SESSION[$name]);
        }
    }
}

function isLoggedIn()
{
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}

function isAdmin()
{
    if (isset($_SESSION['user_role'])) {
        if($_SESSION['user_role']== 'Admin'){
            return true;
        }
    } else {
        return false;
    }
}
