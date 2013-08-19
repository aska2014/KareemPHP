<?php

use Illuminate\Database\Eloquent\Collection;

class OrderedCollection extends Collection {

    /**
     * @param $order
     * @return BaseModel
     */
    public function getByOrder( $order )
    {
        foreach($this->items as $item)
        {
            if($item->getOrder() == $order) return $item;
        }
    }

    /**
     * Order collection
     *
     * @return $this
     */
    public function order()
    {
        $this->sort(function( OrderedInterface $a, OrderedInterface $b )
        {
            if($a->getOrder() == $b->getOrder()) return 0;

            return $a->getOrder() < $b->getOrder() ? -1 : 1;
        });

        return $this;
    }
}