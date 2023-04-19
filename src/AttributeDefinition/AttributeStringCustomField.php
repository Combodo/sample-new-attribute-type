<?php
/*
 * @copyright   Copyright (C) 2010-2023 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

use Combodo\iTop\Extension\SampleNewAttributeType\Form\Field\StringCustomField;
use Combodo\iTop\Form\Field\StringField;
use Combodo\iTop\Form\Field\SubFormField;

/**
 * Extending an {@see \AttributeString} so that we have less methods to define.
 *
 * We are forced to use a {@see SubFormField} for the portal (see {@see GetFormFieldClass}), and {@see \AttributeDefinition::MakeFormField()} will do a SetCurrentValue on this field, which will call the same on the contained form. This will generate warnings as {@see \Form::SetCurrentValue} is
 * expecting either an array or an object ! It is working in the custom fields as value is always an object ({@see \ormCustomFieldsValue}), but won't here as we have a string :( I implemented some tweaks to make it work anyway... But there is still an error on the portal edit form.
 *
 * So it might be better to use {@see AttributeDefinition} directly as does {@see \AttributeCustomFields}, and use a specific orm object for the value.
 */
class AttributeStringCustomField extends AttributeString
{
	protected const EMPTY_VALUE = [];

	public function GetEditClass()
	{
		return 'FormField';
	}

	/**
	 * @inheritDoc
	 *
	 * We are using a {@see SubFormField} (see why in {@see GetFormFieldClass}) so we are not scalar !
	 */
	public static function IsScalar()
	{
		return false;
	}

	/**
	 * @inheritDoc
	 *
	 * using SubFormField children because of the portal : the show/hide won't work if simply using a Field.
	 * Indeed, hide only work once and then the field will always be shown whether its hidden property is true or false
	 *
	 * So we are using same model as the request templates : a SubFormField containing a Form containing a Field,
	 * and it is this last field that we are hiding.
	 */
	public static function GetFormFieldClass()
	{
		return StringCustomField::class;
	}

	/**
	 * @return string {@see \Combodo\iTop\Form\Field\Field} class to use for the final and real field
	 */
	protected static function GetSubFormFieldClass()
	{
		return StringField::class;
	}

	public function MakeFormField(DBObject $oObject, $oFormField = null)
	{
		if ($oFormField === null) {
			$sFormFieldClass = static::GetFormFieldClass();
			$oFormField = new $sFormFieldClass($this->GetCode());
			$oFormField->SetForm($this->GetForm($oObject));
		}
		parent::MakeFormField($oObject, $oFormField);

		return $oFormField;
	}

	/**
	 * Used by :
	 *
	 * * admin console from {@see \cmdbAbstractObject::GetFormElementForField}
	 * * portal from {@see MakeFormField}
	 *
	 * @param \DBObject $oHostObject
	 * @param string|null $sFormPrefix
	 *
	 * @return \Combodo\iTop\Form\Form
	 * @throws \ArchivedObjectException
	 * @throws \CoreException
	 */
	public function GetForm(DBObject $oHostObject, ?string $sFormPrefix = null): \Combodo\iTop\Form\Form
	{
		$sAttCode = $this->GetCode();

		$sFormId = 'ff_'.$sAttCode;
		if (utils::IsNotNullOrEmptyString($sFormPrefix)) {
			$sFormId = $sFormPrefix.$sFormId;
		}
		$oForm = new Combodo\iTop\Form\Form($sFormId);

		$sFormFieldClass = $this::GetSubFormFieldClass();
		// we need a specific id for the console JS to work (send data back to the server)
		$oAttDefField = new $sFormFieldClass($sAttCode.'_field');
		if ($oHostObject->Get($sAttCode) !== self::EMPTY_VALUE) {
			$oAttDefField->SetCurrentValue($oHostObject->Get($sAttCode));
		}

		// Handling hide/show here
		// Ideally we should override in XML the DBObject::GetInitialAttributeFlags/GetAttributeFlags methods
		// But this isn't working in the admin console as only the field value part is refreshed (see N°733)
		// Note also that each renderer will need to handle the field hidden property !
		if ($oHostObject->Get('urgency') === '4') { // 4 for 'low'
			$oAttDefField->SetHidden(true);
		}

		$oForm->AddField($oAttDefField);
		$oForm->Finalize();

		return $oForm;
	}

	/**
	 * @param $oHostObject
	 * @param $sFormPrefix
	 *
	 * @return string If returns null, then nothing is persisted.
	 *                Must return a value with the same type as the one returned by {@link static::MakeRealValue()}
	 */
	public function ReadValueFromPostedForm($oHostObject, $sFormPrefix)
	{
		$sPostedValue = utils::ReadPostedParam("attr_{$sFormPrefix}{$this->GetCode()}", '{}', 'raw_data');
		$aPostedValue = json_decode($sPostedValue, true);

		if (is_null($aPostedValue)) {
			return null;
		}

		$rawValue = $aPostedValue[$this->GetCode().'_field']; // '_field' suffix seems to be generated in iTop core when rendering form

		return $this->MakeRealValue($rawValue, $oHostObject);
	}

	public function ScalarToSQL($value)
	{
		if ($value === []) {
			$value = '';
		}

		return parent::ScalarToSQL($value);
	}

	public function MakeRealValue($proposedValue, $oHostObj)
	{
		return $proposedValue;
	}

	/**
	 * @inheritDoc
	 *
	 * Parent returns an empty string
	 * This isn't compatible with the {@see SubFormField} created in {@see MakeFormField} : a SetCurrentValue is called in the parent, which
	 * does the same on the SubFormField form, and there we must have either an array or null (foreach loop)
	 */
	public function GetDefaultValue(DBObject $oHostObject = null)
	{
		$sDefaultValue = parent::GetDefaultValue($oHostObject);
		if (utils::IsNullOrEmptyString($sDefaultValue)) {
			$sDefaultValue = self::EMPTY_VALUE;
		}

		return $sDefaultValue;
	}


	/**
	 * @param $sValue
	 * @param $oHostObject
	 * @param $bLocalize
	 *
	 * @return string HTML to be displayed in the details or lists
	 */
	public function GetAsHTML($sValue, $oHostObject = null, $bLocalize = true)
	{

		$sStringValue = parent::GetAsHTML($sValue, $oHostObject, $bLocalize);
		$sStringValue = '<i>Custom prefix</i> // '.$sStringValue.' // <i>Custom suffix</i>';

		return $sStringValue;
	}
}