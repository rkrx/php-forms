<?php
namespace Kir\Forms\Filtering;

trait FilterAwareTrait {
	/** @var Filter[] */
	private $filters = [];

	/**
	 * @param Filter $filter
	 * @return $this
	 */
	public function addFilter(Filter $filter) {
		$this->filters[] = $filter;
		return $this;
	}

	/**
	 * @return Filter[]
	 */
	protected function getFilters() {
		return $this->filters;
	}
}