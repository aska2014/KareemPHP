<?php

use Blog\Comment\Comment;
use Blog\Comment\CommentAlgorithm;
use core\Model;

class CommentController extends AppController {

    protected $app;

    protected $commentAlgorithm;

	public function __construct(app\models\App\AppRepository $app, CommentAlgorithm $commentAlgorithm)
	{
		parent::__construct(Model::get( 'Comment' ));

		$this->app = $app;

        $this->commentAlgorithm = $commentAlgorithm;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Asset::addPlugin('datatables');

		$comments = $this->commentAlgorithm->notAccepted()->get();

		return View::make('comments.data', compact('comments'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$comment = Comment::find( $id );

        $comment->accept();

        return Redirect::back()->with('success', 'Comment accepted successfully.');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return $this->index()->with('comments', $this->commentAlgorithm->accepted()->get());
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return $this->create()->with('comment', Comment::find($id))->with('edit', true);
	}

	/**
	 * Validate resource before storing in storage
	 *
	 * @return Response
	 */
	public function validate()
	{
		$validator = Validator::make(Input::get('Comment'), array(

			// Validations

		));

		if($validator->fails())
		
			return Response::json(array( 'message' => 'failed', 'body' => $validator->messages()->all(':message')));

		else

			return Response::json(array( 'message' => 'success', 'body' => 'Inputs are validated successfully'));

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$comment = new Comment(Input::get('Comment'));

        $comment->dontValidate();

        $comment->save();

		return Response::json(array('insert_id' => $comment->id, 'message' => 'success'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$comment = Comment::find($id);

        $comment->dontValidate();

        $comment->update(Input::get('Comment'));
		
		return Response::json(array('message' => 'success'));
	}

	/**
	 * Upload Image
	 *
	 * @param  int    $id
	 * @return Response
	 */
	public function upload( $id )
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Comment::find($id)->delete();
	
		return Redirect::back()->with('success', 'Comment deleted successfully.');
	}

	/**
	 * Destroy images from storage
	 * 
	 * @param  int  $id
	 * @return Response
	 */
	public function destroyImages( $id )
	{

	}

}