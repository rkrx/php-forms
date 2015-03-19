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
		->add(new Element\HiddenField('lang', 'Sprache'))
		->add(
			(new Element\TextField('name', 'Name'))
			->addValidator(new Contraints\MinLengthValidator(20, 'Mindestend {minlength} Zeichen erwartet'))
			->addValidator(new Contraints\MaxLengthValidator(32, 'Nicht mehr als {maxlength} Zeichen zugelassen'))
			->addValidator(new Contraints\PatternValidator('^[\\w ]+$', ['u'], 'Es sind nur Buchstaben, Zahlen und Leerzeichen erlaubt'))
			->addFilter(new Filters\TrimFilter())
		)
		->add(
			(new Element\TextAreaField('description', 'Description'))
			->addFilter(new Filters\TrimFilter())
		)
		->add(
			(new Element\CurrencyField('price', 'Price'))
		)
	)
);

$entityData = [
	'items' => [[
		'lang' => 'de',
		'name' => ' Peter Fox     ',
		'description' => 'This is a test',
		'price' => 19.989
	], [
		'lang' => 'en',
		'name' => ' Jane Doe     ',
		'price' => 999
	]]
];

//$data = $form->convert($entityData);
//print_r($data);

$renderedData = $form->render($entityData);
print_r($renderedData);
//
//$data = $form->render(['items' => ['a' => ['name' => 'Max Mustermann', 'company' => 'Acme']]], true);
//
//echo json_encode($data, JSON_PRETTY_PRINT);
