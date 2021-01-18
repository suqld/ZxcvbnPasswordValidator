# ZxcvbnPasswordValidator
Realistic Symfony password strength validator based on Dropbox's zxcvbn project. 


## Overview

Zxcvbn-PHP is a password strength estimator using pattern matching and minimum entropy calculation. 
Zxcvbn-PHP is based on the Javascript zxcvbn project from Dropbox and @lowe. "zxcvbn" is bad password, just like 
"qwerty" and "123456".

More info [here](https://blogs.dropbox.com/tech/2012/04/zxcvbn-realistic-password-strength-estimation/).

>zxcvbn attempts to give sound password advice through pattern matching and conservative entropy calculations. 
It finds 10k common passwords, common American names and surnames, common English words, and common patterns like dates, 
repeats (aaa), sequences (abcd), and QWERTY patterns.

This validator is based on library: [Zxcvbn-PHP](https://github.com/bjeavons/zxcvbn-php) 


## Installation
 
 ```
 composer require suqld/zxcvbn-password-validator
 ```
 
 ## Options
 
 You can use the `Locastic\Component\ZxcvbnPasswordValidator\Validator\Constraints\ZxcvbnPasswordValidator`
 constraint with the following options.
 
 |     Option      |   Type   |                                       Description                                       |
 | --------------- | -------- | --------------------------------------------------------------------------------------- |
 | message         | `string` | The validation message (default: `password_too_weak`)                                   |
 | minScore        | `int`    | Desired minimal score value (password strength                                          |
 
 ## Annotations
 
 If you are using annotations for validation, include the constraints namespace:
 
 ```php
 use Locastic\Component\ZxcvbnPasswordValidator\Validator\Constraints as LocasticPassword;
 ```
 
 and then add the ZxcvbnPasswordValidator constraint to the relevant field:
 
 ```php
 /**
  * @LocasticPassword\ZxcvbnPasswordValidator(minScore=3)
  */
 protected $password;
 ```
 
 ## YAML
  ```yaml
  App\Entity\User:
      properties:
          password:
              - Locastic\Component\ZxcvbnPasswordValidator\Validator\Constraints\ZxcvbnPasswordValidator:
                   minScore: 3
   ```
 
