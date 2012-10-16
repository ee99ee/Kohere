# Smarty Module for Kohana
[Smarty Module for Kohana](https://github.com/huffingtonpost/huffpost-kohana-smarty) is a module for the Kohana PHP framework to support clean integration of the Smarty template engine with Kohana views.

## Documentation
### Setup instructions

<ol>
    <li>Install <a href="http://kohanaframework.org/" target="_blank">Kohana</a> (3.2+)</li>
    <li>Activate module in your Kohana bootsrap.php:
<pre>
'smarty'     => MODPATH.'smarty',
</pre>
    </li>

    <li>Extend your controller class (Controller_MYNAME) from Controller_Smarty</li>

    <li>Organize template directories as you want within application/views/. You then can optionally set the path to the template directory that you want to invoke templates from. Examples:
<pre>
    $this->view->render('FOLDER_NAME/TEMPLATE_NAME'); // under /application/views/
    $this->view->render('TEMPLATE_NAME'); // will render template under current controller folder
    $this->view->render('/TEMPLATE_NAME'); // will render template under views/ directory
</pre>

By default, the module looks for templates in the following structure
<pre>
/views
      /controller        // controller name here
            /name1.tpl   // controller action name here
            /name2.tpl   // second controller action
</pre>
so if you have such template structure you can use:
<pre>
class Controller_Dashboard extends Controller_Smarty {

    public function action_name1()
    {   
         // if value 'auto_render_template'  == true will render name1.tpl template automatically
    }

    public function action_name2()
    {   
         // render name2.tpl
        $this->view->render('name2');    
    }
}
</pre>
    </li>
    <li>Assign variable values for use in templates by either:
        <ol>
            <li>Using native Smarty function:
<pre>
public function action_name1()
{    
      $this->view->assign('test', $value);
}   
</pre>
            </li>
            <li>Or use the Kohana render() method and pass data to the view:
<pre>
public function action_name1()
{    
     $array_of_variables = array
     (
           'test1' => $test1,
           'test2' => $test2,
       )

      $this->view->render('name1', $array_of_variables);
}
</pre>
            </li>
        </ol>
    </li>
</ol>

### Using with other Kohana modules
<ul>
    <li>The module does not support Kohana's cascading file system. To use this module with views in other modules, you must change the templates directory from 'APPPATH/views' to 'MODPATH/modules/mymodule/views/':
        <ol>
            <li>in 'MODPATH/modules/mymodule/views/' create template accordingly to above instructions</li>
            <li>create 'MODPATH/modules/mymodule/classes/controllers/mycontroller.php</li>
            <li>extend controller class from Controller_Smarty</li>
            <li>in the 'mymodule' controller add Controller_Smarty and add these lines to before method:
<pre>
class Controller_Mycontroller extends Controller_Smarty {
       public function before()
       {    
            parent::before();
            $this->view->set_template_dir('MODPATH/modules/mymodule/views/');
       }
       
       public function action_name1()
       {    
              $this->view->assign('test', $value); // will render MODPATH/modules/mymodule/views/name1.tpl 
       }  
}
</pre>
            </li>
        </ol>
    </li>
</ul>

## Reporting bugs
If you've stumbled across a bug, please help us out by [reporting the bug](https://github.com/huffingtonpost/huffpost-kohana-smarty/issues) you have found. Simply log in or register and submit a new issue, leaving as much information about the bug as possible, e.g.

* Steps to reproduce
* Expected result
* Actual result

This will help us to fix the bug as quickly as possible. Or, even better, if you'd like to fix it yourself feel free to [fork us on GitHub](https://github.com/huffingtonpost/huffpost-kohana-smarty/) and submit a pull request!

## LICENSE
This software is released under the Apache 2.0 open source license.
