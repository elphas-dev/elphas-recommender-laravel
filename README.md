# Elphas Recommender for Laravel
The Elphas recommender is a service for your data. Send in the data, we do some analyses and you get back recommendations.

## How to install

Go to your Laravel project where you would like to use Elphas Recommender and 
install via composer:
``` bash
composer require elphas/recommender 
```

Register API key and secret key for your app in the .env file
``` text
RECOMMENDER_APIKEY=<your-api-key-here>
RECOMMENDER_SECRETKEY=<your-secret-key-here>
```

No Api key yet? 

Sign up here: [http://test.developer.elphas.ai](http://test.developer.elphas.ai).  
Create your first app and enter they keys in the .env file.

## What does it do
Explain here :)

## How does it work?

### Collections

__*List of your collections*__
``` php
Recommender::getCollections();
```

__*Create new collection*__
``` php
Recommender::postCollection( 'Name of the collection' );
```

__*Get specific collection by collection ID*__
``` php
Recommender::getCollection( $collectionId );
```

__*Change the name of the collection*__
``` php
Recommender::patchCollection( $collectionId, $name )
```

__*Delete the collection*__  
Be carefull with this :)
``` php
Recommender::deleteCollection( $collectionId );
```

### Items

__*Get the unique items in a collection*__ 

``` php
Recommender::getItems( $collectionId );
```

### Profiles

__*Get all profiles of a collection*__

``` php
Recommender::getProfiles( $collectionId );
```


__*Create new profile in a collection*__

``` php
$profile = new \Elphas\Recommender\Profile();
$profile->items = [ 'laravel', 'vue', 'php', 'javascript' ];
Recommender::postProfile( $collectionId, $profile );

//or

$profile2 = new \Elphas\Recommender\Profile( null, null, [ 'laravel', 'vue', 'php', 'javascript' ] );
Recommender::postProfile( $collectionId, $profile2 );

```

Supply a reference id so that you can match the profile with your own system
``` php
$profileWithRef = new \Elphas\Recommender\Profile( null, $referenceId, [ 'laravel', 'vue', 'php', 'javascript' ] );
Recommender::postProfile( $collectionId, $profileWithRef );
```

__*Get a profile in a collection*__



``` php
Recommender::getProfile( $collectionId, $profileId);

//by your reference ID

Recommender::getProfile( $collectionId, $referenceId, true);

//as an Elphas Profile instance

$profile = Recommender::getProfile( $collectionId, $profileId, false, true);


```




### Suggestions


## Examples








	