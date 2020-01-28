<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class capacitacionRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
		  
		    'entidad' => 'required',
		    'lugar' => 'required',
		    'instructor' => 'required',
			'fechaDesde' => 'required',
			'fechaHasta'=> 'required',
			'idEvaluacion'=> 'required',
			'nombreCapacitacion' => 'required'
		];
	}

}
