<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Discussion Module
 *
 * @author		Gogula Krishnan Rajaprabhu
 * @package		PyroCMS\Addon\Modules\Discussion\Models
 * @website		http://netpines.com
 */

 class Pyrocourse_m extends CI_Model
 {	

 	public $prefix = 'pc_';

 	public function __construct()
 	{
 		parent::__construct();
 	}
	
	public function get_contents($lesson_id = false)
	{
		if($lesson_id){
			return $this->db->from('pc_lesson_content')
					->where('lesson_id', $lesson_id)
					->get()->result_array();
		}

		return false;
	}

	public function get_content($type, $id)
	{
		return $this->db->from($this->prefix.'content_'.$type)
					->where('id', $id)
					->get()
					->row_array();
	}

 }