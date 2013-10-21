<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PyroCourse Module
 *
 * This is a sample module for PyroCMS
 * that illustrates how to use the streams core API
 * for data management. It is also a fully-functional
 * pyrocourse module so feel free to use it on your sites.
 *
 * Most of these functions use the Streams API CP driver which
 * is designed to handle repetitive CP tasks, down to even loading the page.
 *
 * @author 		Toni Haryanto
 * @package 	PyroCMS
 * @subpackage 	PyroCourse Module
 */
class Admin_Enrollment extends Admin_Controller
{
    // This will set the active section tab
    protected $section = 'enrollment';

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('course');
        $this->load->driver('Streams');
        $this->load->helper('course');
        $this->load->model('pyrocourse_m');

        $this->template->append_css('module::index.css');
    }

    public function index()
    {
        $params = array(
            'stream'    => 'enrollment',
            'namespace' => 'streams',
            'order_by'  => 'ordering_count',
            'sort'      => 'asc',
            'where'     => ''
        );
        $data['enroll'] = $this->streams->entries->get_entries($params);
        // dump($data['enroll']);

        $params = array(
            'stream'    => 'course',
            'namespace' => 'streams'
        );
        $data['course'] = $this->streams->entries->get_entries($params);

        $this->template
            ->set('title', lang('pyrocourse:enrollment'))
            ->build('admin/enrollment/index', $data);
    }

    public function table_ajax(){
        $params = array(
            'stream'    => 'enrollment',
            'namespace' => 'streams',
            'order_by'  => 'ordering_count',
            'sort'      => 'asc',
            'where'     => ''
        );

        $course = $this->input->post('course') ? $this->input->post('course') : 'all';
        $status = $this->input->post('status') ? $this->input->post('status') : 'all';

        if($course != 'all')
            $params['where'] .= SITE_REF."_enrollment.course_id = '{$course}'";

        if($course != 'all' && $status != 'all')
            $params['where'] .= " AND ";

        if($status != 'all')
            $params['where'] .= "enroll_status = '{$status}'";


        $data['enroll'] = $this->streams->entries->get_entries($params);

        echo $this->load->view('admin/enrollment/table', $data, true);
    }

    public function edit($id = false)
    {
        $extra = array(
            'return'            => 'admin/course/enrollment',
            'success_message'   => lang('pyrocourse:submit_success'),
            'failure_message'   => lang('pyrocourse:submit_failure'),
            'title'             => lang('pyrocourse:edit')
            );

        $skips = array('student_id', 'course_id');

        $this->streams->cp->entry_form('enrollment', 'streams', 'edit', $id, true, $extra, $skips);
    }

}