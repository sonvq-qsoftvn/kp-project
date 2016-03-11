<?php

require_once 'vendor/autoload.php';

use DirkGroenen\Pinterest\Pinterest;

$pinterest = new Pinterest('4815775197030270866', '5a878088daec54d9a7ced466dd7c73949484ad94e887d778f4cba656aff6d27a');

try {
$pinterest->auth->setOAuthToken('AaQ2WjIpIh1Vp5Z_EGjnhCHbnV-2FC7FMYvXbqpC1ROgtYBHzQAAAAA');

$me = $pinterest->users->me();

$create = $pinterest->pins->create(array(
    "note"          => "Test board from API",
    "image_url"     => "https://download.unsplash.com/photo-1438216983993-cdcd7dea84ce",
    "board"         => "524810231516393498"
));

echo $me;
echo $create;
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

