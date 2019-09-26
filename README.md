# Elphas Recommender for Laravel
The Elphas recommender is a service for your data. Send in the data, we do some analises and you get back recommendations.

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

*List of your collections*
``` php
Recommender::getCollections();
```

*Create new collection*
``` php
Recommender::postCollection( 'Name of the collection' );
```

*Get specific collection by collection ID*
``` php
Recommender::getCollection( $collectionId );
```

*Change the name of the collection*
``` php
Recommender::patchCollection( $collectionId, $name )
```

*Delete the collection*  
Be carefull with this :)
``` php
Recommender::deleteCollection( $collectionId );
```

### Items

*Get the unique items in a collection*  

``` php
Recommender::getItems( $collectionId );
```

### Profiles

*Get all profiles of a collection*

``` php
Recommender::getProfiles( $collectionId );
```


*Create new profile in collection*

``` php
$profile = new \Elphas\Recommender\Profile();
$profile->items = [ 'laravel', 'vue', 'php', 'javascript' ];
Recommender::postProfile( $collectionId, $profile );

//or

$profile2 = new \Elphas\Recommender\Profile( null, null, [ 'laravel', 'vue', 'php', 'javascript' ] );
Recommender::postProfile( $collectionId, $profile2 );

//or with a reference id so that you can match the profile with your system

$profileWithRef = new \Elphas\Recommender\Profile( null, $referenceId, [ 'laravel', 'vue', 'php', 'javascript' ] );
Recommender::postProfile( $collectionId, $profileWithRef );
```


### Suggestions


## Examples








	