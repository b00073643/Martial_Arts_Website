<?php

namespace Itb;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use Itb\BookRepository;

class MainController
{
    // action for route:    /
    public function indexAction(Request $request, Application $app)
    {

        // render (draw) template
        // ------------
        $templateName = 'index';
        return $app['twig']->render($templateName . '.html.twig', []);
    }

    // action for route:    /list
    public function listAction(Request $request, Application $app)
    {
        // get reference to our repository
        $bookRepository = new BookRepository();

        // build args array
        // ------------
        $argsArray = array(
            'books' => $bookRepository->getAllBooks()
        );

        // render (draw) template
        // ------------
        $templateName = 'list';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }


    // action for route:    /show/{id}
    public function showAction(Request $request, Application $app, $id)
    {
        // get reference to our repository
        $bookRepository = new BookRepository();

        // try to get book for this ID
        $book = $bookRepository->getOneBook($id);

        // build args array
        // ------------

        // DEFAULT = book NOT found for give ID
        $argsArray = array(
            'message' => 'no book found with id = ' . $id
        );
        $templateName = 'error';

        // if book was found THEN show it
        if (null != $book){
            $argsArray = array(
                'book' => $book
            );

            $templateName = 'show';
        }

        // render (draw) template
        // ------------
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }


    // action for route:    /show/
    public function showMissingIsbnAction(Request $request, Application $app)
    {
        $argsArray = array(
            'message' => 'you must provide an isbn for the show page (e.g. /show/123)'
        );

        // render (draw) template
        // ------------
        $templateName = 'error';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

}