<?php
/**
 * Created by JetBrains PhpStorm.
 * User: xait0020
 * Date: 03.02.13
 * Time: 16:27
 */
class BookAuthors extends LudoDBCollection
{
    protected $config = array(
        "sql" => "select author.name from author, book_author where book_author.author_id = author.id and book_author.book_id=? order by author.name"
    );

    public function getValues(){
        $values = parent::getValues();
        return implode(", ", $this->getColumnValues('name'));
    }
}
