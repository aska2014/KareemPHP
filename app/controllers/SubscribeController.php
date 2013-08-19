<?php

use Membership\User\User;

class SubscribeController  extends BaseController {

    /**
     * @var User
     */
    protected $users;

    /**
     * @param User $users
     */
    public function __construct(User $users)
    {
        $this->users = $users;
    }

    /**
     * @param $step
     * @return mixed
     */
    public function subscribe( $step )
    {
        if(strpos($step, 'step') > -1)

            return $this->$step();

        return Redirect::route('home');
    }

    /**
     * @return mixed
     */
    public function step1()
    {
        if(! Input::get('Subscribe')) return Redirect::route('home');

        $subscribeUser = $this->users->createOrUpdate(Input::get('Subscribe'));

        if(! $subscribeUser->isValid()) {

            $this->addErrors($subscribeUser);

            return $this->redirectBack('');
        }

        return View::make('subscribes.index', compact('subscribeUser'));
    }

    /**
     * @return mixed
     */
    public function step2()
    {
        if(! Input::get('Subscribe')) return Redirect::route('home');

        $user = $this->users->getByEmail(Input::get('Subscribe.email'));

        $options = Input::get('Subscribe.options', array());

        $array = array();

        foreach($options as $key => $value)
        {
            $array[$key] = true;
        }

        $user->attachSubscribe($array);

        return $this->messageToUser('You have subscribed successfully.', 'Thanks for your subscription..');
    }
}