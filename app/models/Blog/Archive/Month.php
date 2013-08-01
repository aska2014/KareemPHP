<?php namespace Blog\Archive;


class Month {

    /**
     * @var int
     */
    protected $month;

    /**
     * @var int
     */
    protected $count;

    /**
     * @param int $month
     * @param int $count
     */
    public function __construct( $month, $count )
    {
        $this->month = $month;
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->year;
    }
}