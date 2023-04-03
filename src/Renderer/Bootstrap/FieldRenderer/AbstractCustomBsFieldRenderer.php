<?php
/*
 * @copyright   Copyright (C) 2010-2023 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

namespace Combodo\iTop\Extension\SampleNewAttributeType\Renderer\Bootstrap\FieldRenderer;

use Combodo\iTop\Extension\SampleNewAttributeType\Renderer\CustomFieldRendererHelper;
use Combodo\iTop\Renderer\Bootstrap\FieldRenderer\BsFieldRenderer;

class AbstractCustomBsFieldRenderer extends BsFieldRenderer
{
	public function Render()
	{
		$oOutput = parent::Render();

		if ($this->oField->GetHidden() === true) {
			return $oOutput;
		}

		CustomFieldRendererHelper::AddDebugInfoToOutput($oOutput, $this->oField);

		return $oOutput;
	}
}