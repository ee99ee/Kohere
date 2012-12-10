<?php

include_once MODPATH . 'smarty/classes/lib/Smarty.class.php';
/*
 * Class for automatic templating with smarty
 */

class Kohana_Smarty extends Smarty {

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

        $this->template_dir = $kohana_config['template_dir'];
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
    public function render($template_path = null, $assign = null)
    {
        $template_path = $this->_get_curr_template_path($template_path);

        if ($assign)
        {
            $this->assign_all($assign);
        }

        $this->display($template_path);
        exit();
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
    public function set_template_dir( $template_dir )
    {
        $this->template_dir = strip_tags( $template_dir );
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
    public function set_auto_render( $value ) {
        if ( !is_bool($value) ) { return false; }
        $this->_auto_render_template = $value;
    }

    /*
     * method returns physical path where requested template is positioned
     * e.g. path to application/view/account/logout.tpl
     *      1. 'account/logout' or 'account/logout/' or '/account/logout/'
     *      2. if controller is 'account' and controller action is 'logout' $template_path can be choosed automatically
     *
     * @param string path to template inside views directory,
     * @return mixed (string|boolean)
     */
    private function _get_curr_template_path( $template_path = null )
    {
        $template_path = empty($template_path) ? $this->tpl_vars['action']->value : $template_path;
        // get root path of 'views' directory e.g: application/views
        $curr_template_path = rtrim( $this->template_dir[0], DIRECTORY_SEPARATOR );

        if ( strpos($template_path, DIRECTORY_SEPARATOR ) === false)
        {
            if ( !empty( $this->tpl_vars['directory']->value ))
            {
                $curr_template_path .= DIRECTORY_SEPARATOR . $this->tpl_vars['directory']->value;
            }

            if ( !empty( $this->tpl_vars['controller']->value ))
            {
                $curr_template_path .= DIRECTORY_SEPARATOR . $this->tpl_vars['controller']->value;
            }
        }

        // clean up ending of template, e.g. welcome/index/ to welcome/index
        $curr_template_path .= DIRECTORY_SEPARATOR . trim($template_path, DIRECTORY_SEPARATOR) . $this->_smarty_ext;
        $curr_template_path = strip_tags( $curr_template_path );

        if (is_file($curr_template_path))
        {
            return $curr_template_path;
        }

        return false;
    }
}
