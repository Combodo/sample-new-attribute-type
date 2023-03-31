<?php
/*
 * @copyright   Copyright (C) 2010-2023 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

namespace Combodo\iTop\Extension\SampleNewAttributeType\Renderer\Console\FieldRenderer;

use Combodo\iTop\Application\UI\Base\Component\Field\FieldUIBlockFactory;
use Combodo\iTop\Application\UI\Base\Component\Html\Html;
use Combodo\iTop\Application\UI\Base\Component\Input\InputUIBlockFactory;
use Combodo\iTop\Application\UI\Base\Layout\UIContentBlockUIBlockFactory;
use Combodo\iTop\Extension\SampleNewAttributeType\Form\Field\StringCustomField;
use Combodo\iTop\Renderer\BlockRenderer;
use Combodo\iTop\Renderer\FieldRenderer;

class ConsoleStringCustomFieldRenderer extends FieldRenderer
{
	public function Render()
	{
		$oOutput = parent::Render();

		if ($this->oField->GetHidden()) {
			return $oOutput;
		}

		$sFieldClass = StringCustomField::class;

		$oBlock = FieldUIBlockFactory::MakeStandard($this->oField->GetLabel());
		$oBlock->AddDataAttribute("input-id", $this->oField->GetGlobalId());
		$oBlock->AddDataAttribute("input-type", $sFieldClass);
		$oValue = UIContentBlockUIBlockFactory::MakeStandard("", ["ibo-input-field-wrapper"]);

		$sFieldValue = $this->oField->GetCurrentValue();
		if (is_null($sFieldValue)) { // FIXME for now InputUIBlockFactory has string in method signatures instead of ?string
			$sFieldValue = '';
		}

		if ($this->oField->GetReadOnly()) {
			$oValue->AddSubBlock(InputUIBlockFactory::MakeForHidden("", $sFieldValue, $this->oField->GetGlobalId()));
			$oValue->AddSubBlock(new Html($sFieldValue));
		} else {
			$oValue->AddSubBlock(InputUIBlockFactory::MakeStandard("text", "", $sFieldValue, $this->oField->GetGlobalId()));
			$oValue->AddSubBlock(new Html('<span class="form_validation"></span>'));
		}
		$oBlock->AddSubBlock($oValue);
		$oOutput->AddHtml(BlockRenderer::RenderBlockTemplates($oBlock));

		$oOutput->AddJs(
			<<<EOF
                    $("#{$this->oField->GetGlobalId()}").off("change keyup").on("change keyup", function(){
                    	var me = this;

                        $(this).closest(".field_set").trigger("field_change", {
                            id: $(me).attr("id"),
                            name: $(me).closest(".form_field").attr("data-field-id"),
                            value: $(me).val()
                        })
                        .closest('.form_handler').trigger('value_change');
                    });
EOF
		);

		// JS Form field widget construct
		$aValidators = array();
		foreach ($this->oField->GetValidators() as $oValidator) {
			$aValidators[$oValidator::GetName()] = array(
				'reg_exp' => $oValidator->GetRegExp(),
				'message' => Dict::S($oValidator->GetErrorMessage()),
			);
		}
		$sValidators = json_encode($aValidators);
		$sFormFieldOptions =
			<<<EOF
{
	validators: $sValidators,
	on_validation_callback: function(me, oResult) {
		var oValidationElement = $(me.element).find('span.form_validation');
		if (oResult.is_valid)
		{
			oValidationElement.html('');
			 $(me.element).find('.ibo-input-field-wrapper').removeClass("is-error");
		}
		else
		{
			var sExplain = oResult.error_messages.join(', ');
			oValidationElement.html(sExplain);
			oValidationElement.addClass('ibo-field-validation');
			 $(me.element).find('.ibo-input-field-wrapper').addClass("is-error");
		}
	}
}
EOF;

		$oOutput->AddJs(
			<<<JS
                    $("[data-field-id='{$this->oField->GetId()}'][data-form-path='{$this->oField->GetFormPath()}']").form_field($sFormFieldOptions);
                    $("[data-field-id='{$this->oField->GetId()}'][data-form-path='{$this->oField->GetFormPath()}']").trigger('validate');
JS
		);

		return $oOutput;
	}
}