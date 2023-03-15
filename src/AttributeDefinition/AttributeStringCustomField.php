<?php
/*
 * @copyright   Copyright (C) 2010-2023 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

use Combodo\iTop\Extension\SampleNewAttributeType\Form\Field\StringCustomField;

class AttributeStringCustomField extends AttributeString
{
	public static function GetFormFieldClass()
	{
		return StringCustomField::class;
	}
}