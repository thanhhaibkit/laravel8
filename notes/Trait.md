# Trait

- https://www.php.net/manual/en/language.oop5.traits.php
- https://www.w3schools.com/php/php_oop_traits.asp


### Laravel's example
- [Soft Deleting](https://laravel.com/docs/8.x/eloquent#soft-deleting)
- [The Notifiable Trait](https://laravel.com/docs/8.x/notifications#using-the-notifiable-trait)

### Let try to build a trait

Situation: As a administrator, I want to control the permission of a user on the table
Solution:
- Build a permission trait and include it to User model to add permission processing code to the model
- Build a middle ware for checking permission of each request.

