<?php

interface PolymorphicInterface{

    /**
     * @param BaseModel $model
     * @return mixed
     */
    public function attachTo(BaseModel $model);

}