AdvancedContactUs
=================

Magento  module that give possibility to collect all data that are 
sent from contact us form and than process and response on it in admin panel.
### Description
Magento 2 module that collect all the user data from Contact Us form. 
It saves information into the database. Than this information can be accessible in admin panel `Content > AdvancedContactUs > Email list
`. There you can seed grid with all the data. 

Clicking `Action > Select > Edit` on the item you will be redirected to form where you can response to the user.
## Installation
In your root project directory run

    composer require val/advanced-contact-us
Then to enable module in Magento 2 run commands 

    php bin/magento setup:upgrade
    php bin/magento setup:static-content-deploy
    
### Available information from user
`Customer Id` - if user is logged in or user's email is presented in system, you'll get internal Magento user id.
So you can easily search info about the user.


`Store View` - shows from which store view user have sent a request.

`Name`, `Email`, `Phone`, `Created At`, `Message` - another info you'll get.

New messages got `Unprocessed` tag. While you response it changes to `Processed`.

#### Filters
In grid view you can use filters. List of them: 
- Id
- Created
- Store View
- Name
- Email
- Phone
- Message
- Status

### Settings
In `Stores > Configuration` you'll find `VAL EXTENSIONS > Advanced Contact Us`


### Info

Before using in production mode please make sure, that CAPTCHA is enabled for Contact Us form.

Information about email sender is getting from `Configuration > General > Store Email Addresses > Customer Support`
