## Laravel 5.5 Import CSV With matching

This project is showing how to import data from CSV file, and matching CSV columns with database columns.


Also showing how to deal with CSV files with/without header rows, using plain PHP functions and [maatwebsite/excel package](https://github.com/Maatwebsite/Laravel-Excel).

![Laravel Import CSV](https://res.cloudinary.com/srb/image/upload/v1545644959/field_mapping.png)

---

### How to use

- Clone the repository with __git clone__
- Copy __.env.example__ file to __.env__ and edit database credentials there
- Run __composer install__
- Run __php artisan key:generate__
- Run __php artisan migrate__
- That's it - load the homepage

---


##In this Project : field mapper integration

● Product Module (Basic Fields - title, SKU, description, price, quantity)
● Category Module (Basic Fields - title)

Screen 1:
- Import CSV/Excel file with Product data

Screen 2:
- Once I import the CSV/Excel file, Show ‘field mapping’ screen.
- Map system fields with CSV/Excel field.
- For e.g., system field is ‘title’ and csv field is ‘Product title’. So In this case, left side show
system fields list and on right side show dropdown of CSV/Excel heading fields.
- Also, take one field in CSV/Excel file for product categories. Where multiple categories
for a product can be added separated by “|”.
- If category exist in category, then just assign its id to product, otherwise add new
category and then assign it to a product.

----------------------
## This project devloped by : Saurabh Sahu
## For any query Contact : web.saurabhsahu@gmail.com
-----------------------------------------
