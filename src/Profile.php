<?php

namespace Elphas\Recommender;


class Profile
{
	public $id;
	public $reference_id;
	public $items;

	public function __construct($id = null,$reference_id = null, $items = [])
	{
		$this->id = $id;
		$this->reference_id = $reference_id;
		$this->items = $items;
	}

	/**
	 * @return array
	 */
	public function serialize()
	{
		return ['id'=>$this->id, 'reference_id'=>$this->reference_id, 'items'=>$this->items];
	}

	/**
	 * @param null $json
	 * @return Profile
	 */
	public static function  withJson($json = null)
	{
		$instance = new self();
		if ($json){
			$instance->id = $json['id'];
			$instance->reference_id = $json['reference_id'];
			$instance->items = $json['items'];
		}
		return $instance;
	}

	public function __toString(){
		$output = 'Profile('. $this->id .')';
		return $output;
	}


}