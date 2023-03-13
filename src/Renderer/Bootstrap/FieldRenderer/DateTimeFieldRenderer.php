<?php
/*
 * @copyright   Copyright (C) 2010-2023 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

namespace Combodo\iTop\Extension\SampleNewAttributeType\Renderer\Bootstrap\FieldRenderer;

class DateTimeFieldRenderer extends \Combodo\iTop\Renderer\Bootstrap\FieldRenderer\BsFieldRenderer
{
	public function Render()
	{
		$oOutput = parent::Render();

		$sFieldClass = get_class($this->oField);
		$sFieldMandatoryClass = ($this->oField->GetMandatory()) ? 'form_mandatory' : '';

		// Rendering field in edition mode
		$oOutput->AddHtml('This our custom renderer ('.static::class.' for '.$sFieldClass.')! ✌');

		return $oOutput;
	}

}