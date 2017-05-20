# Running Installer
to run installer, open below url in your browser
```
http://example.com/path_to_app/installer
```
and follow on screen instructions

## Importing Schema
To import schema to the database, follow below steps
#### Step 1:
Export or save your schema to *sql* file
#### Step 2:
Rename file to **my_shema.sql**
#### Step 3:
Copy **my_schema.sql** file to **/config** directory of your application
#### Step 4:
Mark check **Import Database** in **Database Connection Setup** page
#### Step 5:
Installer will automatically import your schema to the database

> **NOTE:** Schema Import may take some time depending on the schema size. Please, do not close the window or refresh the page after clicking **Copy Schema** button

## Important Instruction
1. You may need to give write permission ot */config* directory, because a file will be created inside this directory
1. Please, do not delete **Datasources** array from **app.php** file inside */config* directory. Doing so may break your application.
1. Your **default connection** inside **Datasource** array of **app.php** will be overriden by new database configuration */config/database_config.php*
1. You can still use **Datasources** array to create other connections, only **default** will be overridden.

[< Installation](installation.md) | [Automation >](automation.md)
