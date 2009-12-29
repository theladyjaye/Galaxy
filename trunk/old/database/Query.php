<?php
class Query implements Iterator, Countable
{
	public $sql            = '';	
	public $resultsAsArray = true;
	public $domain;
	
	protected $currentIndex;
	protected $result;
	
	protected $filters;
	protected $tables;
	protected $sorts;
	protected $greedy;
	
	function __construct($ORMObjectString = NULL)
	{
		if($ORMObjectString)
		{
			$this->domain = $ORMObjectString;
			$this->table($this->domain);
		}
	}
	
	public function execute()
	{
		$dbh  =& Database::connection();
		$this->result = $dbh->prepare($this->__toString());
		$this->result->execute();
		Database::commit();
		$dbh = null;
	}
	
	public function __toString()
	{
		return $this->sql;
	}
	
	public function sort($value)
	{
		if(!$this->sorts)
			$this->sorts = array();
		
		$this->sorts[] = $value;
	}
	
	public function greedyLoad($foreignColumn)
	{
		if(!$this->greedy)
			$this->greedy = array();
		
		$this->greedy[] = $foreignColumn;
	}
	
	public function table($string)
	{
		if(!$this->tables)
			$this->tables = array();
		
		$this->tables[] = $string;
	}
	
	public function filter($values, $type='AND')
	{
		if(!$this->filters)
			$this->filters = array();
		else
			$this->filters[] = ' '.$type.' ';
			
		if(is_array($values))
		{
			while(count($values))
			{
				$this->filters[] = array_shift($values);
				if(count($values))
					$this->filters[] = ' '.$type.' ';
					
				$this->filters[] = $filter; 
			}
		}
		else
		{
			$this->filters[] = $values;
		}
	}
	
	public function count()
	{
		if($this->result)
		{
			return $this->result->rowCount();
		}
		else
		{
			$this->execute();
			return $this->result->rowCount();
		}
	}
	
	public function all()
	{
		$array = array();
		
		if(!$this->result)
			$this->execute();
		
		if($this->count == 1)
		{
			return $array[] = $this->one();
		}
		else
		{
			foreach($this as $row)
			{
				$array[] = $row;
			}
		}
		
		return $array;
	}
	
	public function one()
	{
		if(!$this->result)
			$this->execute();
			
		$row = $this->result->fetch(PDO::FETCH_ASSOC);
		$obj = null;
		
		if($this->resultsAsArray)
		{
			$obj = $row;
		}
		else
		{
			if($row)
			{
				if($this->domain)
				{
					$this->initObjectWithDomainAndArray($this->domain, $row, $obj);
				}
				else
				{
					throw new Exception('No domain specified for query, returning array');
					$obj = $row;
				}
			}
		}
		
		return $obj;
	}
	
	protected function initObjectWithDomainAndArray(&$domain, &$array, &$obj)
	{
		$obj        = new $domain();
		$obj->isNew = false;
		$alias      = strtolower($domain);
		
		foreach($obj->columns as $key=>$value)
		{
			if (!($value instanceof IIgnorableColumn))
			{
				if(array_key_exists($alias."_".$key, $array) && $array[$alias."_".$key]){
					//echo $alias."_".$key, ': ', $array[$alias."_".$key] , '<br>';
					$obj->columns[$key]->value = stripslashes($array[$alias."_".$key]);
				}
			
				if($value instanceof ForeignKey)
				{
					if($this->greedy)
					{
						if(in_array($key, $this->greedy))
						{
							$newAlias = strtolower(get_class($value->relation));
						
							foreach($value->relation->columns as $altKey=>$altValue)
							{
								if (!($altValue instanceof IIgnorableColumn))
									$obj->columns[$key]->relation->$altKey = stripslashes($array[$newAlias."_".$altKey]);
							}
						}
					}
				}
			}
		}
	}
	
	/* ITERATOR METHODS */
	
	public function rewind() 
	{    
		if(!$this->result)
			$this->execute();
		
		$this->currentIndex = 0;
	}

	public function current() 
	{
		$row    = $this->result->fetch(PDO::FETCH_ASSOC);
		$obj    = null;
		
		if($this->resultsAsArray)
		{
			$obj = $row;
		}
		else
		{
			if($this->domain)
			{
				$this->initObjectWithDomainAndArray($this->domain, $row, $obj);
			}
			else
			{
				throw new Exception('No domain specified for query, returning array');
				$obj = $row;
			}
		}
		
		return $obj;
	}

	public function key() 
	{
		return $this->currentIndex;
	}

	public function next() 
	{
		$this->currentIndex++;
	}

	public function valid() 
	{
		$var =  $this->currentIndex < count($this);
		return $var;
	}
	
	public function __destruct()
	{
		$this->result = null;
		$this->sql    = null;
	}
}
?>