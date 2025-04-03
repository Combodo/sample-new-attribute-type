# Disclaimer

This repo is no longer maintained, all the source code is still available as history.

It was made as a customization example for iTop version 3.1.

It's still monitored so if you experience some error please open an issue.

Any contribution aiming to keep this sample up to date are welcome following this [migration guide](https://www.itophub.io/wiki/page?id=latest:install:migration_notes).


Thanks for your understanding.

The iTop Team

# Sample new attribute type

This module is a demonstrator for the new field rendering extensibility added in iTop 3.1.0 (N°6041 for the user portal, N°6042 for the admin console).

What it does : 

* change DateTimeField renderer to a custom DateTimeFieldRenderer
* new AttributeStringCustomField, using StringCustomField and StringCustomFieldRenderer
* new Ticket.demo_stringcustomfield field of type AttributeStringCustomField, displayed in the portal ticket-create form

All custom bootstrap renderers are using the same render method in AbstractCustomBsFieldRenderer.
