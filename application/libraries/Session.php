<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package     Session
 * @subpackage  Libraries
 * @category    Session
 * @author     	xiefei 
 * @modified   xiefei <xiefei.admin.tw@gmail.com>
 * @date        2013-03
 */

class Session
{
    protected $app_name = '';
    protected $ci;
    protected $store = array();
    protected $flashdata_key = 'flash';

    /**
     * Constructor
     *
     * @access  public
     * @param   array   config preferences
     *
     * @return  void
     **/

    function __construct($config = array())
    {
        $this->ci = get_instance();
        $this->app_name = $this->ci->config->item('app_name');

        if ( ! isset($_SESSION))
        {
            session_start();
        }
        $this->initialize($config);

        // Delete 'old' flashdata (from last request)
        $this->_flashdata_sweep();

        // Mark all new flashdata as old (data will be deleted before next request)
        $this->_flashdata_mark();
    }

    /**
     * Initialize the configuration options
     *
     * @access  private
     * @param   array   config options
     * @return  void
     */
     private function initialize($config)
     {
        foreach ($config as $key => $val)
        {
            if (method_exists($this, 'set_'.$key))
            {
                $this->{'set_'.$key}($val);
            }
            else if (isset($this->$key))
            {
                $this->$key = $val;
            }
        }
        if(isset($_SESSION[$this->app_name]) )
        {
            $this->store = $_SESSION[$this->app_name];
            if(! $this->is_expired())
            {
                return;
            }
        }
        $this->create_session();
    }

    /**
     * Create Session
     *
     * @access  public
     * @return  void
     */
    public function create_session()
    {
        $expire_time = time() + intval($this->ci->config->item('sess_expiration'));
        $_SESSION[$this->app_name] = array(
            'session_id' => md5(microtime()),
            'expire_at' => $expire_time
        );
        $this->store = $_SESSION[$this->app_name];
    }

    /**
     * Check if session is expired
     *
     * @access  public
     * @return  void
     */
    public function is_expired()
    {
        if ( ! isset($this->store['expire_at']))
        {
            return TRUE;
        }
        return (time() > $this->store['expire_at']);
    }

    /**
     * Destroy session
     *
     * @access  public
     */
    public function sess_destroy()
    {
        $this->create_session();
    }

    /**
     * Get specific user data element
     *
     * @access  public
     * @param   string  element key
     * @return  object  element value
     */
    public function userdata($value)
    {
        if ($value == 'session_id')
        {
            return $this->store['session_id'];
        }
        if (isset($this->store[$value]))
        {
            return $this->store[$value];
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Set value for specific user data element
     *
     * @access  public
     * @param   array  list of data to be stored
     * @param   object  value to be stored if only one element is passed
     * @return  void
     */
    public function set_userdata($data = array(), $value = '')
    {
        if(is_string($data))
        {
            $data = array($data => $value);
        }
        foreach ($data as $key => $val)
        {
            $this->store[$key] = $val;
        }
        $_SESSION[$this->app_name] = $this->store;
    }

    /**
     * remove array value for specific user data element
     *
     * @access  public
     * @param   array  list of data to be removed
     * @return  void
     */
    public function unset_userdata($data = array())
    {
        if (is_string($data))
        {
            $data = array($data => '');
        }

        if (count($data) > 0)
        {
            foreach ($data as $key => $val)
            {
                unset($this->store[$key]);
            }
        }

        $_SESSION[$this->app_name] = $this->store;
    }

    /**
     * Fetch all session data
     *
     * @access  public
     * @return  array
     */
    public function all_userdata()
    {
        return $this->store;
    }

    /**
     * Add or change flashdata, only available
     * until the next request
     *
     * @access  public
     * @param   mixed
     * @param   string
     * @return  void
     */
    public function set_flashdata($newdata = array(), $newval = '')
    {
        if (is_string($newdata))
        {
            $newdata = array($newdata => $newval);
        }

        if (count($newdata) > 0)
        {
            foreach ($newdata as $key => $val)
            {
                $flashdata_key = $this->flashdata_key.':new:'.$key;
                $this->set_userdata($flashdata_key, $val);
            }
        }
    }

    /**
     * Keeps existing flashdata available to next request.
     *
     * @access  public
     * @param   string
     * @return  void
     */
    public function keep_flashdata($key)
    {
        // 'old' flashdata gets removed.  Here we mark all
        // flashdata as 'new' to preserve it from _flashdata_sweep()
        // Note the function will return FALSE if the $key
        // provided cannot be found
        $old_flashdata_key = $this->flashdata_key.':old:'.$key;
        $value = $this->userdata($old_flashdata_key);

        $new_flashdata_key = $this->flashdata_key.':new:'.$key;
        $this->set_userdata($new_flashdata_key, $value);
    }

    /**
     * Fetch a specific flashdata item from the session array
     *
     * @access  public
     * @param   string
     * @return  string
     */
    public function flashdata($key)
    {
        $flashdata_key = $this->flashdata_key.':old:'.$key;
        return $this->userdata($flashdata_key);
    }

    /**
     * Identifies flashdata as 'old' for removal
     * when _flashdata_sweep() runs.
     *
     * @access  private
     * @return  void
     */
    private function _flashdata_mark()
    {
        $userdata = $this->all_userdata();
        foreach ($userdata as $name => $value)
        {
            $parts = explode(':new:', $name);
            if (is_array($parts) && count($parts) === 2)
            {
                $new_name = $this->flashdata_key.':old:'.$parts[1];
                $this->set_userdata($new_name, $value);
                $this->unset_userdata($name);
            }
        }
    }

    /**
     * Removes all flashdata marked as 'old'
     *
     * @access  private
     * @return  void
     */
    private function _flashdata_sweep()
    {
        $userdata = $this->all_userdata();
        foreach ($userdata as $key => $value)
        {
            if (strpos($key, ':old:'))
            {
                $this->unset_userdata($key);
            }
        }
    }
}
