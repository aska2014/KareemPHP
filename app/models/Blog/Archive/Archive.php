<?php namespace Blog\Archive;

use Blog\Post\PostAlgorithm;

class Archive {

    const MAX_HISTORY_YEARS = 5;

    /**
     * @var PostAlgorithm
     */
    protected $postAlgorithm;

    /**
     * @param PostAlgorithm $postAlgorithm
     */
    public function __construct( PostAlgorithm $postAlgorithm )
    {
        $this->postAlgorithm = $postAlgorithm;
    }

    /**
     * It will return an array in this format
     * ['year' => [['month','count'], 'month-count', ....],
     *  'year' => ['month-count', 'month-count', ....]]
     *
     *
     * @return Year[]
     */
    public function toYears()
    {
        $years = array();

        // Loop through all years
        for($j = 0; $j < self::MAX_HISTORY_YEARS; $j ++)
        {
            // Get loop year
            $yearNo = date('Y', strtotime('-' . $j . ' year'));

            $year = new Year($yearNo);

            // Loop through all months
            for($i = 0; $i < 12; $i++)
            {
                // Get loop month
                $monthNo = date('m', strtotime('-' . $i . ' month'));

                $count = $this->postAlgorithm->year($yearNo)->month($monthNo)->postState()->count();

                if($count > 0) $year->addMonth(new Month($monthNo, $count));
            }

            if($year->getCount() > 0) $years[] = $year;
        }

        return $years;
    }
}