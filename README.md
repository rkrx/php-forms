# php-forms

## Introduction

There are many php based form classes out there. I have used many of them and visited even more before I decided to develop my own approach. So this project is based on some experience and covers mostly my own needs.

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
