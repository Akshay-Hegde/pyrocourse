<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Gravatar helper for CodeIgniter.
 *
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @package 	PyroCMS\Core\Helpers
 */

function get_course($id)
{
	$ci = & get_instance();
	return $ci->streams->entries->get_entry($id, 'course', 'streams');
}

function get_coursename($id)
{
	$ci = & get_instance();
	if($course = $ci->db->select('title')->from('pc_course')->where('id', $id)->get()->row())
		return $course->title;

	return false;
}

function get_lesson($id)
{
	$ci = & get_instance();
	return $ci->streams->entries->get_entry($id, 'lesson', 'streams');
}

function get_lessonname($id)
{
	$ci = & get_instance();
	if($lesson = $ci->db->select('title')->from('pc_lesson')->where('id', $id)->get()->row())
		return $lesson->title;

	return false;
}