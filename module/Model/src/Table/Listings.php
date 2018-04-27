<?php
declare(strict_types=1);
namespace Model\Table;

use Exception;
use Zend\Db\Sql\ {Sql,Where};
use Zend\Db\TableGateway\TableGateway;
class Listings extends TableGateway
{
	const TABLE_NAME = 'listings';
	public function findLatest()
	{
		$select = (new Sql($this->getAdapter()))->select();
		$select->from(self::TABLE_NAME)
		       ->order('listings_id DESC')
		       ->limit(1);
		$result = $this->selectWith($select)->current();
		return $result;
	}
	public function findByCategory(string $category)
	{
		return $this->select(['category' => $category]);
	}
	public function findById(int $id)
	{
		return $this->select(['listings_id' => $id])->current();
	}
	public function save(array $data)
	{
		// sanitize some of the data
		// use $this->getDateExpires() to produce a date from the "expires" form entry
		// remove array items which are not database columns
		try {
			return $this->insert($data);
		} catch (Exception $e) {
			// log the info
			// return FALSE
		}
	}
	public function getDateExpires(int $expires)
	{
		// add the number of days represented by $expires
		// return a date string
	}
}
