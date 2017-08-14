README FIRST
-----------------------

What Can It Do for Me?
------------------------

You can link with any curl compliant system with complete w3c. You can transfer data between any sort tunnel through most of not all firewalls and poll your xoops platform from with another xoops or CMS or even things like .NET, Delphi and many other programming languages.

X-cURL is the quick way for cloud computing API's, you can link your xoops platform with any other computer network with this module, plug-in have complete WSDL compilation code and allow for easy and dynamic deployment.

Whats New in this release?
-------------------------------
The Server.php has changed to accomodate piped slashing.


How do I call this API?
-------------------------
The API is farely simple to use - you have a plugin which is a function on the api which has a filename say xoops_create_user.php which has an XSD in it as well as the function itself which is named after the filename. The API takes JSON Packages of variable and provide JSON response. You will have to check the plugin functions to see them implemented as to what they do and how to use them. But you can also call multiple function in a single call in this version.

Just say you where going to call the example function it would look as a URL something like this, You can use a $_GET or a $_POST depending on the data size.
Quote:

yoursite.com/modules/xcurl/?xoops_create_user={...JSON VARIABLES...}

If you where going to call multiple functions the url call would look like this with a $_GET.
Quote:

yoursite.com/modules/xcurl/?xoops_create_user={...JSON VARIABLES...}&secondary_function={...JSON VARIABLES...}&third_function={...JSON VARIABLES...}
