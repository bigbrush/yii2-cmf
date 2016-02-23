# Backend guide

The backend of Big Cms is based on the [AdminLTE](https://github.com/almasaeed2010/AdminLTE) theme and has the following
menu struture.

```
Home
Content
  |-- Pages
  |-- Categories
Navigation
  |-- Menu items
  |-- Menus
Blocks
File manager
Templates
System
  |-- Users
  |-- Extensions
  |-- Menu items
  |-- Settings
```

Using `Menu items` under `System` you can add backend menu items or change the existing. After installation all
menu items are translated.

By adding items to the backend menu you can easily implement your own modules with the backend of Big Cms.


## How to login

Go to http://www.YOURSITE.com/admin

After Big Cms has installed you can login with the following credentials:

~~~
Username: bigadmin
Password: bigadmin
~~~

**REMEMBER TO CHANGE USERNAME AND PASSWORD WHEN USING IN PRODUCTION**
