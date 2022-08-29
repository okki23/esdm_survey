<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;

class UserTrackerObserver
{
	public $userID;

	public function __construct(){
		$this->userID =  Auth::id();
	}

	public function updating($model)
	{
		$model->updated_by = $this->userID;
	}

	public function creating($model)
	{
		$model->created_by = $this->userID;
		$model->updated_by = $this->userID;
	}

	public function deleting($model)
	{
		$model->deleted_by = $this->userID;
		$model->save();
	}
}
