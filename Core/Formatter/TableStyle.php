<?php

namespace Core\Formatter;

class TableStyle
{
	private $paddingChar = ' ';
	private $horizontalBorderChar = '-';
	private $verticalBorderChar = '|';
	private $crossBorderChar = '+';
	private $padType = STR_PAD_RIGHT;

	public function setPaddingChar($paddingChar)
	{
		if(!$paddingChar) {
			throw new \Exception('The padding char must not be empty');
		}

		$this->paddingChar = $paddingChar;

		return $this;
	}

	public function getPaddingChar()
	{
		return $this->paddingChar;
	}

	public function setHorizontalBorderChar($borderChar)
	{
		if(!$borderChar) {
			throw new \Exception('The horizontal border char must not be empty');
		}

		$this->horizontalBorderChar = $borderChar;

		return $this;
	}

	public function getHorizontalBorderChar()
	{
		return $this->horizontalBorderChar;
	}

	public function setVerticalBorderChar($borderChar)
	{
		if(!$borderChar) {
			throw new \Exception('The vertical border char must not be empty');
		}

		$this->verticalBorderChar = $borderChar;

		return $this;
	}

	public function getVerticalBorderChar()
	{
		return $this->verticalBorderChar;
	}

	public function setCrossBorderChar($borderChar)
	{
		if(!$borderChar) {
			throw new \Exception('The cross border char must not be empty');
		}

		$this->crossBorderChar = $borderChar;

		return $this;
	}

	public function getCrossBorderChar()
	{
		return $this->crossBorderChar;
	}

	public function setPadType($padType)
	{
		if(!in_array($padType, array(STR_PAD_LEFT, STR_PAD_RIGHT, STR_PAD_BOTH), true)) {
			throw new \InvalidArgumentException('The padType must be one of the following: STR_PAD_LEFT, STR_PAD_RIGHT, STR_PAD_BOTH.');
		}

		$this->padType = $padType;

		return $this;
	}

	public function getPadType()
	{
		return $this->padType;
	}

}