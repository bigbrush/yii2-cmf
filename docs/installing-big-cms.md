# Installing Big Cms

Big Cms is installed through Composer.

With Composer installed, you can install Big Cms by running the following commands under a Web-accessible folder:

~~~
composer create-project --prefer-dist bigbrush/yii2-bigcms bigcms
cd bigcms
yii cms/install
~~~

Then follow the on screen instructions which helps you specify database login credentials.

After the installion has finished go to http://YOURSITE.COM/admin/ and login with:
  - Username: bigadmin
  - Password: bigadmin

**REMEMBER TO CHANGE PASSWORD WHEN USING IN PRODUCTION**


##Next steps

  - [Dynamic themes](themes.md).
  - [Backend guide](backend-guide.md)
  - [Frontend guide](frontend-guide.md)
