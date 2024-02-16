# Database Relationships

Alright, I wanted to make it a bit hard by doing different types of model relationships. So to start, take the code inside features.dbml paste it at the link below.

https://dbdiagram.io/

That will give you a visual representation of the database structure. The only relationship type not diagrammed are the polymorphic relationships. But otherwise, it should give you a good idea of how the database is structured.

## Tasks

### Models

* Create the models for the new tables in the migrations I created.
* Add the relationships in them as well.
* Create a trait for the polymorphic relationships so you don't have to repeat the code in the models.

### Factories

* Create factories for the new models and wire them up to their respective models.
* Use the factories to create some seeders to create fake data for the database.
* Make sure the relationships are working by using the factories to create the seeders.

### Controllers

* Create the resource controllers for the new models to do the basic CRUD operations.
* Make sure the relationships are working by using the controllers to create, read, update, and delete the models.

### Search page

* Create a search page that allows you to search posts by users, categories, tags, and comments.
* You should be using your relationships to search the posts that have the categories, tags, and comments you are searching for.
* You should be able to search for multiple categories, tags, and comments in a single query.

I added forums to the database structure to show you how polymorphic relationships work for different tables but other than it's resource crud controller, factory, and model, nothing else is needed for that table.


Cool, let me know if you have any questions. Good luck!
