<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "Pinterest.class.php";


// Create the pinterest object and log in
$p = new Pinterest();
$p->login("vuquangson1610@gmail.com", "langtudeptrai");

// Get the boards

// Set up the pin
$p->pin_url = "http://yellow5.com";
$p->pin_description = "My awesome pin";
$p->pin_image_preview = $p->generate_image_preview("compot.jpg");

$p->get_boards();

// Pin to the board called "Items"
$p->pin($p->boards['kpasapp']);

// And we're done
echo "Hooray!\n";
