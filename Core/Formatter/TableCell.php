<?php

namespace Core\Formatter;

class TableCell
{
	private $value;

	private $options = array(
		'rowspan' => 1,
		'colspan' => 1,
	)

	public function __construct($value = '', array $options = array())
	{
		if($wrongkeys = array_diff(array_keys($options), array_keys($this->options))) {
			throw new \InvalidArgumentException( sprintf('The following options are not supported: \'%s\.', implode('\',\'', $wrongkeys)) );
		}
		$this->options = array_merge($this->options, $options);
	}

	public function __toString()
	{
		return (string) $this->value;
	}

	public function getColspan()
	{
		return (int) $this->options['colspan'];
	}

	public function getRowspan()
	{
		return (int) $this->options['rowspan'];
	}

	public function getOption($key)
	{
		if(array_key_exists($key, $this->options)) {
			return $this->options[$key];
		}
		return false;
	}

	public function getCellWidth()
	{
		return strlen($this->value);
	}
}