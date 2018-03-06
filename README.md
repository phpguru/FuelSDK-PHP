FuelSDK-PHP
============

Forked from Salesforce Marketing Cloud Fuel SDK for PHP

> Salesforce Marketing Cloud Fuel SDK for PHP is free to use but are not official Salesforce Marketing Cloud products and should be considered community projects. This SDK is not officially tested or documented. For help on any Salesforce Marketing Cloud Fuel SDK for PHP, please consult the Salesforce message boards or the issues section of this repository. Salesforce Marketing Cloud support is not available for this SDK.

## Overview ##
The Fuel SDK for PHP provides easy access to Salesforce Marketic Cloud's Fuel API Family services, including a collection of REST and SOAP API. These APIs provide access to Salesforce Marketing Cloud (previously called ExactTarget) functionality via common collection types such as array/hash. 

## New Features in Version 1.1.0 ##

* **namespace :** namespace is introduced.

* **newly supported objects:**
    - Result Message
    - Data Extract
    - Triggered Send Summary

* composer autoload issue fix


<!--
* **mcrypt :** mcrypt dependency removed.
mcrypt extension dependency prevented client application from upgrading to PHP 7.x. This release supports any PHP version > 5.6.24 and PHP 7.x

* **proxy :** added proxy server support.
If your client application sits behind a proxy server,  you can use PHP SDK with following configuration settings in config.php file.
    - proxyhost
    - proxyport
    - proxyusername
    - proxypassword

You can override these configuration setting using $params parameter passed to the constructor of ET_Client class.

* **jwt :** jwt.php is removed from the project source tree and added as dependency.
jwt.php removed and added as dependency in composer.json. If you are manually downloading the project, call **composer update** to get **jwt** downloaded.

* **soap-wsse :** soap-wsse.php is removed from the project source tree and added as dependency in composer.json. If you are manually downloading the project, call **composer update** to get the **soap-wsse** downloaded.

* **code refactor :** code refactored to individual class files. (under src/ directory)
Project tree structure is now changed to: 
    - src           : source files
    - doc           : SDK API documentation
    - tests         : unit test cases
    - objsamples    : sample files

* **unit test :** added unit test cases (happy path for now) using phpunit testing framework. (under tests/ directory)

* **API docs :** added API documentation using phpdocumentor framework. (under docs/ directory)

* **auto loader :** integrated auto loader (spl_autoload_register) for all source code under src/, tests/, objsamples/ directory.
-->


## Requirements ##
PHP Version >=5.6.24

Extensions:
- openssl
- SOAP
- curl

## API Documentation ##

http://salesforce-marketingcloud.github.io/FuelSDK-PHP/index.html

## Installation ##

### Manual Installation
After downloading the project, rename the config.php.template file to config.php. Most importantly, you also need to download all dependencies manually and include accordingly. That's why we highly encourage to get it from composer.

### Composer
Add a dependency to composer require salesforce-mc/fuel-sdk-php to the require section of your project's composer.json configuration file, and update your application.

The following code is an example of a minimal composer.json file:
<pre>
{
    "require": {
        "phpguru/fuel-sdk-php": "dev-master"
    }
}
</pre>

## Getting Started ##
The requirement to use config.php has been removed. Instead,
see the updated $params array fields when instantiating the ET_Client.
If you are building a 
HubExchange application for the Interactive Marketing Hub then, you 
must also provide the Application Signature (appsignature).  
Only change the value for the defaultwsdl configuration item if 
instructed by ExactTarget.

See the ET_Client section below for details on how to specify these 
values at the time the ET_Client object is instantiated if you 
would prefer to store the ClientID and ClientSecret values in a 
database or other configuration storage mechanism. 

If you have not registered your application or you need to lookup 
your Application Key or Application Signature values, please go 
to Salesforce Marketing Cloud App Center.

## Example Request ##
All ExactTarget objects exposed through the Fuel SDK begin with be 
prefixed with "ET\_".  Start by working with the ET_List object:  

See the config.php.template example (under vendor/salesforce-mc/ using 
composer), update to use your clientId & clientSecret.   

Add composer's auto generated autoload.php file, change the path according to your directory structure:
> require \_\_DIR\_\_ . '/../vendor/autoload.php'; 

