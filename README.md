# Zend Framework Fundamentals I -- April 2018

## MVC Basics Lab
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
