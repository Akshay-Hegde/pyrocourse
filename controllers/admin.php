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
class Admin extends Admin_Controller
{
    // This will set the active section tab
    protected $section = 'course';

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('course');
        $this->load->driver('Streams');
        $this->load->helper('course');
    }

    /**
     * List all pyrocourses using Streams CP Driver
     *
     * We are using the Streams API to grab
     * data from the pyrocourses database. It handles
     * pagination as well.
     *
     * @return	void
     */
    public function index()
    {
        // The extra array is where most of our
        // customization options go.
        $extra = array();

        // The title can be a string, or a language
        // string, prefixed by lang:
        $extra['title'] = 'lang:pyrocourse:pyrocourses';
        
        // We can customize the buttons that appear
        // for each row. They point to our own functions
        // elsewhere in this controller. -entry_id- will
        // be replaced by the entry id of the row.
        $extra['buttons'] = array(
            array(
                'label' => lang('pyrocourse:manage'),
                'url' => 'admin/pyrocourse/manage/-entry_id-'
            )
        );

        // In this example, we are setting the 5th parameter to true. This
        // signals the function to use the template library to build the page
        // so we don't have to. If we had that set to false, the function
        // would return a string with just the form.
        $this->streams->cp->entries_table('course', 'streams', 3, 'admin/pyrocourse/index', true, $extra);
    }

    public function manage($id = 0)
    {
        $data['course'] = $this->streams->entries->get_entry($id, 'course', 'streams');

        $params = array(
            'stream'    => 'lesson',
            'namespace' => 'streams',
            'order_by'  => 'ordering_count',
            'sort'      => 'asc',
            'where'  =>  'course_id = '.$id,
        );
        $data['lesson'] = $this->streams->entries->get_entries($params);

        $this->template
            ->append_js('jquery/jquery.ui.nestedSortable.js')
            ->append_js('jquery/jquery.cooki.js')
            ->append_js('jquery/jquery.stickyscroll.js')
            ->append_js('module::index.js')

            ->append_css('module::index.css')
            ->build('admin/manage', $data);
    }

    /**
     * Create a new pyrocourse entry
     *
     * We're using the entry_form function
     * to generate the form.
     *
     * @return	void
     */
    public function create_course()
    {
        $extra = array(
            'return' => 'admin/pyrocourse/manage/-id-',
            'success_message' => lang('pyrocourse:submit_success'),
            'failure_message' => lang('pyrocourse:submit_failure'),
            'title' => 'lang:pyrocourse:new_course',
        );

        $tabs = array(
            array(
                'title' => "General",
                'id' => "general-tab",
                'fields' => array('title', 'title_slug', 'introduction', 'featured_image')
                ),
            array(
                'title' => "Publication",
                'id' => "publication-tab",
                'fields' => array('dependency', 'visibility', 'status')
                ),
            );

        $skips = array('trashed');

        $this->streams->cp->entry_form('course', 'streams', 'new', null, true, $extra, $skips, $tabs);
    }
    
    /**
     * Edit a pyrocourse entry
     *
     * We're using the entry_form function
     * to generate the edit form. We're passing the
     * id of the entry, which will allow entry_form to
     * repopulate the data from the database.
     *
     * @param   int [$id] The id of the pyrocourse to the be deleted.
     * @return	void
     */
    public function edit_course($id = 0)
    {
        $extra = array(
            'return' => 'admin/pyrocourse/manage/'.$id,
            'success_message' => lang('pyrocourse:submit_success'),
            'failure_message' => lang('pyrocourse:submit_failure'),
            'title' => 'lang:pyrocourse:edit_course'
        );

        $tabs = array(
            array(
                'title' => "General",
                'id' => "general-tab",
                'fields' => array('title', 'title_slug', 'introduction', 'featured_image')
                ),
            array(
                'title' => "Publication",
                'id' => "publication-tab",
                'fields' => array('dependency', 'visibility', 'status')
                ),
            );

        $skips = array('trashed');

        $this->streams->cp->entry_form('course', 'streams', 'edit', $id, true, $extra, $skips, $tabs);
    }

    /**
     * Delete a pyrocourse entry
     * 
     * @param   int [$id] The id of pyrocourse to be deleted
     * @return  void
     */
    public function delete_course($id = 0)
    {
        $this->streams->entries->delete_entry($id, 'course', 'streams');
        $this->session->set_flashdata('error', lang('pyrocourse:deleted'));
 
        redirect('admin/pyrocourse/');
    }

