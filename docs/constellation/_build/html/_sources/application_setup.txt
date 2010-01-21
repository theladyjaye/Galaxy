*****************************
Applications
*****************************

Create an Application
=======================

- Once you are logged in click on the *Application* button, then click the + in the upper left to create a new application.
.. image:: _static/application_setup_1.png

This will reveal the new application form

.. image:: _static/application_setup_2.png

- For application type, choose *Forum*
- Enter the name you would like to appear for messages originating from your application in the Application Display Name field, e.g., "Galaxy Community" 
  would result in the following: Posted from **Galaxy Community** on 2012-01-20
- Application Id is an identifier in reverse-domain name style, e.g, com.galaxy.community.
  The Application Id forms the base of all the channels you will create moving forward.

.. note:: Wildcards are not allowed in Application ids.  

- Application Domain is the url you would like to associate with this application, e.g., http://galaxyfoundry.com.  This information will be 
  included in all information sent from Galaxy.
- Set your default channel permissions.  This will represent the default permissions others will have when subscribing to your application.  As the 
  owner of the application you are automatically granted full permissions.  When creating channels, you will also have the opportunity to further
  customize the default set of permisisons for that channel.
- Press Create Application.  Assuming all of the information you entered is valid, you will now have a new Base Constellation instance ready to go.

Application Access
===================

Once your application is created, In the application details you will see your Application Id, API Key and API Secret. You will need
All 3 pieces of information to configure your client.

Application Actions
====================
From the application details you will see the following actions you can perform:

- Manage Default Permissions
- Manage Channels
- Delete Application

.. image:: _static/application_setup_3.png

Manage Default Permissions
--------------------------

Here you can change the default permissions for any new channels you create

Manage Channels
---------------

You will create your channels here.  Since this application is a Constellation instance, channels are synonymous with Forms

Delete Application
------------------

This will delete your application and all associated channels/data.

.. warning:: This cannot be undone.