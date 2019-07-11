<?php

/**
 * From: https://gist.github.com/grobolom/951807536f5a2088fe17
 *
 * This is implemented because I wanted a good way of using PDOStatement as an array (which in normally handles)
 * multiple times (which it doesn't). PDOStatement on it's own allows you to traverse it with foreach but
 * does not reset automatically.
 *
 * Class TraversablePDOStatement
 * @package Database
 */
class TraversablePDOStatement implements \Iterator
{
    private $statement;
    private $i;
    private $params;
    public function __construct(\PDOStatement $statement, $params)
    {
        $this->statement = $statement;
        $this->params = $params;
        $this->i = 1;
//        $this->max = $this->statement->rowCount();
        $this->max = 10000; // hard-coded for the example. SQLITE3 doesn't support rowCount
    }
    /**
     * Pass through any methods that are not defined to PDOStatement itself.
     *
     * @param $name
     * @param $params
     * @return mixed
     */
    public function __call($name, $params)
    {
        return call_user_func_array(array($this->statement, $name), $params);
    }
    public function current()
    {
        return $this->statement->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_ABS, $this->i);
    }
    public function key()
    {
        return $this->i;
    }
    public function next()
    {
        $this->i++;
    }
    /**
     * This is really the core of our Traversable functionality - the only way to reset the cursor in PDO is
     * to re-execute the statement, which is why we pass the parameters used to execute the statement
     * in the first place to the constructor, so we can use them here. This is implementation-specific,
     * so I don't feel bad about using this method - if a proper cursor is ever implemented for PDOStatement
     * we would immediately stop use of this wrapper.
     */
    public function rewind()
    {
        $this->i = 0;
        $this->statement->execute($this->params);
    }
    public function valid()
    {
        if ($this->i >= $this->max)
            return false;
        return true;
    }
}
