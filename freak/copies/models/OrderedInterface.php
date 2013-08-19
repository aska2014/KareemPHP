<?php

interface OrderedInterface {

    /**
     * @param int $order
     */
    public function setOrder( $order );

    /**
     * @return int
     */
    public function getOrder();

    /**
     * Exchange orders and save them to database
     *
     * @param OrderedInterface $model
     */
    public function exchange( OrderedInterface $model );

    /**
     * This will override the given model which means it will be deleted
     * from database...
     *
     * @param OrderedInterface $model
     * @return
     */
    public function override( OrderedInterface $model );

    /**
     * @return int
     */
    public function getLastOrder();

    /**
     * @throws SameOrderException
     */
    public function failIfOrderExists();
}