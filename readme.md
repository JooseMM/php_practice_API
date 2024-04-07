# Practice PHP API

## Introduction

This project aims to provide hands-on experience in building a CRUD (Create, Read, Update, Delete) RESTful API using PHP, primarily for educational purposes.

## Endpoints / Routes

### Index ("/")

This endpoint serves as the landing page, providing a brief introduction to the project's purpose. It includes links to the repository and the developer's portfolio.

### Get All ("/all")

This endpoint retrieves all data stored in the database.

### Get Specific ("/get/?(id=match)")

This endpoint retrieves a specific row from the database using a query string.

### Update ("/update")

This endpoint updates a value with new values provided in the request body.

### Remove ("/remove")

This endpoint deletes the row matching the provided ID from the database.

## Important Notes

- To create, update, or remove data, it's necessary to use a POST request and set the Content-Type header to "application/x-www-form-urlencoded".
- This project utilizes SQLite as its database for simplicity.

## Dependencies (Linux/Ubuntu)

- php-sqlite3
- sqlite3

## Other Links

- Porfolio: https://jamm-portfolio.netlify.app/
- LinkedIn: www.linkedin.com/in/jamm-dev

 
