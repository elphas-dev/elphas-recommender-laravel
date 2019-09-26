<?php

namespace Elphas\Recommender;


//use Mollie\Laravel\Wrappers\MollieApiWrapper;
use Illuminate\Contracts\Config\Repository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * (Facade) Class Recommender.
 *
 */
class Recommender
{

	protected $config;

	protected $apiKey;
	protected $secretKey;
	protected $random;

	protected $client;


	public function __construct(Repository $config)
	{

		$this->config = $config;

		$this->apiKey = $this->config->get('recommender.apiKey');
		$this->secretKey = $this->config->get('recommender.secretKey');

		$this->client = new Client(['base_uri' => $this->config->get('recommender.baseUri')]);

	}

	/**
	 * @param $method
	 * @param $url
	 * @param array $body
	 * @return array|mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function call($method, $url, $body = []){
		try {
			$ivAndEncryption = $this->createIVAndEncryption();
			$signature = $this->createSignature($ivAndEncryption);

			$response = $this->client->request($method, $url, [
					'headers' => [
						'Authorization' => $this->apiKey . '.' . $ivAndEncryption . '.' . $signature,
						'Content-Type' => 'application/json'
					],
					'body' => json_encode($body)
				]
			);
			$response_data = json_decode($response->getBody(), true);
			$statusCode = $response->getStatusCode();

			if ($statusCode == 204) {
				return ['statusCode'=> $statusCode, 'success'=>true, 'message'=>'Executed call successful'] ;
			}
			return $response_data;

		} catch (RequestException $e) {
			$responseBody = json_decode($e->getResponse()->getBody(),true);
			return ['message'=> $responseBody['message'], 'code'=>$e->getCode()];//new RecommenderException($e->getMessage(), $e->getCode());
		}
	}


	/*
	 * Collections
	 */

	/**
	 * @return array|mixed
	 */
	public function getCollections(){
		return $this->call('GET', 'collections');
	}

	/**
	 * @param $id
	 * @return array|mixed
	 */
	public function getCollection($id){
		return $this->call('GET', 'collections/'.$id);
	}

	/**
	 * @param $name
	 * @return array|mixed
	 */
	public function postCollection($name){
		return $this->call('POST', 'collections', ['name' => $name]);
	}

	/**
	 * @param $id
	 * @param $name
	 * @return array|mixed
	 */
	public function patchCollection($id, $name){
		return $this->call('PATCH', 'collections/'.$id, ['name' => $name]);
	}

	/**
	 * @param $id
	 * @return array|mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function deleteCollection($id){
		return $this->call('DELETE', 'collections/'.$id);
	}


	/*
	 * items
	 */

	/**
	 * @param $collectionId
	 * @return array|mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getItems($collectionId)
	{
		$result = Recommender::call('GET', 'collections/' . $collectionId . '/items');
		return $result;

	}

	/*
	 * Profiles
	 */

	/**
	 * @param $collectionId
	 * @return array|mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getProfiles($collectionId)
	{
		$result = Recommender::call('GET', 'collections/' . $collectionId . '/profiles');
		return $result;

	}

	/**
	 * @param $collectionId
	 * @param $id
	 * @param bool $byReferenceId
	 * @param bool $obj
	 * @return array|Profile|mixed
	 */
	public function getProfile($collectionId, $id, $byReferenceId = false, $obj = false)
	{
		$ref = '';
		if($byReferenceId){
			$ref = '?ref=1';
		}

		$result = Recommender::call('GET', 'collections/' . $collectionId . '/profiles/' . $id .$ref);
		if ($obj) {
			 return Profile::withJson($result);
		} else {
			return $result;
		}
	}

	/**
	 * @param $collectionId
	 * @param Profile $profile
	 * @param bool $obj
	 * @return array|Profile|mixed
	 */
	public function postProfile($collectionId, Profile $profile, $obj = false){
		$result =  Recommender::call('POST', 'collections/' .$collectionId . '/profiles', $profile->serialize());
		if ($obj) {
			return Profile::withJson($result);
		} else {
			return $result;
		}
	}

	/**
	 * @param $collectionId
	 * @param $id
	 * @param Profile $profile
	 * @param bool $byReferenceId
	 * @param bool $obj
	 * @return array|Profile|mixed
	 */
	public function patchProfile($collectionId, $id, Profile $profile, $byReferenceId = false, $obj = false)
	{
		$ref = '';
		if($byReferenceId){
			$ref = '?ref=1';
		}

		$result = Recommender::call('PATCH', 'collections/' . $collectionId . '/profiles/' . $id .$ref, $profile->serialize() );
		if ($obj) {
			return Profile::withJson($result);
		} else {
			return $result;
		}
	}


	/**
	 * @param $collectionId
	 * @param $id
	 * @param bool $byReferenceId
	 * @return array|mixed
	 */
	public function deleteProfile($collectionId, $id, $byReferenceId = false){
		$ref = '';
		if($byReferenceId) {
			$ref = '?ref=1';
		}
		return Recommender::call('DELETE', 'collections/' .$collectionId .'/profiles/' .$id .$ref);
	}

	/**
	 *
	 * From the collection and profile it will provide a suggestion which item could be added to the profile based on other profiles in the collection.
	 *
	 * @param $collectionId
	 * @param $profileid
	 * @param array $query This is an example: ['ref'=>0,'strategy'=>'recommend', 'limit'=>'', 'quality'=>''].
	 * @return array|mixed
	 *
	 */
	public function suggest($collectionId, $profileid, $query = []){
		$queryString = '';
		if(!empty($query)){
			$queryString = '?' . http_build_query($query, null, '&');
		}

		return Recommender::call('GET', 'collections/' .$collectionId .'/profiles/' .$profileid .'/suggest' .$queryString);
	}


	private function AESEncryption($data, $secret) {
		$iv = openssl_random_pseudo_bytes( openssl_cipher_iv_length( 'aes-256-cbc' ) );
		$encrypted = openssl_encrypt( $data, 'aes-256-cbc', $secret, OPENSSL_RAW_DATA, $iv );

		return base64_encode( $iv . $encrypted );
	}

	private function createIVAndEncryption(){
		$this->random = bin2hex(random_bytes(10));
		$randomAndApiKey = $this->random . $this->apiKey;
		$randomAndApiKey = utf8_encode($randomAndApiKey);
		$ivAndEncryption = $this->AESEncryption($randomAndApiKey, $this->secretKey);
		return $ivAndEncryption;
	}

	private function createSignature($ivAndEncryption){
		$hashed_json_string = hash('sha256', $this->random);
		return $hashed_json_string;
	}

}