Add use statement to reference the FuelSdk namespace:
> use FuelSdk\ET_Client;   
> use FuelSdk\ET_List;
<!--
Add a require statement to reference the Fuel SDK's functionality:
> require('ET_Client.php');
-->
Next, create an instance of the ET_Client class:
> $params = [ YOUR_PARAMS_HERE ];
> $myclient = new ET_Client(false, true, $params);

Create an instance of the object type we want to work with:
> $getList = new ET_List();

Associate the ET_Client to the object using the authStub property:
> $getList->authStub = $myclient;

Utilize one of the ET_List methods:
> $getResponse = $getList->get();	

Print out the results for viewing
> print_r($getResponse);

**Example Output:**

<pre>
ET_Get Object
(
    [status] => 1
    [code] => 200
    [message] =>
    [results] => Array
        (
            [0] => stdClass Object
                (
                    [Client] => stdClass Object
                        (
                            [ID] => 1000001
                            [PartnerClientKey] => 
                        )

                    [PartnerKey] =>
                    [CreatedDate] => 2009-06-12T14:42:06.1
                    [ModifiedDate] => 2011-08-17T14:50:30.697
                    [ID] => 1718921
                    [ObjectID] => f41c7d1b-8957-de11-92ee-001cc494ae9e
                    [CustomerKey] => All Subscribers - 578623
                    [ListName] => All Subscribers
                    [Category] => 578623
                    [Type] => Private
                    [Description] => Contains all subscribers
                    [ListClassification] => ExactTargetList
                )

        )

    [request_id] => 5d56a37e-4b13-4f0a-aa13-2e108e60a990
    [moreResults] => 
)
</pre>

## ET\_Client Class ##

The ET\_Client class takes care of many of the required steps when accessing ExactTarget's API, including retrieving appropriate access tokens, handling token state for managing refresh, and determining the appropriate endpoints for API requests.  In order to leverage the advantages this class provides, use a single instance of this class for an entire session.  Do not instantiate a new ET_Client object for each request made. 

The ET_Client class accepts multiple parameters

**Refresh WSDL** - If set to true, it will automatically download a local copy of the WSDL whenever an update is found.
> $myclient = new ET_Client(true);

**Debug** - If set to true, all API requests that the Fuel SDK is making behind the scenes will be logged to PHP's error log.  This option should only be set to true in order to troubleshoot during the development process and should never be used in a production scenario. 
> $myclient = new ET_Client(true,true);

**Parameters** - Allows for passing authentication information for use with SSO with a JWT or for passing ClientID/ClientSecret if you would prefer to not use the config file option. 

Example passing JWT: 
> $myclient = new ET_Client(true, array("jwt"=>"JWT Values goes here"));

Example passing ClientID/ClientSecret: 
> $myclient = new ET_Client(true, array("clientid" => "3bjbc3mg4nbk64z5kzczf89n", "clientsecret"=>"ssnGAPvZg6kmm775KPj2Q4Cs"));

## Responses ##
All methods on Fuel SDK objects return a generic object that follows the same structure, regardless of the type of call.  This object contains a common set of properties used to display details about the request.

- status: Boolean value that indicates if the call was successful
- code: HTTP Error Code (will always be 200 for SOAP requests)
- message: Text values containing more details in the event of an error
- results: Collection containing the details unique to the method called. 

Get Methods also return an addition value to indicate if more information is available (that information can be retrieved using the getMoreResults method):

 - moreResults - Boolean value that indicates on Get requests if more data is available. 


## Samples ##
Find more sample files that illustrate using all of the available functions for ExactTarget objects exposed through the API in the objsamples directory. 

Sample List:

 - [BounceEvent](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-bounceevent.php)
 - [Campaign](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-campaign.php)
 - [ClickEvent](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-clickevent.php)
 - [ContentArea](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-contentarea.php)
 - [DataExtension](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-dataextension.php)
 - [DataExtractActivity](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-data-extract-activity.php)
 - [Email](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-email.php)
 - [Folder](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-folder.php)
 - [List](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-list.php)
 - [List > Subscriber](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-list.subscriber.php)
 - [OpenEvent](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-openevent.php)
 - [ResultMessage](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-resultmessage.php)
 - [SentEvent](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-sentevent.php)
 - [Subscriber](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-subscriber.php)
 - [TriggeredSend](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-triggeredsend.php)
 - [TriggeredSendSummary](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-triggeredsendsummary.php)
 - [UnsubEvent](https://github.com/ExactTarget/FuelSDK-PHP/blob/master/objsamples/sample-unsubevent.php)
