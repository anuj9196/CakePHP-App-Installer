# Running Installer
to run installer, open below url in your browser
```
http://example.com/path_to_app/installer
```
and follow on screen instructions

## Important Instruction
1. You may need to give write permission ot */config* directory, because a file will be created inside this directory
1. Please, do not delete **Datasources** array from **app.php** file inside */config* directory. Doing so may break your application.
1. Your **default connection** inside **Datasource** array of **app.php** will be overriden by new database configuration */config/database_config.php*
1. You can still use **Datasources** array to create other connections, only **default** will be overridden.

[< Installation](installation.md) | [Importing Schema >](import-schema.md)
