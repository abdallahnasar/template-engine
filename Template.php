<?php

/**
 * Simple template engine class.
 *
 * @author Abdallah Nassar <abdallahnasar@gmail.com>
 */
class Template
{
    /**
     * The filename of the template to load.
     *
     * @access private
     * @var string
     */
    private $file;

    /**
     * data variables to be passed to template.
     *
     * @access private
     * @var any
     */
    private $data;

    /**
     * the stack array to save array data content in.
     *
     * @access private
     * @var array
     */
    private $stack = array();

    /**
     * counter to save iteration index of array data type.
     *
     * @access private
     * @var int
     */
    private $counter = 0;

    /**
     * Creates a new Template object and sets its associated file.
     *
     * @param string $file the filename of the template to load
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Sets a value for replacing a specific variable.
     *
     * @param string $key the name of the variable to replace
     * @param string $value the value to be replaced
     */
    public function setVar($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * save data of array variable to stack.
     *
     * @param array $element the element to store its data
     */
    public function wrap($element)
    {
        $this->stack[] = $this->data;
        foreach ($element as $k => $v) {
            $this->data[$k] = $v;
        }
    }


    /**
     * restore array data back from the stack and increment iteration counter.
     *
     */
    public function unwrap()
    {
        $this->data = array_pop($this->stack);
        $this->counter++;
    }

    /**
     * render content of template file.
     *
     */
    public function render()
    {
        if (!file_exists($this->file)) {
            exit('Error loading template file '.$this->file);
        }
        $template = file_get_contents($this->file);
        $template = preg_replace('~\{\{\#unless \@last\}\}~', '<?php if(!($this->counter == (count($this->data["Stuff"])-1)) ): ?>', $template);
        $template = preg_replace('~\{\{else\}\}~', '<?php else : ?>', $template);
        $template = preg_replace('~\{\{\/unless\}\}~', '<?php endif;  ?>', $template);
        $template = preg_replace('~\{\{(\w+)\}\}~', '<?php echo $this->data[\'$1\']; ?>', $template);
        $template = preg_replace('~\{\{\#each (\w+)\}\}~', '<?php foreach ($this->data[\'$1\'] as $ELEMENT): $this->wrap($ELEMENT); ?>', $template);
        $template = preg_replace('~\{\{\/each\}\}~', '<?php $this->unwrap(); endforeach; ?>', $template);
        $template = ' ?>' . $template;
        eval($template);
    }
}