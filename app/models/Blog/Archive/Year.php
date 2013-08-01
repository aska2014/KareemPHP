<?php namespace Blog\Archive;


class Year {

    /**
     * @var int
     */
    protected $year;

    /**
     * @var Month[]
     */
    protected $months = array();

    /**
     * @param $year
     * @return \Blog\Archive\Year
     */
    public function __construct( $year )
    {
        $this->year = $year;
    }

    /**
     * @return array|Month[]
     */
    public function getMonths()
    {
        return $this->months;
    }

    /**
     * @param Month $month
     */
    public function addMonth( Month $month )
    {
        $this->months[] = $month;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        $count = 0;

        foreach($this->months as $month)
        {
            $count += $month->getCount();
        }

        return $count;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->year;
    }
}