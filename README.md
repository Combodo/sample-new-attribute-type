This module is a demonstrator for the new field rendering extensibility added in iTop 3.1.0 (N°6041 for the user portal, N°6042 for the admin console).

What it does : 

* change DateTimeField renderer to a custom DateTimeFieldRenderer
* new AttributeStringCustomField, using StringCustomField and StringCustomFieldRenderer
* new Ticket.demo_stringcustomfield field of type AttributeStringCustomField, displayed in the portal ticket-create form

All custom bootstrap renderers are using the same render method in AbstractCustomBsFieldRenderer.
