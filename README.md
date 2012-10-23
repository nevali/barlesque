This is an Eregansu module which acts as a client to the BBC Barlesque
web service.

To use, simply include header.php and footer.php into your templates, either
from your own header/footer files, or from your templates directly:

<?php require($templates_path . 'barlesque/header.php'); ?>

and

<?php require($templates_path . 'barlesque/footer.php'); ?>

If you wish to customise the Barlesque options, either derive your page class
from BarlesquePage (defined in barlesque/page.php), or include
barlesque/client.php, create an instance of the Barlesque class, set any
options that you require, and substitute it into your template as 'blq'. For
example:

require_once(MODULES_ROOT . 'barlesque/client.php');

:
:

protected function assignTemplate()
{
		parent::assignTemplate();
		$this->vars['blq'] = new Barlesque();
		$this->vars['blq']->complaintsLink = true;
}

Properties can be set using either the Forge/PAL names, or the traditional
SSI parameter names. Boolean values are converted to the correct style of
parameter value (e.g., 'on' versus 'yes' versus 'true' versus '1') as needed.
Setting a property to null causes that parameter to be not passed to the web
service and the server-side default used instead.

For more information, see:

* http://www.bbc.co.uk/frameworks/barlesque

* http://www.bbc.co.uk/frameworks/barlesque/test
