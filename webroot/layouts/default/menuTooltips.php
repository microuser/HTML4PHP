<?php

$this->menuTooltips = array(
    "Home" => array(
        "Your Home",
        array(
            "Login" => "Login",
            "Logout" => "Logout",
            "Register" => "Create a new account",
        )
    ),
    "Sample" => array(
        "Sample Page",
        array(
            "Sample" => "asdfasdfasd asdf asd fa sdf",
            "One" => "asdfasdf asd fas df",
            "Two" => "asdfasdfAsdfasd fasdf asdf",
            "Three" => "asdfaesvasegasev"
        )
    ),
    "Tests" => array(
        "Lots of tests to show working",
        array(
        )
    ),
    "jQueryUI" => array(
        "A set of UI elements and their demonstrations",
        array(
        )
    ),
);

$this->addJavascriptCodeFooter('$(document).ready( function() { $( document ).tooltip();});');
