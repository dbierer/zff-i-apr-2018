# Zend Framework Fundamentals I -- April 2018

## LABS TO DO:
### For Weds 18 April 2018:
* Lab: Creating and Accessing a Service
* Lab: Manipulating Views and Layouts

## Re: Routing
* Why does "Literal" not work for child when controller not specified
  * When you use "Segment" controller inherits OK?

## View: Escaping
### Examples
```
<h3>Examples of Escaping:</h3>
View Page Source to See Results
<ul>
<li><?php echo $this->escapeHtml('<bad>tag</bad>!@#$%^&'); ?></li>
<li>Escaping Javascript
<script>
function whatever {
   var url="<?= $this->escapeJs('http://evil.php?c=send_me_all_your_money'); ?>";
   alert(url);
}
</script>
</li>
<li>Escaping CSS
<style>
background-image {
  url:<?= $this->escapeCss("http://hackers.com?steal=yes"); ?>
}
</style>
</li>
<li><?= $this->escapeUrl("http://www.google.com/"); ?></li>
<li>Escaping Attributes
<img src="<?= $this->escapeHtmlAttr("<script>alert('test');</script>"); ?>" /></li>
</ul>
```
### Results
```
<h3>Examples of Escaping:</h3>
View Page Source to See Results
<ul>
<li>&lt;bad&gt;tag&lt;/bad&gt;!@#$%^&amp;</li>
<li>Escaping Javascript
<script>
function whatever {
   var url="http\x3A\x2F\x2Fevil.php\x3Fc\x3Dsend_me_all_your_money";
   alert(url);
}
</script>
</li>
<li>Escaping CSS
<style>
background-image {
  url:http\3A \2F \2F hackers\2E com\3F steal\3D yes}
</style>
</li>
<li>http%3A%2F%2Fwww.google.com%2F</li>
<li>Escaping Attributes
<img src="&lt;script&gt;alert&#x28;&#x27;test&#x27;&#x29;&#x3B;&lt;&#x2F;script&gt;" /></li>
</ul>
```

## VM Notes

### guestbook project
* Need to update the database structure:
  * From the browser go to `http://localhost/`
  * Select `phpMyAdmin`
  * Select `guestbook`
  * Select `SQL`
  * Paste in the following:
```
CREATE TABLE `entry` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
* To test:
  * From the browser: `http://guestbook/guestbook`
  * Enter the requested info and post
  * Check to make sure your entry has been posted

### onlinemarket.work
* Might want to create a link on the "homepage" which appears when you enter `http://localhost/`
```
<a href=http://onlinemarket.work>onlinemarket.work</a></br>
```

## Controllers and Plugins
* Command line tool for generating factories:
```
cd /path/to/onlinemarket.work
vendor/bin/generate-factory-for-class Name\\Of\\Class
```

### Lab: New Controllers and Factories

This is a lab covering the development of two new controllers, two controller factories, and associated layouts

There is also an update to the IndexController adding a factory and getting it ready for additional code.

* PostController
* PostControllerFactory
* Post View Template
* ViewController
* ViewControllerFactory
* View View Template
* IndexControllerFactory

#### PostController

This part creates a new PostController class, extending the AbstractActionController, with an indexAction(). This serves as a placeholder for code yet to be developed.

1. Create a new Market\src\Controller\PostController class.
2. Add a indexAction() method that returns a new ViewModel instance.

```
namespace Market\Controller;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
class PostController extends AbstractActionController {
    public function indexAction() {
        return new ViewModel();
    }
}
```
#### PostControllerFactory

3. Create a new Market\src\Controller\Factory\PostControllerFactory that extends the FactoryInterface
4. Inside the __invoke() method, instantiate a new PostController instance and return it. This factory class is a placeholder for code additions forthcoming.

```
namespace Market\Controller\Factory;
use Market\Controller\PostController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
class PostControllerFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName,
                             array $options = null) {
        return new PostController();
    }
}
```

#### Register PostController

5. Register the new PostController and PostControllerFactory with the service container in the Market module.config.php.
```
'controllers' => [
    'factories' => [
        Controller\PostController::class =>
            Controller\Factory\PostControllerFactory::class
    ],
],
```
6. Create a new view template here: Market\view\market\post\index.phtml.
7. Add the view template code below:
```
<h1>Online Market Posting</h1>
<hr />
```
#### View Path Stack

8. In the Market module.config.php file, make sure the view_manager => template_path_stack key points to the correct view folder
```
return [
    ...
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
```
#### Route to PostController

9. Create a new child segment route for the PostController and add it to Market module.config.php, so that the PostController::indexAction() is reached.
```
'market' => [
    'type' => Literal::class,
    'options' => [
        'route' => '/market',
        ...
    ],
    'may_terminate' => true,
    'child_routes' => [
        'post' => [
            'type' => Segment::class,
            'options' => [
                'route' => '/post[/]',
                'defaults' => [
                    'controller' => Controller\PostController::class,
                    'action' => 'index',
                ],
        ],
]]],...
```
#### ViewController

10. Create a new Market\src\Controller\ViewController that extends the AbstractActionController
11. Instantiate a new ViewModel instance and return it. This controller class is a placeholder for code additions forthcoming.
```
namespace Market\Controller;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
class ViewController extends AbstractActionController {
    public function indexAction() {
        return new ViewModel();
    }
}
```
#### ViewControllerFactory

12. Create a new Market\src\Controller\Factory\ViewControllerFactory that extends the FactoryInterface
13. Inside the __invoke() method, instantiate a new ViewController instance and return it. This factory class is a placeholder for code additions forthcoming.
```
namespace Market\Controller\Factory;
use Market\Controller\ViewController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
class ViewControllerFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName,
                             array $options = null) {
        return new ViewController();
    }
}
```
#### Register ViewController

