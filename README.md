# Roman Numerals Tech Task
This development task is based on the simple process of converting Roman numerals. This task requires you to build a JSON API and so any HTML, CSS or JavaScript that is submitted will not be reviewed.

## Brief
Our client (Numeral McNumberFace) requires a simple RESTful API which will convert an integer to its Roman numeral counterpart. After our discussions with the client, we have discovered that the solution will contain three API endpoints, and will only support integers ranging from 1 to 3999. The client wishes to keep track of conversions so they can determine which is the most frequently converted integer, and the last time this was converted. The client would also like to use an Artisan command on the command line to allow them to have a provided number converted to Roman numeral.

### Endpoints Required
1. Accepts an integer, converts it to a Roman numeral, stores it in the database and returns the response.
2. Lists all the recently converted integers.
3. Lists the top 10 converted integers.

### Commands Required
1. Accepts an integer argument, appropriately named, that will store the converted Roman numeral and present it to the command line user.

## What we are looking for
- Use of MVC components (View in this instance can be, for example, a Laravel Resource).
- Use of [Laravel Resources](https://laravel.com/docs/eloquent-resources)
- Use of Laravel features such as Eloquent, Requests, Validation, and Routes.
- An implementation of the supplied interface.
- Appropriate logging and exception handling.
- The supplied PHPUnit test passing and any other tests you consider worthwhile being added.
- Clean code, following PSR-12 standards.
- Use of PHP 8.3 features where appropriate.

This list is our expectation of your approach, but it is not exhaustive. You are free, at your own discretion, to demonstrate your skills to us relating to Laravel, PHP, Testing, API Development, and more.

Please also include a short explanation of your approach, including any design decisions you have made and the reasons for those decisions. While we do not believe it necessary to use any third party libraries, please document and explain your reasoning for using any libraries you choose to use.

## Submission Instructions
Please create a [git bundle](https://git-scm.com/docs/git-bundle/) and send the file across:
```
git bundle create <yourname>.bundle --all --branches
```
