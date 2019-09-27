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
Create your first app and enter the keys in the .env file.

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
Be careful with this :)
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

__*Update a profile in a collection*__

``` php
$profile = Recommender::getProfile( $collectionId, $profileId, false, true);

$profile->items[] = 'blade';

Recommender::patchProfile( $collectionId, $profileId, $profile)
```

__*Delete a profile in a collection*__
Again be careful with this.

``` php
Recommender::deleteProfile( $collectionId, $profileId)

//or by referenceID

Recommender::deleteProfile( $collectionId, $referenceId, true)
```

### Recommendations
Once a collection has been filled with profiles and items we can do a recommendation for a profile, based on the other profiles in the collection.

``` php
Recommender::recommend( $collectionId, $profileId)
```

Recommendations can be done with three strategies: __*augment*__, __*recommend*__ or __*all*__.

The default strategy for getting a recommendation is the __*recommend*__ strategy.
The __*recommend*__ strategy compares profiles with each other.

The __*augment*__ strategy checks which unique items belong together and how many times this happens.

The __*all*__ strategy combines the strategies. The result will returned per strategy.



``` php

Recommender::recommend( $collectionId, $profileId, 'recommend' )

//or

Recommender::recommend( $collectionId, $profileId, 'augment' )

//or 

Recommender::recommend( $collectionId, $profileId, 'all' )

```

When using the __*augment*__ strategy you will be able to supply a minimal quality setting between 0 and 1.  
The higher the quality the more strict a recommendation will be.

``` php
Recommender::recommend( $collectionId, $profileId, 'augment', 0.7 )
```

There is an option to limit the number of recommendations. The default is *10*:
``` php
Recommender::recommend( $collectionId, $profileId, 'augment', 0.7, 5 )
```

Recommendations based on your own referenceID is also possible:
``` php
Recommender::recommend( $collectionId, $referenceId, 'augment', 0.7, 5, true )
```









	