<?php

namespace Itb\Controller;

use Itb\Model\Book;
use Itb\Model\User;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class MainController
{

    public function indexAction(Request $request, Application $app)
    {
        $templateName = 'index';
        $argsArray=['user'=>'user'];
        if($_SESSION['user']!=null)
        {
            $argsArray=['user'=>$_SESSION['user']];

        }
        if($_SESSION['role']==true)
        {
            $templateName = 'admin/adminIndex';
            return $app['twig']->render($templateName . '.html.twig',$argsArray);

        }
        return $app['twig']->render($templateName . '.html.twig',$argsArray);
    }


    public function listAction(Request $request, Application $app)
    {
        $users = User::getAll();
        $argsArray = [
            'users'=> $users
        ];
        $templateName = 'listUsers';

        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
    public function showAction(Request $request, Application $app, $id)
    {
        $book = Book::getOneById($id);

        $message= 'Sorry no book could be found with the ID number'.$id;

        $argsArray = [
            'message'=> $message
        ];
        $templateName='error';
        if(null != $book) {
            $argsArray = [
                'book' => $book
            ];

            $templateName = 'show';
        }

        return $app['twig']->render($templateName . '.html.twig', $argsArray);

    }
    public function showMissingAction(Request $request, Application $app)
    {

        $message= 'Sorry no ID was entered';

        $argsArray = [
            'message'=> $message
        ];
        $templateName='error';

        return $app['twig']->render($templateName . '.html.twig', $argsArray);

    }

    public function errorAction(Application $app, $code)
    {
        $message = '404 Error sorry cant find resource';
        if($code != 404)
        {
            $message='Sorry UNKOWN ERROR OCCURRED';
        }
        $argsArray = [
            'message'=> $message
        ];
        $templateName='error';

        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

}