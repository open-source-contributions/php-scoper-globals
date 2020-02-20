# php-scoper-globals
A library that adds the capability to scope external global functions into our PHP project scoped with humbug/php-scoper.

## The Problem

When working with [humbug/php-scoper](https://github.com/humbug/php-scoper), using function or class dependencies not registered through Composer becomes an issue after you have compiled your project using `php-scoper add-prefix`. 

Example:

    <?php
    class MyAwesomeClass 
    {
        public function myAddActionFn($action, $options)
        {
            \add_action($action, $options);
        }
    }

Outcome:

    <?php
    namespace PhpSopefswfw3r__;
    class MyAwesomeClass 
    {
        public function myAddActionFn($action, $options)
        {
            PhpSopefswfw3r__\add_action($action, $options);
        }
    }

The real problem we need to solve for is that `\add_action($action, $options);` becomes `PhpSopefswfw3r__\add_action($action, $options);`. PhpScoper is designed to append the namespace to each method because it assumes that the method you are using was pulled in using Composer. Meaning that somewhere in your code, the `\add_action($action, $options);` would have been namespaced as well. Now this is a perfect assumption because you are saying you want to scope your entire project and its dependencies so that you can distribute your library without version clashing when it is pulled into another project. You can better control the end user experience and the end user can have the confidence that they will not need to do those endless debugging sessions to figure out why their project won't work. It's a win-win for everyone.

**Whitelisting Classes/Functions/Globals**

`humbug/php-scoper` provides you a way to "whitelist" classes/functions/globals. There is a misconception on what this is used for. I've seen where many have tried to whitelist the functions/classes that they needed from external dependencies for internal functionality. But That is not what these setting are providing. Rather these whitelist setting provide a way for you to expose your API to the world. So if you create a function you in the global namespace within your project, it will leave it in the global namespace. This way, when end users go to implement your library, they will not have to enter the `PhpSopefswfw3r__` namespace to gain access to the functions you want them to have access to.

## The Solution

Add the external global class or function to the namespace prefixed by `php-scoper add-prefix`. This library does just that. It creates an alias of the function/class you are referencing in your library and assigns it to the global funciton/class that defines it.

## Getting Started

To ensure that a global function/class/interface is defined in the namespace added by `humbug/php-scoper`, use the following example:

    \UA1Labs\PhpScoperGlobals::registerGlobalFunction('myGlobalFunction');
    
    \UA1Labs\PhpScoperGlobals::registerGlobalClass('MyGlobalClass');
    
    \UA1Labs\PhpScoperGlobals::registerGlobalInterface('MyGlobalInterface');
    
Pretty much that's it!