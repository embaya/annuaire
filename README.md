Annuaire
========

A Symfony project created on November 9, 2017

Install project with composer 

 ```ruby
 composer install
 ```
Create database 
 ```ruby
 php bin/console doctrine:database:create
 ```
Update schema
 ```ruby
 php bin/console doctrine:schema:update --force 
 ```
 
Add some departements manually
```ruby
INSERT INTO `departement` (`id`, `name`, `code`) VALUES
(1, 'Ain', '01'),
(2, 'Aisne', '02'),
(3, 'Allier', '03'),
(4, 'Hautes-Alpes', '05'),
(5, 'Alpes-de-Haute-Provence', '04'),
(6, 'Alpes-Maritimes', '06'),
(7, 'Ardèche', '07'),
(8, 'Ardennes', '08'),
(9, 'Ariège', '09'),
(10, 'Aube', '10'),
(11, 'Aude', '11'),
(12, 'Aveyron', '12'),
(13, 'Bouches-du-Rhône', '13'),
(14, 'Calvados', '14'),
(15, 'Cantal', '15'),
(16, 'Charente', '16');

```