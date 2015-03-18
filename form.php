<?php
use Kir\Forms\Container;
use Kir\Forms\Element;
use Kir\Forms\Filtering\Filters;
use Kir\Forms\Validation\Contraints;

require 'vendor/autoload.php';

$form = (new Container\Form())
->add(
	(new Container\Section())
	->add(
		(new Container\Repeat('items'))
		->add(new Element\HiddenField('lang'))
		->add(
			(new Element\TextField('title', 'Titel'))
			->addFilter(new Filters\TrimFilter())
		)
		->add(new Element\TextAreaField('description', 'Beschreibung'))
	)
);

/*$data = $form->convert(['items' => [['lang' => 'de', 'title' => ' Hello World     '], ['lang' => 'en']]]);

print_r($data);

$renderedData = $form->render($data);

print_r($renderedData);*/

$element = (new Element\TextField('email', 'E-Mail'))
->addValidator(new Contraints\EmailAddressValidator())
->addFilter(new Filters\TrimFilter());

$data = $element->render(['email' => 'ron.kirschler@gmail.com'], true);

print_r($data);
