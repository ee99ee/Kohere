<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Abstract controller class for automatic templating with smarty.
 *
 * @package    Controller
 * @author     Max Kosenko
 */
abstract class Kohana_Controller_Smarty extends Controller {

    /**
     * @var  object Smarty object
     */
    public $view = null;

    /**
     * Loads the smarty object.
     *
     * @return  void
     */
    public function before()
    {
        $this->view = new Kohana_Smarty();
        $action_dir = Kohana::$config->load('smarty.template_dir')
            . $this->request->controller() . DIRECTORY_SEPARATOR;

        // set default action directory: /views/controller_name/
        $this->view->set_view_dir( $action_dir );

        $this->view->assign('controller', $this->request->controller());
        $this->view->assign('action',     $this->request->action());
        $this->view->assign('current',    $this->request->current());
        $this->view->assign('detect_uri', $this->request->detect_uri());
        $this->view->assign('directory',  $this->request->directory());
    }

    public function after()
    {
        if ($this->view->is_auto_render_enabled())
        {
            $this->view->render(DIRECTORY_SEPARATOR . $this->request->controller() . DIRECTORY_SEPARATOR . $this->request->action());
        }

    }
}