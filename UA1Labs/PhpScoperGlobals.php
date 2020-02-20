<?php

namespace UA1Labs;

/**
 *    __  _____   ___   __          __
 *   / / / /   | <  /  / /   ____ _/ /_  _____
 *  / / / / /| | / /  / /   / __ `/ __ `/ ___/
 * / /_/ / ___ |/ /  / /___/ /_/ / /_/ (__  )
 * `____/_/  |_/_/  /_____/`__,_/_.___/____/
 *
 * @author UA1 Labs Developers https://ua1.us
 * @copyright Copyright (c) UA1 Labs
 */

class PhpScoperGlobals
{
    /**
     * Used to register a global function dependency that was not brought in through composer.
     *
     * @param string $functionName The function name
     * @return boolean If the global function was successfully registered.
     */
    static public function registerGlobalFunction($functionName)
    {
        $namespace = self::getScopedNamespace();
        if ($namespace) {
            if (!function_exists($namespace . '\\' . $functionName)) {
                $defineFn = 'namespace ' . $namespace . '{function ' . $functionName . '(){return \\' . $functionName . '(...func_get_args());}}';
                eval($defineFn);
                return true;
            }
        }
        return false;
    }

    /*
     * Used to register a global class dependency that was not brought in through composer.
     *
     * @param string $className The global class name
     * @return boolean If the global class was successfully registered.
     */
    static public function registerGlobalClass($className)
    {
        $namespace = self::getScopedNamespace();
        if ($namespace) {
            if (!\class_exists($namespace . '\\', '', $className)) {
                $alias = \str_replace($namespace . '\\', '', $className);
                if (\class_exists($alias) || \interface_exists($alias)) {
                    \class_alias($className, $alias, \false);
                    return true;
                }
            }
        }
        return false;
    }

    /*
     * Used to register a global interface dependency that was not brought in through composer.
     *
     * @param string $interfaceName The global interface name
     * @return boolean If the global interface was successfully registered.
     */
    static public function registerGlobalInterface($interfaceName)
    {
        $namespace = self::getScopedNamespace();
        if ($namespace) {
            if (!\interface_exists($namespace . '\\' . $interfaceName)) {
                $alias = \str_replace($namespace . '\\', '', $interfaceName);
                if (\class_exists($alias) || \interface_exists($alias)) {
                    \class_alias($interfaceName, $alias, \false);
                    return true;
                }
            }
        }
        return false;
    }

    /*
     * Returns current namespace minus the UA1Labs starting point
     * to get us back to the global relative namespace.
     *
     * @return string The relative global namespace
     */
    static private function getScopedNamespace()
    {
        
        return str_replace(['\\UA1Labs', 'UA1Labs'], '', __NAMESPACE__);
    }
}