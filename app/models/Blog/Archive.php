<?php namespace Blog;

use Blog\Page\PostAlgorithm;

class Archive {

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
     * @return array
     */
    public function toArray()
    {
        $array = array();

        // Maximum history years = 12...
        for($j = 0; $j < 12; $j ++)
        {
            $year = date('Y', strtotime('-' . $j . ' year'));

            for($i = 0; $i < 12; $i++) {

                $time = strtotime('-' . $i . ' month');

                $month = date('m', $time);
                $monthName = date('F', $time);

                $count = $this->postAlgorithm->year($year)->month($month)->count();

                $array[$year] = $monthName . ' ' . $count;
            }
        }

        return $array;
    }

}