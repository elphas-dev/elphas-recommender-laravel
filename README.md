# Elphas Recommender for Laravel
The Elphas recommender is a service for your data. Send in the data, we do some analises and you get back recommendations.

### How to install

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

### What does it do
Explain here :)

### How does it work?

__List of your collections__
``` php
Recommender::getCollections();
```

__Specific collection by collection ID__
``` php
Recommender::getCollection($id);
```

	