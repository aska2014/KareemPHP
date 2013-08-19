<?php

trait Acceptable {

    /**
     * Accept current object.
     *
     * @return $this
     */
    public function accept()
    {
        $this->accepted = true;

        $this->save();

        return $this;
    }

    /**
     * Unaccept current object.
     *
     * @return void
     */
    public function unaccept()
    {
        $this->accepted = false;

        $this->save();

        return $this;
    }

    /**
     * Throws an exception if not accepted
     *
     * @throws NotAcceptedException
     * @return $this
     */
    public function failIfNotAccepted()
    {
        if(! $this->accepted)

            throw new NotAcceptedException;

        return $this;
    }
}