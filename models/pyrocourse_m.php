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
					->order_by('ordering_count', 'asc')
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

	public function update($table, $id, $data)
	{
		$this->db->where('id', $id)
				->update($this->prefix.$table, $data);

		return $this->db->affected_rows();
	}

	public function get_students($params = array())
	{


		$this->db->select('e.*, p.display_name, c.title')
			->from('enrollment e')
			->join('profiles p', 'p.user_id = e.student_id')
			->join('classroom s', 's.id = e.class_id')
			->join($this->prefix.'course c', 'c.id = e.course_id');

		if(isset($params['where']) && count($params['where']) > 0)
			$this->db->where($where);

		if(isset($params['sort']))
			$this->db->order_by($params['sort'], isset($params['order']) ? $params['order'] : 'asc');

		if(isset($params['limit']))
			$this->db->limit($params['limit'], isset($params['offset'])?$params['offset'] : 0);

		return $this->db->get();
	}

 }