<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Email Template Events Class
 *
 * @author      Stephen Cozart
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Templates
 */
class Events_Pyrocourse {

    protected $ci;

    public function __construct()
    {
        $this->ci =& get_instance();

        //register the stream event
        Events::register('streams_post_insert_entry', array($this, 'save_additional'));
        Events::register('streams_post_update_entry', array($this, 'update_additional'));
    }

    public function save_additional($data = array())
    {
        $this->ci =& get_instance();

        // dump($data);
        if(substr($data['stream']->stream_slug, 0, 7) == 'content' AND $data['stream']->stream_prefix == 'pc_'){
            $this->ci->load->driver('Streams');

            $entry = array(
                'content_type' => substr($data['stream']->stream_slug, 8),
                'content_id' => $data['entry_id'],
                'lesson_id' => $data['insert_data']['lesson_id']
            );
            $this->ci->streams->entries->insert_entry($entry, 'lesson_content', $data['stream']->stream_namespace);
        }
    }
}
/* End of file events.php */