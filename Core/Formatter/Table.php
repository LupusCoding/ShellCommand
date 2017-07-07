<?php

namespace Core\Formatter;

class Table
{
	private $headers = array();
	private $rows = array();
	private $columnWidth = array();
	private $numberOfColumns = null;
	private $output;
	private $styles;
	private $style;

	public function __construct()
	{
		$this->initStyle();
	}

	public function setHeaders(array $headers)
	{
		$headers = array_values($headers);
		if(!empty($headers) && !is_array($headers[0])) {
			$headers = array($headers);
		}

		$this->headers = $headers;

		return $this;
	}

	public function setRows(array $rows)
	{
		$this->rows = array();

		return $this->addRows($rows);
	}

	public function addRows($rows)
	{
		foreach ($rows as $row) {
			$this->addRow($row);
		}

		return $this;
	}

	public function addRow($row)
	{
		$this->rows[] = array_values($row);

		return $this;
	}

	public function setStyle($key)
	{
		$this->style = $this->styles[$key];

		return $this;
	}

	public function render()
	{
		$table = array();

		$this->calculateNumberOfColumns();
		if($this->numberOfColumns === null) {
			throw new Exception('Error Processing ' . __METHOD__ . '.',0x1);
		}

		/* HEADER */
		$table[] = $this->getRowSeparator();
		if(!empty($this->headers)) {
			foreach ($this->headers as $hrow) {
				$table[] = $this->renderRow($hrow);
			}
			$table[] = $this->getRowSeparator();
		}

		/* CONTENT */
		foreach ($this->rows as $row) {
			$table[] = $this->renderRow($row);
		}
		$table[] = $this->getRowSeparator();

		return $table;
	}


	private function initStyle()
	{
		$default = new TableStyle();

		$this->style['default'] = $default;

		$this->setStyle('default');
	}

	private function getNumberOfColumns(array $row)
	{
		$columns = count($row);
		return $columns;
	}

	private function calculateNumberOfColumns()
	{
		if(null !== $this->numberOfColumns) {
			return;
		}

		$columns = array(0);
		foreach (array_merge($this->headers, $this->rows) as $row) {
			$columns[] = $this->getNumberOfColumns($row);
		}

		return $this->numberOfColumns = max($columns);
	}

	private function getCellWidth(TableCell $cell, $decorate = true)
	{
		$cellWidth = $cell->getCellWidth();
		if($decorate) {
			$padding = $this->style->getPaddingChar();
			$cellWidth = strlen($padding . $cell->__toString() . $padding);
		}

		if($cell->getColSpan() > 1) {
			$cellWidth = $cellWidth / $cell->getColSpan();
		}

		return strlen($cellValue);
	}

	private function getColumnWidth($column)
	{
		$length = array();
		foreach (array_merge($this->headers, $this->rows) as $row) {
			$length[] = $this->getCellWidth($row[$column]);
		}

		return max($length);
	}

	private function getRowSeparator()
	{
		if(0 === $count = $this->numberOfColumns) {
			return;
		}

		$markup = $this->style->getCrossBorderChar();
		for($column = 0; $column < $count; ++$column) {
			$markup .= str_repeat($this->style->getHorizontalBorderChar(), $this->getColumnWidth($column));
			$markup .= $this->style->getCrossBorderChar();
		}

		return $markup;
	}

	private function renderColumn(TableCell $cell, $column)
	{
		return str_pad($cell, (int)($this->getColumnWidth($column) - $this->getCellWidth($cell) - 2), $this->style->getPadType());
	}

	private function renderRow($row)
	{
		if(0 === $count = $this->numberOfColumns) {
			return;
		}

		$markup = $this->style->getVerticalBorderChar();
		for($column = 0; $column < $count; ++$column) {
			$markup .= $this->renderColumn($row[$column], $column);
			$markup .= getVerticalBorderChar();
		}

		return $markup;
	}


}