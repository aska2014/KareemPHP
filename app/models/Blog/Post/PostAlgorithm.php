<?php namespace Blog\Post;

use DB;
use Blog\Post\Post;
use \Illuminate\Database\Query\Builder;

class PostAlgorithm extends \BaseAlgorithm {

    /**
     * @return $this
     */
    public function postState()
    {
        $this->getQuery()->where('state', Post::POST);

        return $this;
    }

    /**
     * @param Post $post
     * @return $this
     */
    public function related( Post $post )
    {
        $this->getQuery()->where('id', '!=', $post->id)
                        ->where(function(Builder $query) use ($post)
                        {
                            $keywords = explode(" ", $post->getTitle());
                            $keywords = array_merge($keywords, $post->getTagsArray());

                            foreach($keywords as $keyword)
                            {
                                if($keyword == '') continue;

                                $query->orWhere('title', 'like', '%' . $keyword . '%')
                                    ->orWhere('tags', 'like', '%' . $keyword . '%');
                            }
                        })->orderBy(DB::raw('RAND()'));

        return $this;
    }

    /**
     * @param $year
     * @return $this
     */
    public function year( $year )
    {
        $this->getQuery()->where(DB::raw('YEAR(posted_at)'), $year);

        return $this;
    }

    /**
     * @param $month
     * @return $this
     */
    public function month( $month )
    {
        $this->getQuery()->where(DB::raw('MONTH(posted_at)'), $month);

        return $this;
    }

    /**
     * @param  string $order
     * @return $this
     */
    public function orderByPostDate( $order = 'asc' )
    {
        $this->getQuery()->orderBy('posted_at', $order);

        return $this;
    }

    /**
     * @param Collection $posts
     * @return $this
     */
    public function except( Collection $posts )
    {
        $this->getQuery()->whereNotIn('id', implode(',' , $posts->modelKeys()));

        return $this;
    }

    /**
     * @todo
     * return $this
     */
    public function popular()
    {
        $this->getQuery()->orderBy('id', 'DESC');

        return $this;
    }

    /**
     * Get a copy of the given post by the given user.
     *
     * @param Post $post
     * @param User $user
     * @return $this
     */
    public function copyByUser(Post $post, User $user)
    {
        $this->getQuery()->where('user_id', $user->id)
            ->where('copy_id', $post->id);

        return $this;
    }

    /**
     * @param  Datetime|string $start
     * @param  Datetime|string $end
     * @return $this
     */
    public function between($start , $end)
    {
        $this->getQuery()->whereBetween('posted_at', array($start, $end));

        return $this;
    }

    /**
     * @param string $keyword
     * @return $this
     */
    public function search( $keyword )
    {
        $this->getQuery()->where(function(Builder $query) use ($keyword)
        {
            $query->where('title', 'like', '%'. $keyword .'%')
                ->orWhere('description', 'like', '%'. $keyword .'%')
                ->orWhere('tags', 'like', '%'. $keyword .'%');
        });

        return $this;
    }

    /**
     * Get an empty query for this model.
     *
     * @return Builder
     */
    public function emptyQuery()
    {
        return Post::query();
    }
}