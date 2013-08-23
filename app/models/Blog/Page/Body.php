<?php namespace Blog\Page;

use Blog\Post\Post;
use URL;

class Body {

    /**
     * @var string
     */
    protected $text;

    /**
     * @var array
     */
    protected $preg = array(
        'route' => '/route{([a-z]+)}/',
        'tutorial' => '/tutorial{([0-9]+)}/'
    );

    /**
     * @var bool
     */
    protected $isReady = false;

    /**
     * @param $text
     */
    public function __construct( $text )
    {
        $this->text = $text;
    }

    /**
     * Launch all steps
     */
    public function makeReady()
    {
        $this->isReady = true;

        $this->htmlDecode();

        $this->replaceRoute();

        $this->replaceTutorialUrl();
    }

    /**
     * @return string
     */
    public function getReadyText()
    {
        if(! $this->isReady) $this->makeReady();

        return $this->getText();
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Html decode text
     */
    public function htmlDecode()
    {
        $this->text = html_entity_decode($this->text);
    }

    /**
     * Replace routes
     */
    public function replaceRoute()
    {
        $this->text = preg_replace_callback($this->preg['route'], function($match)
        {
            return URL::route($match[1]);

        }, $this->text);
    }

    /**
     * @return void
     */
    public function replaceTutorialUrl()
    {
        $this->text = preg_replace_callback($this->preg['tutorial'], function($match)
        {
            $post = Post::find($match[1]);

            if(! $post) return '#';

            return \EasyURL::post($post);

        }, $this->text);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->text;
    }
}