<?php
/*
 * @copyright   Copyright (C) 2010-2023 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

namespace Combodo\iTop\Extension\SampleNewAttributeType\Renderer\Bootstrap;

use Combodo\iTop\Extension\SampleNewAttributeType\Form\Field\StringCustomField;
use Combodo\iTop\Extension\SampleNewAttributeType\Renderer\Bootstrap\FieldRenderer\BsStringCustomFieldRenderer;
use Combodo\iTop\Renderer\Bootstrap\BsFormRenderer;
use iFieldRendererMappingsExtension;

/**
 * Class BsOverloadExistingFieldRendererMappings
 *
 * This overloads the existing (Bootstrap) field renderer of the DateTimeField
 *
 * @author Guillaume Lajarige <guillaume.lajarige@combodo.com>
 * @package Combodo\iTop\Extension\SampleNewAttributeType\Renderer\Bootstrap
 */
class BsOverloadExistingFieldRendererMappings implements iFieldRendererMappingsExtension
{

	/**
	 * @inheritDoc
	 */
	public static function RegisterSupportedFields(): array
	{
		return [
			[
				'field'          => StringCustomField::class,
				'form_renderer'  => BsFormRenderer::class,
				'field_renderer' => BsStringCustomFieldRenderer::class,
			],
		];
	}
}