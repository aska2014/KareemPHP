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
     * @param $format
     * @return string
     */
    public function format($format)
    {
        return date($format, mktime(0, 0, 0, $this->month, 10));
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
        return (string) $this->month;
    }
}