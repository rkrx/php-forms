php-flexible-forms
==================

Introduction
------------

There are many php based form classes out there. I have used many of them and visited even more before I decided to develop my own approach. So this project is based an the experience and covers mostly my own needs.

This project covers:
--------------------

* A component based forms generator
* Sophisticated and intuitive data life cycle
* Easily swap nearly all build-in components
* I18N, L10N
* As few external dependencies as possible

How I want to archive this:
---------------------------

* PHP 5.4+ (Short array syntax, $this in lamdas and closures)
* Reasonably+ clean architecture
* The interface should be as intuitive as possible
* No static boundaries where you need to hack to gain additional functionality
* Build-in and ready-to-use templating adapter
* Build-in and ready-to-use dictionary adapter
* As much IDE control as possible (at least with PHPStorm: Full inspection)

How data is processed by this library
-------------------------------------

First there is a simple array. If you primary work with class based models, you can utilize any DataMapper available. A dedicated DataMapper is not intended to be a part of this project.

So, there is a simple array:

```php
$array = [
	'name' => 'Steve Martin',
	'birthday' => '1945-08-14',
	'contact' => [
		'email' => 'steve.martin@bar.baz',
		'phone' => '012-345-6789'
	],
	'quotes' => [
		'First the doctor told me the good news: I was going to have a disease named after me.',
		'A day without sunshine is like, you know, night.',
		'Talking about music is like dancing about architecture.'
	],
	'image_url' => null
];
```

Fairly simple. Hope you noticed there are two inner arrays.

This data should now be edited. Some assumptions should be made first:

* A ```name``` should not be longer then 30 chars, but not shorter than 2. White-space character should be ignored.
* ```birthday``` should be edited as a date.
* ```contact.email``` and ```contact.phone``` should be displayed on the same level like ```name``` and ```birthday```.
* The ```contact.email``` should be a valid E-Mail-Address.
* For every quote, there is a text-input. You should be able to click on a ````[Add]``` button to generate a new input field.
* ```image_url``` should be handled by a image upload control with some post-processing and ftp operations.

We can extract 4 different entry points for our form creation process:

* Initial creation, where we have (possibly) no data at all. Form generates the html.
* Editing existing data. Form also generates the html, but this time there is data to fill in.
* Modifing the form structure without (re-)validation. This step is optional.
* Converting and validating edited data. If validation fails, the form should be redisplayed with some hints attached.

So, what does it mean to "create" a form or convert and validate data or even modifying the structure?

### Creating a form

We need to setup the form and tell which elements to use. In this example we need some Textfields (````name```, ```contact.email```, ```contact.phone```), a Datefield (```birthdate```), even more Textfields (```quotes```) and an Image upload handler. Since we have a dynamic amount of quotes, we cant simple stick some elements together and go on. Our form relies on our data.

But there is another possible problem. The data which was held by our form is likely different formatted than the input was. You'll need to convert the data back to the original-format (data conversion is described in the next section). But to do this, you'll need the components installed to do this.

We have a 2 step process to get this done. We call the ```$form->build()```-method to store our data and initialize the components:

* The pre-build process starts to create the basic form layout.
* The data is stored in the internal storage.
* The (optional) post-build process changes the layout based on the data.


### Converting data

TODO


### Validating data

TODO
