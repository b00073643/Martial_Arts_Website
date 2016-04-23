<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/04/2016
 * Time: 11:15
 */

namespace Itb\Controller;


class AdminController
{

    public function adminHomeAction(Request $request, Application $app)
    {
        $isLoggedIn = $this->loginController->isAdminLoggedInFromSession();
        if ($isLoggedIn){
            $username = $this->loginController->usernameFromSession();
            $templateName = 'adminIndex';
            $argsArray=['user'=>$username];
            return $app['twig']->render($templateName . '.html.twig',$argsArray);


        } else {
            $templateName = 'loginFail';

            $message = 'UNAUTHORIZED ACCESS - the Guards are on their way to arrest you ...';
            $argsArray=['message'=>$message];

            return $app['twig']->render($templateName . '.html.twig',$argsArray);
        }
    }

}