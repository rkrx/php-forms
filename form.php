<?php
use Kir\Forms\Container;
use Kir\Forms\Element;
use Kir\Forms\Filtering\Filters;

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

$data = $form->convert(['items' => [['lang' => 'de', 'title' => ' Hello World     '], ['lang' => 'en']]]);

print_r($data);

#$form->convert();