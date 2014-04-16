<?php

/**
 * This file is part of the Nette Framework (http://nette.org)
 * Copyright (c) 2004 David Grudl (http://davidgrudl.com)
 */

namespace Nette\DI\Config\Adapters;

use Nette,
	Nette\DI\Config\Helpers,
	Nette\Utils\Neon;


/**
 * Reading and generating NEON files.
 *
 * @author     David Grudl
 */
class NeonAdapter extends Nette\Object implements Nette\DI\Config\IAdapter
{
	/** @internal */
	const INHERITING_SEPARATOR = '<', // child < parent
		PREVENT_MERGING = '!';

	/**
	 * Reads configuration from NEON file.
	 * @param  string  file name
	 * @return array
	 */
	public function load($file)
	{
		return $this->process((array) Neon::decode(file_get_contents($file)));
	}


	private function process(array $arr)
	{
		$res = array();
		foreach ($arr as $key => $val) {
			if (substr($key, -1) === self::PREVENT_MERGING) {
				if (!is_array($val) && $val !== NULL) {
					throw new Nette\InvalidStateException("Replacing operator is available only for arrays, item '$key' is not array.");
				}
				$key = substr($key, 0, -1);
				$val[Helpers::EXTENDS_KEY] = Helpers::OVERWRITE;

			} elseif (preg_match('#^(\S+)\s+' . self::INHERITING_SEPARATOR . '\s+(\S+)\z#', $key, $matches)) {
				if (!is_array($val) && $val !== NULL) {
					throw new Nette\InvalidStateException("Inheritance operator is available only for arrays, item '$key' is not array.");
				}
				list(, $key, $val[Helpers::EXTENDS_KEY]) = $matches;
				if (isset($res[$key])) {
					throw new Nette\InvalidStateException("Duplicated key '$key'.");
				}
			}

			if (is_array($val)) {
				$val = $this->process($val);
			} elseif ($val instanceof Nette\Utils\NeonEntity) {
				$val = (object) array('value' => $val->value, 'attributes' => $this->process($val->attributes));
			}
			$res[$key] = $val;
		}
		return $res;
	}


	/**
	 * Generates configuration in NEON format.
	 * @return string
	 */
	public function dump(array $data)
	{
		$tmp = array();
		foreach ($data as $name => $secData) {
			if ($parent = Helpers::takeParent($secData)) {
				$name .= ' ' . self::INHERITING_SEPARATOR . ' ' . $parent;
			}
			$tmp[$name] = $secData;
		}
		return "# generated by Nette\n\n" . Neon::encode($tmp, Neon::BLOCK);
	}

}