14. Register the new ViewController, and ViewControllerFactory with the service container in the module.config.php.
```
'controllers' => [
    'factories' => [
        Controller\PostController::class =>
            Controller\Factory\PostControllerFactory::class,
        Controller\ViewController::class =>
            Controller\Factory\ViewControllerFactory::class
    ],
],
```
15. Create a new view template here: Market\view\market\view\index.phtml.
16. Add the view template code below:
```
<h1><?= 'In ViewController, index layout' ?></h1>
<hr>
```
#### Route to ViewController

17. Create a new child segment route for the ViewController and add it to Market module.config.php, so that the ViewController::indexAction() method is reached.
```
'market' => [
    'type' => Literal::class,
    'options' => [
        'route' => '/market',
        ...
    ],
    'may_terminate' => true,
    'child_routes' => [
        'post' => [...],
        'view' => [
            'type' => Segment::class,
            'options' => [
                'route' => '/view[/]',
                'defaults' => [
                    'controller' => Controller\ViewController::class,
                    'action'     => 'index',
                ],
            ],
]]],...
```
#### IndexControllerFactory

18. Create a new Market\src\Controller\IndexControllerFactory that extends the FactoryInterface
19. Inside the __invoke() method, instantiate a new IndexController instance and return it. This factory class is a placeholder for code additions forthcoming.
```
namespace Market\Controller\Factory;
use Market\Controller\IndexController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
class IndexControllerFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName,
                             array $options = null) {
        return new IndexController();
    }
}
```
#### Update IndexController Config

20. Update the IndexController, and IndexControllerFactory with the service container in the module.config.php.
```
'controllers' => [
    'factories' => [
        Controller\PostController::class =>
            Controller\Factory\PostControllerFactory::class,
        Controller\ViewController::class =>
            Controller\Factory\ViewControllerFactory::class,
        Controller\IndexController::class =>
            Controller\Factory\IndexControllerFactory::class
    ],
],
```
* Run each new controller: http://onlinemarket.work/market/post, and http://onlinemarket.work/market/view
* If it works and you see the Post and View layouts rendered, GREAT! You're HOT!
* If not, go back and fix what's wrong.

### Lab: FlashMessenger Plugin

In this exercise, we're going to get hands on with controller plugins. Configure Market\Controller\IndexController::indexAction() so that it passes any messages from the flashMessenger plugin to the view.

1. Use Composer to install the flashMessenger plugin
```
composer require zendframework/zend-mvc-plugin-flashmessenger
```
2. Open the Market\src\Controller\IndexController.php file. Within the indexAction() method, pass the output of flashMessenger()->getMessages() to the view model
```
public function indexAction(){
    return new ViewModel(['messages' => $this->flashMessenger()->getMessages()]);
}
```
3. Open Market/view/market/index/index.phtml
4. Use the htmlList() view helper to display messages
```
<?php
if (isset($this->messsages)) {
    echo $this->htmlList($this->messages);
}
?>
```
### Lab: Params and Redirect Plugins

Configure Market/Controller/ViewController::indexAction() to use the params() plugin to accept a category from the route. Redirect to the market route if no category is found.
1. Open the Market\src\Controller\ViewController.php file. Within the indexAction() method, assign the output of params() to $category and pass the value to the view model
2. If there is no category, add a flashMessenger() message to that effect and redirect to the market route
```
public function indexAction(){
    $category = $this->params()->fromRoute('category', FALSE);
    if (!$category) {
        $this->flashMessenger()->addMessage('No Category Found');
        return $this->redirect()->toRoute('market');
    }
    return new ViewModel(['category' => $category]);
}
```
3. Open Market/view/market/view/index.phtml
4. Display the category
```
<h1><?= $this->category ?></h1>
```
5. Modify the module.config.php file in the Market module to accept a parameter category when accessing the route to the ViewController. Open the Market/config/module.config.php file. Use a Segment route to accept a parameter category
```
// other configuration not shown
'view' => [
    'type' => Segment::class,
    'options' => [
        'route' => '/view[/:category]',
        'defaults' => [
            'controller' => Controller\ViewController::class,
            'action'     => 'index',
        ],
    ],
]
```

## MVC Basics
### Lab: Create a New Module

In this lab, we're going to create a new module. (reference the onlinemarket.complete project as needed):

1. Create the module directory structure including a Module.php class and module configuration as shown in the previous slides, naming the module "Market".
2. In Module.php create a method getConfig() which returns the value of the module's config/module.config.php file.
3. Enable the module, adding it to onlinemarket.work\config\modules.config.php.
4. Add the new module namespace to the project composer.json "psr-4" autoload key, execute in a shell at the project root the command: composer dump-autoload to update the autoloader.
```
IMPORTANT: do not forget to update the filesystem permissions!
```

### Lab: Create and Configure a New Controller

5. Create a class \Market\Controller\IndexController, extend AbstractActionController, and include one public method "indexAction()".
6. Within the new IndexController::indexAction(), instantiate a new ViewModel object, passing the constructor an array with some data, and return it.
7. Create the Market module's configuration file Market\config\module.config.php
   1.  Make sure the module namespace is indicated at the beginning of the file.
   2.  Under the controllers key activate IndexController using Zend\ServiceManager\Factory\InvokableFactory.
   3.  Add a literal route to the router key for the Market IndexController and action.

### Lab: Create a View Template

8. Create a template file for the index action here: Market\view\market\index\index.phtml.
9. Insert a div tag and a call to the renderer ($this) for the variables passed to the IndexController's ViewModel constructor, and echo them.
10. Open the browser and enter this URL: http://onlinemarket.work/market.
11. If everything looks good, great!, you're ready to move forward, otherwise check everything again and test.


