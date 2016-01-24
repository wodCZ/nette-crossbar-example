<?php

namespace App\Presenters;

use App\Providers\UserTopicProvider;
use App\Services\UserNotifier;
use Nette;


class HomepagePresenter extends Nette\Application\UI\Presenter
{

	/**
	 * @var UserTopicProvider
	 * @inject
	 */
	public $userTopicProvider;

	/**
	 * @var UserNotifier
	 * @inject
	 */
	public $userNotifier;

	public function actionGetTopics()
	{
		$this->sendJson([$this->userTopicProvider->get()]);
	}


	public function actionHeavyAction()
	{
		$totalRows = rand(75, 125);
		for($row = 0; $row <= $totalRows; $row++){
			$this->userNotifier->notifyProgress('heavy action', $row, $totalRows);
			usleep(rand(20000, 100000));
		}

		$this->userNotifier->notifyMessage('Heavy task done!');


		$this->setView('default');
	}
}
