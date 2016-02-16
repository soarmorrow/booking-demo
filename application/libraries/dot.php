<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dot
{
  protected 	$ci;
  protected		$output = array();
  protected 	$initial;
  protected 	$glue = '';

	public function __construct()
	{
        $this->ci =& get_instance();
	}

	function draw_graph($name = 'graph') {
		// $this->output .= "digraph $name {";
		$this->initial = "digraph $name {";
		return $this;
	}

	function node($name) {
		$this->output[] = $name . ';';
		return $this;
	}

	function define_node($node_name, $string) {
		$string = chunk_split($string, 20, '\n');
		$this->output[] = $node_name.' [label="'.$string.'"];';
		return $this;
	}

	function relate($source, $target) {
		$this->output[] = $source . '->' . $target . ';' ;
	}	

	function render() {
		array_unshift($this->output, $this->initial);
		$this->output[] = '}';
		$output = implode($this->glue, $this->output);
		return $output;
	}

}

/* End of file dot.php */
/* Location: ./application/libraries/dot.php */
