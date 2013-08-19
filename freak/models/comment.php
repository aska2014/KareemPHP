<?php

$comment = new core\Model( 'Comment' );

$comment->setMenuItems(array(
    new core\MenuItem('Not Accepted Comments', URL::to('model/Comment'), 'icol-new'),
    new core\MenuItem('Accepted Comments', URL::to('model/Comment/create'), 'icol-drawer')
));

return $comment;