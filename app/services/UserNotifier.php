<?php


namespace App\Services;


use App\Providers\UserTopicProvider;

class UserNotifier
{

	/**
	 * @var UserTopicProvider
	 */
	private $userTopicProvider;
	/**
	 * @var Publisher
	 */
	private $publisher;

	public function __construct(UserTopicProvider $userTopicProvider, Publisher $publisher)
	{

		$this->userTopicProvider = $userTopicProvider;
		$this->publisher = $publisher;
	}


	public function notifyProgress($task, $done, $total)
	{
		$this->publisher->publish($this->userTopicProvider->get(), ['progress'], [
			'taskId' => 'task-'.hash('crc32', $task),
			'task' => $task,
			'done' => $done,
			'total' => $total
		]);
	}

	public function notifyMessage($message)
	{
		$this->publisher->publish($this->userTopicProvider->get(), ['message'], [
			'msg' => $message,
		]);
	}
}
