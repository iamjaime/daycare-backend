<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Note;

use \Response;
use \Input;
use \Validator;

class NoteController extends Controller {

	public function __construct(Note $note){
		$this->facilityID = $this->getFacility();
		$this->note = $note;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Get All Notes
		$data = Input::get('data');
		$allNotes = $this->note->where('facility_id', $this->facilityID)->where('child_id', $childId)->get();
		return Response::json([
			'success' => true,
			'data' => $allNotes
		], 200);
	}

	/**
	 * getChildNotes Gets all notes for a specific child
	 * @param  int $id The child id
	 * @return Response
	 */
	public function getChildNotes($id)
	{
		$allNotes = $this->note->where('facility_id', $this->facilityID)->where('child_id', $id)->get();
		return Response::json([
			'success' => true,
			'data' => $allNotes
		], 200);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Create New Client
		$data = Input::get('data');
		$rules = $this->note->create_rules;

		//validate....
		$validator = Validator::make($data, $rules);
		if ($validator->fails()){
			$messages = $validator->messages();
		    return Response::json([
			    	'success' => false,
			    	'error' => $messages
		    	], 400);
		}

		$note = new Note;
		$note->facility_id = $this->facilityID;
		$note->staff_id = $data['staff_id'];
		$note->child_id = $data['child_id'];
		$note->title = $data['title'];
		$note->note = $data['note'];
		$note->save();

		return Response::json([
			'success' => true,
			'data' => $note
		], 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//Get All Notes
		$note = $this->note->find($id)->where('facility_id', $this->facilityID)->first();
		return Response::json([
			'success' => true,
			'data' => $note
		], 200);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//Create New Client
		$data = Input::get('data');
		$rules = $this->note->update_rules;

		//validate....
		$validator = Validator::make($data, $rules);
		if ($validator->fails()){
			$messages = $validator->messages();
		    return Response::json([
			    	'success' => false,
			    	'error' => $messages
		    	], 400);
		}

		$note = $this->note->find($id);
		$note->facility_id = $this->facilityID;
		$note->staff_id = $data['staff_id'];
		$note->child_id = $data['child_id'];
		$note->title = $data['title'];
		$note->note = $data['note'];
		$note->save();

		return Response::json([
			'success' => true,
			'data' => $data
		], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$note = $this->note->find($id);
		$note->delete();

		return Response::json([
			'success' => true,
			'msg' => 'note successfully deleted.'
		], 200);
	}
}
