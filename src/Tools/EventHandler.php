<?php
namespace Kir\Forms\Tools;

class EventHandler {
	/** @var callable[][] */
	private $preEvents = [];
	/** @var callable[][] */
	private $postEvents = [];

	/**
	 * @param string $eventName
	 * @param callable $fn
	 * @return $this
	 */
	public function prependHandler($eventName, $fn) {
		if(!array_key_exists($eventName, $this->preEvents)) {
			$this->preEvents[$eventName] = [];
		}
		$data = $this->preEvents[$eventName];
		array_unshift($data, $fn);
		$this->preEvents[$eventName] = $data;
		return $this;
	}

	/**
	 * @param string $eventName
	 * @param callable $fn
	 * @return $this
	 */
	public function appendHandler($eventName, $fn) {
		if(!array_key_exists($eventName, $this->postEvents)) {
			$this->postEvents[$eventName] = [];
		}
		$this->postEvents[$eventName][] = $fn;
		return $this;
	}

	/**
	 * @param string $eventName
	 * @param mixed $argument
	 * @return array
	 */
	public function fireEvent($eventName, $argument) {
		if(array_key_exists($eventName, $this->preEvents)) {
			foreach($this->preEvents[$eventName] as $event) {
				$argument = call_user_func($event, $argument);
			}
		}
		if(array_key_exists($eventName, $this->postEvents)) {
			foreach($this->postEvents[$eventName] as $event) {
				$argument = call_user_func($event, $argument);
			}
		}
		return $argument;
	}
}