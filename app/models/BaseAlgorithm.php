<?php

use Illuminate\Database\Query\Builder;

abstract class BaseAlgorithm {

    /**
     * @var Builder
     */
    protected $query = null;

    /**
     * @param Builder $query
     * @return BaseAlgorithm
     */
    public function __construct( Builder $query = null )
    {
        $this->query = $query ?: $this->emptyQuery();
    }

    /**
     * @param Builder $query
     */
    public function setQuery( Builder $query )
    {
        $this->query = $query;
    }

    /**
     * @return Builder
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return void
     */
    public function reset()
    {
        $this->query = null;
    }

    /**
     * @return Builder
     */
    public abstract function emptyQuery();

    /**
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get(array $columns = array('*'))
    {
        $collection = $this->getQuery()->get($columns);

        $this->reset();

        return $collection;
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function first(array $columns = array('*'))
    {
        $model = $this->getQuery()->first($columns);

        $this->reset();

        return $model;
    }

    /**
     * Easy way to use many methods in the concrete class.
     * <code>
     * $algorithm->call('popular', array('year', 2013), array('month', 3));
     * </code>
     *
     * @return $this
     */
    public function call()
    {
        // Get arguments
        $args = func_get_args();

        // Loop through all args which represents methods
        foreach ($args as $method)
        {
            // If method is string then call method if exists and hold the current query.
            if(is_string($method) && method_exists(get_called_class(), $method)) {

                call_user_func_array(array($this,$method), array());
            }

            // If is array it means he is passing parameters with the method.
            // $method = array('methodName', $param1, $param2, ... )
            else if(is_array($method)) {

                // Get function from array
                $func = array_shift($method);

                if(method_exists(get_called_class(), $func)) {
                    call_user_func_array(array($this, $func), $method);
                }
            }
        }

        return $this;
    }
}