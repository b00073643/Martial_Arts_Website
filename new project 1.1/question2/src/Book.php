<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 05/11/2015
 * Time: 22:00
 */

namespace Itb;

/**
 * Class Book to represent book objects
 * @package Hdip
 */
class Book
{
    /**
     * isbn of book (unique primary KEY)
     *
     * example:
     * <code>
     * 1234
     * </code>
     * @var string
     */
    private $isbn;

    /**
     * title of book
     *
     * example:
     * <code>
     * The Return of Sherlock Holmes
     * </code>
     *
     * @var string
     */
    private $title;

    /**
     * path to cover image
     *
     * example:
     * <code>
     * holmes_return.jpg
     * </code>
     * @var string
     */
    private $image;

    /**
     * total number of pages (including Index)
     *
     * example:
     * <code>
     * 20
     * </code>
     * @var int
     */
    private $numPagesTotal;

    /**
     * number of pages taken up by the index
     *
     * example:
     * <code>
     * 12
     * </code>
     * @var int
     */
    private $numPagesIndex;

    /**
     * create new book, with provided ISBN
     *
     * example usage:
     *
     * <code>
     * $book = new Book(1234);
     * </code>
     * @param string $isbn
     */
    function __construct($isbn)
    {
        $this->isbn = $isbn;
    }

    /**
     * get the ISBN
     *
     * example usage:
     *
     * <code>
     * $isbn = $b->getIsbn();
     * </code>
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * get the title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * get the image path
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * get the total number of pages
     * @return int
     */
    public function getNumPagesTotal()
    {
        return $this->numPagesTotal;
    }

    /**
     * return the number of pages in the index
     * @return int
     */
    public function getNumPagesIndex()
    {
        return $this->numPagesIndex;
    }

    /**
     * return number of pages EXCLUDING the index pages
     * @return int
     */
    public function getNumPagesLessIndex()
    {
        return $this->numPagesTotal - $this->numPagesIndex;
    }

    /**
     * set the book title
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * set the image path
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * set the total number of pages for the book
     * @param int $numPagesTotal
     */
    public function setNumPagesTotal($numPagesTotal)
    {
        $this->numPagesTotal = $numPagesTotal;
    }

    /**
     * set the numnber of pages in the index
     * @param int $numPagesIndex
     */
    public function setNumPagesIndex($numPagesIndex)
    {
        $this->numPagesIndex = $numPagesIndex;
    }
}