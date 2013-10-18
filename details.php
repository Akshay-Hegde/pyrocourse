<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Pyrocourse extends Module
{
    public $version = '1.0';

    public function info()
    {
        $info = array(
            'name' => array(
                'en' => 'PyroCourse'
            ),
            'description' => array(
                'en' => 'Online Course Management for PyroCMS'
            ),
            'frontend' => true,
            'backend' => true,
            'menu' => 'content',
            'sections' => array(
                'course' => array(
                    'name' => 'pyrocourse:courses',
                    'uri' => 'admin/pyrocourse',
                    'shortcuts' => array(
                        'create' => array(
                            'name' => 'pyrocourse:new_course',
                            'uri' => 'admin/pyrocourse/create_course',
                            'class' => 'add'
                        )
                    )
                ),
                'student' => array(
                    'name' => 'pyrocourse:student',
                    'uri' => 'admin/pyrocourse',
                    'shortcuts' => array(
                        'create' => array(
                            'name' => 'pyrocourse:new_course',
                            'uri' => 'admin/pyrocourse/create',
                            'class' => 'add'
                        )
                    )
                ),
                'task' => array(
                    'name' => 'pyrocourse:submission',
                    'uri' => 'admin/pyrocourse',
                    'shortcuts' => array(
                        'create' => array(
                            'name' => 'pyrocourse:new_course',
                            'uri' => 'admin/pyrocourse/create_course',
                            'class' => 'add'
                        )
                    )
                )
            )
        ); //end $info

        // if($this->uri->segment(3) == 'manage')
        //     $info['sections']['course']['shortcuts'] = array(
        //         'new_lesson' => array(
        //             'name' => 'pyrocourse:new_lesson',
        //             'uri' => 'admin/pyrocourse/lesson/new/'.$this->uri->segment(4),
        //             'class' => 'add'
        //         )
        //     );
        
        return $info;
    }

    /**
     * Install
     *
     * This function will set up our
     * pyrocourse/Category streams.
     */
    public function install()
    {
        // // We're using the streams API to
        // // do data setup.
        // $this->load->driver('Streams');

        // $this->load->language('pyrocourse/pyrocourse');

        // // Add pyrocourses streams
        // if ( ! $this->streams->streams->add_stream('lang:pyrocourse:pyrocourses', 'pyrocourses', 'pyrocourse', 'pyrocourse_', null)) return false;
        // if ( ! $categories_stream_id = $this->streams->streams->add_stream('lang:pyrocourse:categories', 'categories', 'pyrocourse', 'pyrocourse_', null)) return false;

        // //$pyrocourse_categories

        // // Add some fields
        // $fields = array(
        //     array(
        //         'name' => 'Question',
        //         'slug' => 'question',
        //         'namespace' => 'pyrocourse',
        //         'type' => 'text',
        //         'extra' => array('max_length' => 200),
        //         'assign' => 'pyrocourses',
        //         'title_column' => true,
        //         'required' => true,
        //         'unique' => true
        //     ),
        //     array(
        //         'name' => 'Answer',
        //         'slug' => 'answer',
        //         'namespace' => 'pyrocourse',
        //         'type' => 'textarea',
        //         'assign' => 'pyrocourses',
        //         'required' => true
        //     ),
        //     array(
        //         'name' => 'Title',
        //         'slug' => 'pyrocourse_category_title',
        //         'namespace' => 'pyrocourse',
        //         'type' => 'text',
        //         'assign' => 'categories',
        //         'title_column' => true,
        //         'required' => true,
        //         'unique' => true
        //     ),
        //     array(
        //         'name' => 'Category',
        //         'slug' => 'pyrocourse_category_select',
        //         'namespace' => 'pyrocourse',
        //         'type' => 'relationship',
        //         'assign' => 'pyrocourses',
        //         'extra' => array('choose_stream' => $categories_stream_id)
        //     )
        // );

        // $this->streams->fields->add_fields($fields);

        // $this->streams->streams->update_stream('pyrocourses', 'pyrocourse', array(
        //     'view_options' => array(
        //         'id',
        //         'question',
        //         'answer',
        //         'pyrocourse_category_select'
        //     )
        // ));

        // $this->streams->streams->update_stream('categories', 'pyrocourse', array(
        //     'view_options' => array(
        //         'id',
        //         'pyrocourse_category_title'
        //     )
        // ));

        return true;
    }

    /**
     * Uninstall
     *
     * Uninstall our module - this should tear down
     * all information associated with it.
     */
    public function uninstall()
    {
        $this->load->driver('Streams');

        // For this teardown we are using the simple remove_namespace
        // utility in the Streams API Utilties driver.
        $this->streams->utilities->remove_namespace('pyrocourse');

        return true;
    }

    public function upgrade($old_version)
    {
        return true;
    }

    public function help()
    {
        // Return a string containing help info
        // You could include a file and return it here.
        return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
    }

}