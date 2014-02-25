<pre>
     _                 _                           _
 ___(_)_ __ ___  _ __ | | ___  _ __     __ _ _ __ | |_   _ ___
/ __| | '_ ` _ \| '_ \| |/ _ \| '_ \   / _` | '_ \| | | | / __|
\__ \ | | | | | | |_) | | (_) | | | | | (_| | |_) | | |_| \__ \
|___/_|_| |_| |_| .__/|_|\___/|_| |_|  \__, | .__/|_|\__,_|___/
                |_|                    |___/|_|
</pre>

# Simplon/Gplus

1. __Installing__  
2. __Setup Gplus module__  
2.1. Create authentication container  
2.2. Create Gplus module instance  
3. __Usage__  
3.1. Request authentication url  
3.2. Request AccessToken  
3.3. Read user profile data  
3.4. Refresh AccessToken manually    
4. __Full example__

-------------------------------------------------

### Dependecies

- PHP >= 5.4
- CURL

-------------------------------------------------

## 1. Installing

Install easy via composer:

```json
{
  "require": {
    "simplon/gplus": "0.0.*"
  }
}
```

-------------------------------------------------

## 2. Setup Gplus module

For all calls we wanna make we need to initialise our Gplus module with our ```Google Api credentials```. If you happen to miss these credentials hop over to [Google's console](https://cloud.google.com/console) and create them.

### 2.1. Create authentication container

We use a [value object](http://css.dzone.com/books/practical-php-patterns/basic/practical-php-patterns-value) to hold our credentials. I love value objects because of their clear communication what kind of data they hold.

```php
$authVo = (new \Simplon\Gplus\Vo\GplusAuthVo())
    ->setClientId(CLIENT_ID)
    ->setClientSecret(CLIENT_SECRET)
    ->setUrlRedirect(AUTH_URL_REDIRECT); // URL to which google redirects after authentication
```

__Enforce authentication prompt:__
By default Google determines automatically if the has to approve your app. This means that the first time the user will see a prompt while on the second time the user would be directly redirected to the given ```AUTH_URL_REDIRECT```.
 
For testing purposes I found it ideal to enforce the constant appearance of the prompt upon authentication. To enable this the following should work just fine: 

```php
$authVo = (new \Simplon\Gplus\Vo\GplusAuthVo())
    ->setClientId(CLIENT_ID)
    ->setClientSecret(CLIENT_SECRET)
    ->setUrlRedirect(AUTH_URL_REDIRECT);
    ->forceApprovalPrompt();
```

### 2.2. Create Gplus module instance

Alright, now that we have our ```GplusAuthVo``` we can proceed to create our ```Gplus``` instance.

```php
// pass our prior created authVo
$gplus = new \Simplon\Gplus\Gplus($authVo);
```

-------------------------------------------------

## 3. Usage

This scenario shows an authentication flow initialised via the server. If you happen to have already an ```accessToken``` and ```refreshToken``` you can jump straight to point ```3.3```.

__Remember:__ We need the prior created Gplus instance ```$gplus``` in order to interact with Google's API.

### 3.1. Request authentication url

We need an ```authentication url``` which we can pass to a web client which in turn should open it. We also need to tell Google for which scopes we request permission. Here is a list of [possible scopes](https://developers.google.com/+/api/oauth#login-scopes).

For this example we will request access to the ```user's email``` and his/her ```profile data```. __Note:__ In the following example I use a set of ```class constants``` which helps me to avoid typos etc. I suggest you do the same since it helps you to keep track of data within your code. 
 
```php
// with class constants (highly recommended)
$scopes = [
    \Simplon\Gplus\GplusConstants::AUTH_SCOPE_EMAIL,
    \Simplon\Gplus\GplusConstants::AUTH_SCOPE_PROFILE,
];

// without class constants
$scopes = ['email', 'profile',];
```

Now, lets fetch the ```authentication url```. This URL should be passed to the web client which redirects the user to Google's authentication process. 

```php
// pass prior defined $scopes
$urlAuth = $gplus->getAuthUrl($scopes);
```

### 3.2. Request AccessToken

When everything went fine Google will redirect to our prior defined ```AUTH_URL_REDIRECT``` with a GET parameter named ```code``` which is attached to the url. We will use this code now to exchange it for a valid ```accessToken```.
 
```php
if(isset($_GET['code']))
{
    $gplusRequestAccessTokenVo = $gplus->requestAccessToken($_GET['code']);
    
    if($gplusRequestAccessTokenVo !== FALSE)
    {
        echo $gplusRequestAccessTokenVo->getAccessToken();
        echo $gplusRequestAccessTokenVo->getRefreshToken();
    }
}
```

If everything went fine we will receive a bunch of data via ```$gplusRequestAccessTokenVo``` which is another value object. Actually we are mostly interested in only two variables: ```accessToken``` and its ```refreshToken```.

The ```accessToken``` will give us access to the requested ```scopes``` while the ```refreshToken``` will renew the ```accessToken``` as soon as it ended its life time (2 hours). Therefore, its important to save both tokens and never to lose the ```refreshToken```.

### 3.3. Read user profile data

In order to read a user's profile data we need the aforementioned tokens:

```php
$gplusPersonVo = $gplus->getUserDetails($accessToken, $refreshToken);
```

If the call succeeds you will receive a ```GplusPersonVo``` which holds all basic profile data:
 
```php
$gplusPersonVo->getAccessToken();
$gplusPersonVo->getDisplayName();
$gplusPersonVo->getEmailAccount();
$gplusPersonVo->getEmails();
$gplusPersonVo->getGender();
$gplusPersonVo->getId();
$gplusPersonVo->getLanguage();
$gplusPersonVo->getRefreshToken();
$gplusPersonVo->getUrlImage();
$gplusPersonVo->getUrlImageBySize($squareSizePixel = 50);
$gplusPersonVo->getUrlProfile();
$gplusPersonVo->getVerified();
$gplusPersonVo->isNewAccessToken();
$gplusPersonVo->isVerified();
```

There is still a bunch of data left which can be accessed as array via ```$gplusPersonVo->getRawData()```. If the ```accessToken``` is not valid anymore the method will automatically try to renew it by the help of the ```refreshToken```. In case of failure you will receive a ```GplusException```. 

### 3.4. Refresh AccessToken manually

In order to receive a fresh ```accessToken``` you should call the following method. If the call succeeds you will receive ```GplusRefreshAccessTokenVo``` which holds among other things a fresh accessToken - ```$gplusRefreshAccessTokenVo->getAccessToken()```.

```php
$gplusRefreshAccessTokenVo = $gplus->refreshAccessToken($refreshToken);
```

In case of a unsuccessful call you will either receive ```FALSE``` or an ```GplusException```.

-------------------------------------------------

## 4. Full example

Following a full length example of the above described process flow:

```php
// set credentials
$authVo = (new \Simplon\Gplus\Vo\GplusAuthVo())
    ->setClientId(CLIENT_ID)
    ->setClientSecret(CLIENT_SECRET)
    ->setUrlRedirect(AUTH_URL_REDIRECT);
    
// create instance
$gplus = new \Simplon\Gplus\Gplus($authVo);

// set permission scopes
$scopes = [
    \Simplon\Gplus\GplusConstants::AUTH_SCOPE_EMAIL,
    \Simplon\Gplus\GplusConstants::AUTH_SCOPE_PROFILE,
];

// get auth url
$urlAuth = $gplus->getAuthUrl($scopes);

// --> redirect user to Google's authentication page

// ##############################################

// <-- user comes back with code ...

if(isset($_GET['code']))
{
    // get accessToken + refreshToken
    $gplusRequestAccessTokenVo = $gplus->requestAccessToken($_GET['code']);
    
    if($gplusRequestAccessTokenVo !== FALSE)
    {
        // --> save accessToken + refreshToken for offline access to DB ...
        
        // fetch profile data
        $gplusPersonVo = $gplus->getUserDetails(
            $gplusRequestAccessTokenVo->getAccessToken(),
            $gplusRequestAccessTokenVo->getRefreshToken()
        );
        
        // print data
        var_dump($gplusPersonVo);
    }
}
```

# License
Cirrus is freely distributable under the terms of the MIT license.

Copyright (c) 2014 Tino Ehrich ([opensource@efides.com](mailto:opensource@efides.com))

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/fightbulc/simplon_gplus/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

