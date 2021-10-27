<?php

require('../../../core/init.php');
require_once('../libraries/User.php');
require_once('../libraries/Response.php');

?>

<?php

    // Creating new User
    
    
    // Getting Existing User
    // /users/1

    $user = new User();

    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        if(isset($_GET['user']))
        {
            $uId = $_GET['user'];

            
            $user->getUserDetails($uId);
        }
    }

    elseif($_SERVER['REQUEST_METHOD' == 'POST'])
    {


    }
    elseif($_SERVER['REQUEST_METHOD' == 'PATCH'])
    {



    }
    elseif($_SERVER['REQUEST_METHOD' == 'DELETE'])
    {

    }
    else
    {
        $response = new Response();
            $response->setHttpStatusCode(405);
            $response->setSuccess(false);
            $response->addMessage("Requested method not allowed");
            $response->send();
            exit;
    }






?>