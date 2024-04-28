Welcome to HACKOTTO's OTTO Aqua: Inventory Management System!!

Here is how to set up the web system.
1. Download the ZIP file and extract the files.
2. Depending on the MySQL platform used (WAMP/XAMPP), move the files to the correct folder for testing at localhost. Name the folder containing the files as "ottoaqua".
2.1 WAMP: "www" folder
2.2 XAMPP: "htdocs" folder
3. In PHPMyAdmin, create a database called ottoaqua and import the ottoaqua.sql file downloaded.
4. Access the index page through the http://localhost/ottoaqua/index.php to get started.

Available account information:
1. Inventory Department
Username: paola
Password: pwr12345

2. Test Lab
Username: wendy
Password: wlsi1234

3. Subang Jaya Region Store
Username: alya
Password: nam12345

4. Kuala Lumpur Region Store
Username: yuna
Password: yhms1234

5. Contractor
Username: reyes
Password: bing1234

How to set up meter demand forecast:
1. In httpd.conf file in WAMP or XAMPP, paste these two lines at the end of the file and restart the server.
AddHandler cgi-script .py
ScriptInterpreterSource Registry-Strict
2. Change the first line in demandForecasting.py to the path of Python exe file. Ex: #C:\Users\name\AppData\Local\Programs\Python\Python312\python.exe
3. Open Terminal on your device and enter the following commands to install dependencies for the file:
pip install pandas
pip install scikit-learn
4. Download the sample file to view the format of the dataset before uploading.

In case of any issues encountered while using the system, you may contact masturaalya02@gmail.com (Alya). Thank you!
