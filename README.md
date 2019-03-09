# user-upload
Please follow these commands to run the user_upload.php program...

-f parameter for CSV FILE, -c parameter for Create Table, -u parameter for DB Username,
-p parameter for DB Password, -r parameter for Dry Run and -h parameter for HELP.

To run the Program please use this Command:
user_upload.php -f users.csv -h hostname -d DBNAME -u DBusername -p DBpassword -c create-table

To just create table please use this Command:
user_upload.php -c create-table -h hostname -d DBNAME -u DBusername -p DBpassword

For Dry Run, Please add -r parameter in above command like -r dry-run
user_upload.php -f users.csv -h hostname -d DBNAME -u DBusername -p DBpassword -c create-table -r dry-run

To check all commands (HELP), please use command:
user_upload.php -i help
