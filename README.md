# php-forms

[![Build Status](https://travis-ci.org/rkrx/php-forms.svg?branch=master)](https://travis-ci.org/rkrx/php-forms)

## Introduction

There are many php based form classes out there. I have used many of them and visited even more before I decided to develop my own approach. So this project is based on some experience and covers mostly my own needs.

## Installation

```bash
composer require rkr/forms
```

## Example

### First Render

We first have to create a structure that will later represent our form, and subsequently convert the entered data and perform the validation:

```php
use Forms\Form;

$section = new Form\Section('Section', ['xyz' => 123],
    new Form\Checkbox(['data', 'active'], 'Active'),
    new Form\Input(['data', 'name'], 'Name', ['required' => true, 'minlenght' => 5, 'maxlength' => 64]),
    new Form\Email(['data', 'email'], 'Email')
);
```

Then we can create a data structure from the structure: 

```php
$structure = $section->render([], false);
print_r(json_encode($structure, JSON_PRETTY_PRINT));
```

```text
{
    "type": "section",
    "elements": [{
        "name": ["data", "active"],
        "title": "Active",
        "value": null,
        "messages": [],
        "attributes": [],
        "type": "checkbox"
    }, {
        "name": ["data", "name"],
        "title": "Name",
        "value": null,
        "messages": [],
        "attributes": {
            "required": true,
            "minlenght": 5,
            "maxlength": 64
        },
        "type": "input"
    }, {
        "name": ["data", "email"],
        "title": "Email",
        "value": null,
        "messages": [],
        "attributes": [
            "required": true
        ],
        "type": "email"
    }],
    "attributes": {"xyz": 123},
    "title": "Section"
}
```

If we already have data, then this data is included in the generated data structure. That's it for the first step, actually. The output can now be made with any template engine. I mainly use PHP and Twig in my projects, but any template engine can be used.

### Conversion

Instructions follow...

### Validation and second Render

Instructions follow...

## Zen of Forms

* It should be easy to reason about data
* Building forms should be as intuitive as possible
* Forms should be built using declarative data and user defined templates
* Ability to replace existing components and build your own
* I18N and L10N is crucial
* Need as few external dependencies as possible
* PHP-Code must be statically clean

## TODO

* [x] Tested base components
* [ ] Handling for I18N and L10N
* [ ] Usage example

* Every component must not change internal state by design by calling `convert`, `validate` or `render`, after the component was initialized.
