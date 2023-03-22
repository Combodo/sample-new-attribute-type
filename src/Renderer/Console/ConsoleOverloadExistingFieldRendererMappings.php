<?php
/*
 * @copyright   Copyright (C) 2010-2023 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

namespace Combodo\iTop\Extension\SampleNewAttributeType\Renderer\Console;

use Combodo\iTop\Extension\SampleNewAttributeType\Form\Field\StringCustomField;
use Combodo\iTop\Extension\SampleNewAttributeType\Renderer\Console\FieldRenderer\StringCustomFieldRenderer;
use Combodo\iTop\Renderer\Console\ConsoleFormRenderer;
use iFieldRendererMappingsExtension;

/**
 * This overloads the existing (Console) field renderer of the StringField
 */
class ConsoleOverloadExistingFieldRendererMappings implements iFieldRendererMappingsExtension
{

	/**
	 * @inheritDoc
	 */
	public static function RegisterSupportedFields(): array
	{
		return [
			[
				'field' => StringCustomField::class,
				'form_renderer' => ConsoleFormRenderer::class,
				'field_renderer' => StringCustomFieldRenderer::class,
			],
		];
	}
}