// LESSON FUNCTIONS //

    public function manage_lesson($id = 0)
    {
        $this->load->model('pyrocourse_m');

        // get lesson detail
        $data['lesson'] = $this->streams->entries->get_entry($id, 'lesson', 'streams');

        // get assignment data
        $params = array(
            'stream'    => 'assignment',
            'namespace' => 'streams',
            'order_by'  => 'ordering_count',
            'sort'      => 'asc',
            'where'  =>  'lesson_id = '.$id,
        );
        $data['assignment'] = $this->streams->entries->get_entries($params);

        // get content data
        $data['contents'] = $this->pyrocourse_m->get_contents($id);
        foreach ($data['contents'] as &$value) {
            $id = $value['id'];
            $temp = $this->pyrocourse_m->get_content($value['content_type'], $value['content_id']);
            $value = array_merge($temp, $value);
        }
        
        $this->template
            ->append_js('jquery/jquery.ui.nestedSortable.js')
            ->append_js('jquery/jquery.cooki.js')
            ->append_js('jquery/jquery.stickyscroll.js')
            ->append_js('module::index.js')

            ->append_css('module::index.css')
            ->build('admin/manage_lesson', $data);
    }

    /**
     * Create a new pyrocourse lesson
     *
     * We're using the entry_form function
     * to generate the form.
     *
     * @return  void
     */
    public function create_lesson($course_id = 0)
    {
        $extra = array(
            'return' => 'admin/pyrocourse/manage/'.$course_id,
            'success_message' => lang('pyrocourse:lesson:submit_success'),
            'failure_message' => lang('pyrocourse:lesson:submit_failure'),
            'title' => anchor('admin/pyrocourse/manage/'.$course_id, get_coursename($course_id)).' &raquo; '.lang('pyrocourse:new_lesson'),
        );

        $tabs = array(
            array(
                'title' => "General",
                'id' => "general-tab",
                'fields' => array('title', 'title_slug', 'course_id', 'introduction')
                ),
            array(
                'title' => "Publication",
                'id' => "publication-tab",
                'fields' => array('visibility', 'status')
                ),
            );

        $skips = array('allow_comment', 'trashed');

        $hidden = array('course_id');

        $defaults = array('course_id'=>$course_id);

        $this->streams->cp->entry_form('lesson', 'streams', 'new', null, true, $extra, $skips, $tabs, $hidden, $defaults);
    }
    
    /**
     * Edit a lesson entry
     *
     * We're using the entry_form function
     * to generate the edit form. We're passing the
     * id of the entry, which will allow entry_form to
     * repopulate the data from the database.
     *
     * @param   int [$id] The id of the pyrocourse to the be deleted.
     * @return  void
     */
    public function edit_lesson($id = 0)
    {
        $extra = array(
            'return' => 'admin/pyrocourse/manage_lesson/'.$id,
            'success_message' => lang('pyrocourse:lesson:submit_success'),
            'failure_message' => lang('pyrocourse:lesson:submit_failure'),
            'title' => anchor('admin/pyrocourse/manage_lesson/'.$id, 'Lesson').' &raquo; '.lang('pyrocourse:edit_lesson')
        );

        $tabs = array(
            array(
                'title' => "General",
                'id' => "general-tab",
                'fields' => array('title', 'title_slug', 'course_id', 'introduction')
                ),
            array(
                'title' => "Publication",
                'id' => "publication-tab",
                'fields' => array('visibility', 'status')
                ),
            );

        $skips = array('allow_comment', 'trashed');

        $hidden = array('course_id');

        $this->streams->cp->entry_form('lesson', 'streams', 'edit', $id, true, $extra, $skips, $tabs, $hidden);
    }

    /**
     * Delete a pyrocourse entry
     * 
     * @param   int [$id] The id of pyrocourse to be deleted
     * @return  void
     */
    public function delete_lesson($id = 0)
    {
        $lesson = $this->streams->entries->get_entry($id, 'lesson', 'streams');
        if($lesson){
            $this->streams->entries->delete_entry($id, 'lesson', 'streams');
            $this->session->set_flashdata('success', lang('pyrocourse:lesson_deleted'));
 
            redirect('admin/pyrocourse/manage/'.$lesson->course_id);
        } else {
            $this->session->set_flashdata('error', lang('pyrocourse:error_lesson_deleted'));
 
            redirect(getenv('HTTP_REFERER'));
        }
    }

    /**
     * Order the pages and record their children
     *
     * Grabs `order` and `data` from the POST data.
     */
    public function order()
    {
        $order  = $this->input->post('order');
        $data   = $this->input->post('data');
        $root_pages = isset($data['root_pages']) ? $data['root_pages'] : array();

        if (is_array($order))
        {

            foreach ($order as $i => $page)
            {
                $id = str_replace('page_', '', $page['id']);
                
                //set the order of the root pages
                $this->page_m->update($id, array('order' => $i), true);

                //iterate through children and set their order and parent
                $this->page_m->_set_children($page);
            }

            // rebuild page URIs
            $this->page_m->update_lookup($root_pages);
        }
    }

    // CONTENT FUNCTION

    public function add_content($type = 'text', $lesson_id = false)
    {
        $extra = array(
            'return' => 'admin/pyrocourse/manage_lesson/'.$lesson_id,
            'success_message' => lang('pyrocourse:content:submit_success'),
            'failure_message' => lang('pyrocourse:content:submit_failure'),
            'title' => anchor('admin/pyrocourse/manage_lesson/'.$lesson_id, get_lessonname($lesson_id)).' &raquo; '.lang('pyrocourse:add_'.$type.'_content'),
        );

        $hidden = array('lesson_id');

        $defaults = array('lesson_id'=>$lesson_id);


        $this->streams->cp->entry_form('content_'.$type, 'streams', 'new', null, true, $extra, array(), false, $hidden, $defaults);
    }

    public function edit_content($type = 'text', $content_id = false, $lesson_id = false)
    {
        $extra = array(
            'return' => 'admin/pyrocourse/manage_lesson/'.$lesson_id,
            'success_message' => lang('pyrocourse:content:submit_success'),
            'failure_message' => lang('pyrocourse:content:submit_failure'),
            'title' => anchor('admin/pyrocourse/manage_lesson/'.$lesson_id, get_lessonname($lesson_id)).' &raquo; '.lang('pyrocourse:edit_'.$type.'_content'),
        );

        $skips = array('lesson_id');

        $this->streams->cp->entry_form('content_'.$type, 'streams', 'edit', $content_id, true, $extra, $skips);
    }

