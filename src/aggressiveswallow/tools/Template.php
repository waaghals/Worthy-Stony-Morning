<?php

namespace Aggressiveswallow\Tools;

/**
 * Expends the set variables as variables in the loaded viewfile.
 *
 * @author Patrick
 */
class Template
{

    protected $template;
    protected $variables = array();
    private $viewLocation;

    /**
     *
     * @param string $template Name of the template file to use
     */
    public function __construct($template)
    {
        $this->viewLocation = VIEW_PATH;
        $this->template     = $this->viewLocation . DS . $template . ".phtml";

        if (!file_exists($this->template)) {
            $msgString = "No valid viewFile exists. Tried to find \"%s\" using path \"%s\".";
            $msg       = sprintf($msgString, $template, $this->template);
            throw new \Exception($msg);
        }
    }

    public function __get($key)
    {
        return $this->variables[$key];
    }

    public function __set($key, $value)
    {
        $this->variables[$key] = $value;
    }

    /**
     * Returns the generated view
     * @return string
     */
    public function __toString()
    {
        try {
            //Create local variables from our array of variables.
            extract($this->variables);
            //chdir(dirname($this->template)); Don't change to the tempate dir, this breaks autoloading
            ob_start();

            include $this->template;

            return ob_get_clean();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

}
