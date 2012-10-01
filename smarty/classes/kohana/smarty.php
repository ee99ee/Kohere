<?php

include_once MODPATH . 'smarty/classes/lib/Smarty.class.php';
/*
 * Class for automatic templating with smarty
 */

class Kohana_Smarty extends Smarty {

    /**
     * @var  string default directory where current action situated
     */
    private $_view_dir = null;

    /**
     * @var string template extension
     **/
    private $_smarty_ext = '.tpl';

    /**
     * @var boolean render template without using render() in it
     */
    private $_auto_render_template = true;


    public function __construct()
    {
        parent::__construct();

        //setup smarty
        $kohana_config = Kohana::$config->load('smarty');

        $this->template_dir = array($kohana_config['template_dir']);
        $this->compile_dir = $kohana_config['compile_dir'];
        $this->plugins_dir = array_merge($this->plugins_dir, $kohana_config['plugin_dir']);
        $this->cache_dir = $kohana_config['cache_dir'];
        $this->caching = $kohana_config['cache'];
        $this->force_compile = $kohana_config['force_compile'];
        $this->debugging = $kohana_config['debug'];
        $this->error_reporting = $kohana_config['error_reporting'];
        $this->php_handling =  $kohana_config['php_handling'];
        $this->_auto_render_template = $kohana_config['auto_render_template'];
    }

    /*
     * lets generate smarty templates views
     * You could setup any places within application/views/ folder where your *.tpl files position is.
     * Template examples:
     *    '/index' - will address to /application/views/index.tpl
     *    '/welcome/test' - will address to /application/views/welcome/test.tpl
     *    'index' - if you run it from controller welcome will adress to application/views/welcome/index.tpl
     *
     * @param  string template name without .tpl extension
     * @param  array  array( 'var1' => values )
     * @return void
     *
     */
    public function render($template, $assign = null)
    {
        $template = rtrim($template, '/'); // clean up ending of template, e.g. welcome/index/ to welcome/index
        if (strpos($template, '/') !== false)
        {
            $template = rtrim(Kohana::$config->load('smarty.template_dir'), DIRECTORY_SEPARATOR) . $template . $this->_smarty_ext;
        }
        else
        {
            $template = $this->_view_dir . $template . $this->_smarty_ext;
        }

        if ($assign)
        {
            $this->assign_all($assign);
        }

        $this->display($template);
    }

    /*
     * assigne variables to template view
     * @param array
     * @return boolean
     */
    public function assign_all($assign)
    {
        if (!is_array($assign)) { return false; }

        foreach ($assign as $key => $value)
        {
            $this->assign($key, $value);
        }
        return true;
    }

    /*
     * setup default directory where view is situated
     * @param string controller name
     * @return void
     */
    public function set_view_dir( $view_dir )
    {
        $this->_view_dir = $view_dir;
    }

    /*
     * simple flag method need to check $_auto_render_template
     * @param void
     * @return boolean
     */
    public function is_auto_render_enabled()
    {
        return (boolean) $this->_auto_render_template;
    }

    /*
     * change auto render value
     * @param boolean
     * @return void
     */
    public function set_auto_render( boolean $value) {
        $this->_auto_render_template = $value;
    }
}
