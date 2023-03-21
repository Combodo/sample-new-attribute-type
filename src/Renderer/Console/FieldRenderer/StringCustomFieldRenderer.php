<?php
/*
 * @copyright   Copyright (C) 2010-2023 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

namespace Combodo\iTop\Extension\SampleNewAttributeType\Renderer\Console\FieldRenderer;

use Combodo\iTop\Extension\SampleNewAttributeType\Renderer\CustomFieldRendererHelper;
use Combodo\iTop\Renderer\FieldRenderer;

class StringCustomFieldRenderer extends FieldRenderer
{
	public function Render()
	{

		$oOutput = parent::Render();
		CustomFieldRendererHelper::AddDebugInfoToOutput($oOutput, $this->oField);

		return $oOutput;
	}
}