// ASSIGNMENT FUNCTION //

    public function create_assignment($lesson_id = 0)
    {
        $extra = array(
            'return' => 'admin/pyrocourse/manage/'.$lesson_id,
            'success_message' => lang('pyrocourse:lesson:submit_success'),
            'failure_message' => lang('pyrocourse:lesson:submit_failure'),
            'title' => anchor('admin/pyrocourse/manage_lesson/'.$lesson_id, get_lessonname($lesson_id)).' &raquo; '.lang('pyrocourse:add_assignment'),
        );

        $skips = array('trashed');

        $hidden = array('lesson_id');

        $defaults = array('lesson_id'=>$lesson_id);

        $this->streams->cp->entry_form('assignment', 'streams', 'new', null, true, $extra, $skips, false, $hidden, $defaults);
    }
    
    /**
     * Edit a lesson entry
     *
     * We're using the entry_form function
     * to generate the edit form. We're passing the
     * id of the entry, which will allow entry_form to
     * repopulate the data from the database.
     *
     * @param   int [$id] The id of the pyrocourse to the be deleted.
     * @return  void
     */
    public function edit_assignment($id = 0)
    {
        $extra = array(
            'return' => 'admin/pyrocourse/manage_assignment/'.$id,
            'success_message' => lang('pyrocourse:lesson:submit_success'),
            'failure_message' => lang('pyrocourse:lesson:submit_failure'),
            'title' => anchor('admin/pyrocourse/manage_assignment/'.$id, 'Lesson').' &raquo; '.lang('pyrocourse:edit_assignment')
        );

        $tabs = array(
            array(
                'title' => "General",
                'id' => "general-tab",
                'fields' => array('title', 'title_slug', 'course_id', 'introduction', 'content')
                ),
            array(
                'title' => "Publication",
                'id' => "publication-tab",
                'fields' => array('visibility', 'status')
                ),
            );

        $skips = array('allow_comment', 'trashed');

        $this->streams->cp->entry_form('lesson', 'streams', 'edit', $id, true, $extra, $skips, $tabs);
    }

    /**
     * Delete a pyrocourse entry
     * 
     * @param   int [$id] The id of pyrocourse to be deleted
     * @return  void
     */
    public function delete_assignment($id = 0)
    {
        $lesson = $this->streams->entries->get_entry($id, 'lesson', 'streams');
        if($lesson){
            $this->streams->entries->delete_entry($id, 'lesson', 'streams');
            $this->session->set_flashdata('success', lang('pyrocourse:lesson_deleted'));
 
            redirect('admin/pyrocourse/manage/'.$lesson->course_id);
        } else {
            $this->session->set_flashdata('error', lang('pyrocourse:error_assignment_deleted'));
 
            redirect(getenv('HTTP_REFERER'));
        }
    }
}