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

        $this->view->assign('directory',  $this->request->directory());
        $this->view->assign('controller', $this->request->controller());
        $this->view->assign('action',     $this->request->action());
        $this->view->assign('current',    $this->request->current());
        $this->view->assign('detect_uri', $this->request->detect_uri());
        $this->view->assign('directory',  $this->request->directory());

        if ($this->request->current()->is_ajax())
        {
            $this->view->set_auto_render( FALSE );
        }
    }

    public function after()
    {
        if ($this->view->is_auto_render_enabled())
        {
            $this->view->render();
        }

    }
}