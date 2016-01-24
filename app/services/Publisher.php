<?php


namespace App\Services;


use GuzzleHttp\Client;

class Publisher
{

	/**
	 * @var \GuzzleHttp\Client
	 */
	private $client;

	public function __construct()
	{

		$config = [];
		$config['defaults']['headers']['Content-Type'] = 'application/json';

		$config['base_url'] = 'http://localhost:8080/publish';

		$this->client = new Client($config);
	}


	/**
	 * @param $topic string
	 * @param $args array|null
	 * @param $kwargs array|null
	 * @return array JSON decoded response
	 * @throws \Exception
	 */
	public function publish($topic, array $args = NULL, array $kwargs = NULL)
	{
		$request = $this->client->createRequest(
			'POST',
			NULL,
			array(
				'body' => $this->prepareBody($topic, $args, $kwargs),
				'query' => $this->prepareQuery()
			)
		);
		try {
			$response = $this->client->send($request);
		} catch (\Exception $e) {
			throw $e;
		}
		return $response->json();
	}

	/**
	 * @param $topic
	 * @param $args
	 * @param $kwargs
	 * @return string
	 */
	private function prepareBody($topic, $args, $kwargs)
	{
		$body = array();
		$body['topic'] = $topic;
		if (!is_null($args)) {
			$body['args'] = $args;
		}
		if (!is_null($kwargs)) {
			$body['kwargs'] = $kwargs;
		}
		return json_encode($body);
	}

	/**
	 * @return array
	 */
	private function prepareQuery()
	{
		$query = array();
		$seq = rand(0, pow(2, 12));
		$now = new \DateTime('now', new \DateTimeZone('UTC'));
		$timestamp = $now->format("Y-m-d\TH:i:s.u\Z");
		$query['seq'] = $seq;
		$query['timestamp'] = $timestamp;
		return $query;
	}
}
