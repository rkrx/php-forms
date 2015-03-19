<?php
namespace Kir\Forms\Tools;

class EventHandler {
	/** @var callable[] */
	private $events = [];

	/**
	 * @param string $eventName
	 * @param callable $fn
	 * @return $this
	 */
	public function addHandler($eventName, $fn) {
		if(!array_key_exists($eventName, $this->events)) {
			$this->events[$eventName] = [];
		}
		$this->events[$eventName][] = $fn;
		return $this;
	}

	/**
	 * @param string $eventName
	 * @param array $arguments
	 * @return array
	 */
	public function fireEvent($eventName, array $arguments) {
		if(array_key_exists($eventName, $this->events)) {
			foreach($this->events[$eventName] as $event) {
				$arguments = call_user_func($event, $arguments);
			}
		}
		return $arguments;
	}
}