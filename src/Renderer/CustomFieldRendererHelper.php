<?php
/*
 * @copyright   Copyright (C) 2010-2023 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

namespace Combodo\iTop\Extension\SampleNewAttributeType\Renderer;

use Combodo\iTop\Form\Field\Field;
use Combodo\iTop\Renderer\RenderingOutput;

class CustomFieldRendererHelper
{
	public static function AddDebugInfoToOutput(RenderingOutput $oOutput, Field $oField):void
	{
		$sFieldClass = get_class($oField);
		$oOutput->AddHtml('This our custom renderer ('.static::class.' for '.$sFieldClass.')! ✌');
	}
}