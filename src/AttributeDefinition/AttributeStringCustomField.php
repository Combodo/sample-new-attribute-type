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

	public function MakeFormField(DBObject $oObject, $oFormField = null)
	{
		$oFormField = parent::MakeFormField($oObject, $oFormField);

		// Handling hide/show here
		// Ideally we should override in XML the DBObject::GetInitialAttributeFlags/GetAttributeFlags methods
		// But this isn't working in the admin console as only the field value part is refreshed (see N°733)
		// Note also that each renderer will need to handle the field hidden property !
		if ($oObject->Get('urgency') === '4') { // 4 for 'low'
			$oFormField->SetHidden(true);
		}

		return $oFormField;
	}

	public function GetForm(DBObject $oHostObject, ?string $sFormPrefix = null): \Combodo\iTop\Form\Form
	{
		$sAttCode = $this->GetCode();

		$sFormId = 'ff_'.$sAttCode;
		if (utils::IsNotNullOrEmptyString($sFormPrefix)) {
			$sFormId = $sFormPrefix.$sFormId;
		}

		$oForm = new Combodo\iTop\Form\Form($sFormId);

		// creating manually the field, as we need a specific id for the JS to work (send data back to the server)
		$sFormFieldClass = $this::GetFormFieldClass();
		$oAttDefField = new $sFormFieldClass($sAttCode.'_field');

		$this->MakeFormField($oHostObject, $oAttDefField);
		// Remove label generated in MakeFormField : the current method should return the field only, as the label is already generated in the caller GetBareProperties()
		$oAttDefField->SetLabel('');

		$oForm->AddField($oAttDefField);

		return $oForm;
	}

	public function GetEditClass()
	{
		return 'FormField';
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

	public function MakeRealValue($proposedValue, $oHostObj)
	{
		// here we have a string att so nothing more to do
		return parent::MakeRealValue($proposedValue, $oHostObj); // TODO: Change the autogenerated stub
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