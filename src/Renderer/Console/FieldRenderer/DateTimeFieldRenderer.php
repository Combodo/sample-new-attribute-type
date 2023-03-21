<?php
/*
 * @copyright   Copyright (C) 2010-2023 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

namespace Combodo\iTop\Extension\SampleNewAttributeType\Renderer\Console\FieldRenderer;

use Combodo\iTop\Extension\SampleNewAttributeType\Renderer\CustomFieldRendererHelper;
use Combodo\iTop\Renderer\FieldRenderer;

class DateTimeFieldRenderer extends FieldRenderer
{
	public function Render()
	{
		return CustomFieldRendererHelper::AddDebugInfoToOutput(parent::Render(), $this->oField);
	}
}