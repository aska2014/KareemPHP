<?php

trait Ordered {

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param $order
     */
    protected function setOrder( $order )
    {
        $this->order = $order;
    }

    /**
     * Exchange orders and save them to database
     *
     * @param OrderedInterface $model
     */
    public function exchange( OrderedInterface $model )
    {
        $modelOrder = $model->getOrder();

        $model->setOrder($this->getOrder());
        $this->setOrder($modelOrder);

        $model->save();
        $this->save();
    }

    /**
     * This will override the given model which means it will be deleted
     * from database...
     *
     * @param OrderedInterface $model
     */
    public function override( OrderedInterface $model)
    {
        // Set the order to the same model order
        $this->setOrder($model->getOrder());

        $model->delete();
    }

    /**
     * @return mixed
     */
    public function orderExists()
    {
        return $this->getOrderGroup()
                    ->where('order', $this->order)
                    ->where('id', '!=', $this->id)->count() > 0;
    }

    /**
     * @throws SameOrderException
     */
    public function failIfOrderExists()
    {
        if($this->orderExists())

            throw new SameOrderException;
    }

    /**
     * @throws SameOrderException
     * @return void
     */
    public function beforeSave()
    {
        // If order is not set then set it to the last order + 1
        if(is_null($this->getOrder()))

            $this->setOrder($this->getLastOrder() + 1);
    }

    /**
     * @return int
     */
    public function getLastOrder()
    {
        return $this->getOrderGroup()->max('order');
    }

    /**
     * Override this to group your ordered objects
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getOrderGroup()
    {
        return $this->query();
    }

    /**
     * That will override the collection for this model..
     *
     * @param array $models
     * @return OrderedCollection
     */
    public function newCollection(array $models = array())
    {
        return new OrderedCollection($models);
    }
}