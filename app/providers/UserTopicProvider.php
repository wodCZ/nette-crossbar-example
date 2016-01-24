<?php


namespace App\Providers;


use Nette\Http\Request;
use Nette\Security\User;

class UserTopicProvider
{
	/**
	 * @var User
	 */
	private $user;
	/**
	 * @var Request
	 */
	private $request;

	public function __construct(User $user, Request $request)
	{

		$this->user = $user;
		$this->request = $request;
	}

	public function get()
	{
		return $this->format($this->user->isLoggedIn() ? $this->user->id : $this->request->getRemoteAddress());
	}

	protected function format($identifier)
	{
		return 'user.' . hash('crc32b', $identifier . __DIR__);
	}
}
