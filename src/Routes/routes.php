<?php
use Illuminate\Http\Request;

Route::get('recommender', function() {

	$result = '<h1>I\'m here to recommend you!</h1>';
	$result .= '<h2> Urls for testing:</h2>';
	$result .= '<h3>Collections:</h3>';
	$result .= 'Get collections <a href="/recommender/test/collections">(/recommender/test/collections)</a></br>';
	$result .= 'Create collection <a href="/recommender/test/collections/create?name=testname">(/recommender/test/collections/create?name=yourcollectionnamehere)</a><br/>';
	$result .= 'Get collection by ID <a href="/recommender/test/collections/{id}">(/recommender/test/collections/{id})</a><br/>';
	$result .= 'Patch collection by ID <a href="/recommender/test/collections/{id}/patch?name=patched">(/recommender/test/collections/{id}/patch?name=yourcollectionnamepatched)</a><br/>';
	$result .= 'Delete collection by ID <a href="/recommender/test/collections/{id}/delete">(/recommender/test/collections/{id}/delete)</a><br/>';

	$result .= '<h3>Items a collection:</h3>';
	$result .= 'Get unique items in a collection<a href="/recommender/test/collections/{id}/items">(/recommender/test/collections/{id}/items)</a><br/>';

	$result .= '<h3>Profiles from a collection:</h3>';

	$result .= 'Get profiles<a href="/recommender/test/collections/{id}/profiles">(/recommender/test/collections/{id}/profiles)</a><br/>';
	$result .= 'Get profile by ID <a href="/recommender/test/collections/{collection-id}/profiles/{profile-id}">(/recommender/test/collections/{collection-id}/profiles/{profile-id})</a><br/>';
	$result .= 'Create profile <a href="/recommender/test/collections/{collection-id}/profiles/create">(/recommender/test/collections/{collection-id}/profiles/create)</a><br/>';
	$result .= 'Update profile <a href="/recommender/test/collections/{collection-id}/profiles/{profile-id}/patch">(/recommender/test/collections/{collection-id}/profiles/{profile-id}/patch)</a><br/>';
	$result .= 'Delete profile <a href="/recommender/test/collections/{collection-id}/profiles/{profile-id}/delete">(/recommender/test/collections/{collection-id}/profiles/{profile-id}/delete)</a><br/>';

	$result .= 'Recommendations <a href="/recommender/test/collections/{collection-id}/profiles/{profile-id}/recommend">(/recommender/test/collections/{collection-id}/profiles/{profile-id}/recommend)</a><br/>';

	return $result;
});

Route::get('recommender/test/collections', function() {
	return  Recommender::getCollections();
});

Route::get('recommender/test/collections/create', function(Request $request) {
	$name = $request->get('name', 'testname');
	$result = Recommender::postCollection($name);
	return $result;
});

Route::get('recommender/test/collections/{id}', function($id) {
	return  Recommender::getCollection($id);
});

Route::get('recommender/test/collections/{id}/patch', function(Request $request, $id) {
	$name = $request->get('name', 'patchname');
	return  Recommender::patchCollection($id, $name);
});

Route::get('recommender/test/collections/{id}/delete', function($id) {
	return  Recommender::deleteCollection($id);
});

Route::get('recommender/test/collections/{id}/items', function($id) {
	return  Recommender::getItems($id);
});

Route::get('recommender/test/collections/{id}/profiles', function($id) {
	return  Recommender::getProfiles($id);
});

Route::get('recommender/test/collections/{collectionId}/profiles/create', function($collectionId) {

	$profile = new \Elphas\Recommender\Profile();
	$profile->items = ['laravel', 'vue', 'php', 'javascript'];
	return  Recommender::postProfile($collectionId, $profile );
});

Route::get('recommender/test/collections/{collectionId}/profiles/{id}', function($collectionId, $id) {
	return  Recommender::getProfile($collectionId, $id, false, false);
});

Route::get('recommender/test/collections/{collectionId}/profiles/{id}/patch', function($collectionId, $id) {

	$profile = Recommender::getProfile($collectionId, $id, false, true);

	$profile->items[] = 'blade';
	return  Recommender::patchProfile($collectionId, $id, $profile);
});

Route::get('recommender/test/collections/{collectionId}/profiles/{id}/delete', function($collectionId, $id) {
	return  Recommender::deleteProfile($collectionId, $id);
});

Route::get('recommender/test/collections/{collectionId}/profiles/{id}/recommend', function($collectionId, $id) {
	return  Recommender::recommend($collectionId, $id, 'all');
});






