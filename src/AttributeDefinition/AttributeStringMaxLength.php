<?php
/*
 * @copyright   Copyright (C) 2010-2023 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

class AttributeStringMaxLength extends AttributeString
{
	public static function ListExpectedParams() {
		return [
			'sql',
			'default_value',
			'is_null_allowed',
			'max_length',
		];
	}

	public function GetValidationPattern() {
		$iMaxLength = $this->Get('max_length');
		return '^.{,'.$iMaxLength.'}$';
	}
}
