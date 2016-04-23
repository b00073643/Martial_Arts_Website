<?php

namespace Itb;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ErrorController
{
    // action for ERRORS
    public function errorAction(Application $app, $errorCode)
    {
        // default - 404
        $argsArray = [];
        $templateName = '404';

        if (404 != $errorCode){
            $message = 'sorry, something went wrong.';
            $message .= '<br>(ERROR CODE = ' . $errorCode . ')';

            $argsArray = array(
                'message' => $message
            );

            $templateName = 'error';

        }

        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }


}