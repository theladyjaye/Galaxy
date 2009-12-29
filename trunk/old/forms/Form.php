<?php
$base = dirname(__FILE__);
require $base.'/validators/Validator.php';

interface IFormDelegate
{
	public function willProcessForm(&$form);
	public function didProcessForm(&$form);
}

class Form
{
	const kDataKey     = 'data';
	const kFilesKey    = 'files';
	const kDelegateKey = 'delegate';
	
	public $isValid;
	public $validators;
	
	public $formData;
	public $fileData;
	
	protected $delegate;
	
	public static function formWithContext($context)
	{
		$form = new Form();
		$form->setContext($context);
		$form->validators = array();
		return $form;
	}
	
	public static function formWithArrayAndDelegate(&$array, IFormDelegate &$delegate)
	{
		$context   = array(Form::kDataKey     => &$array,
		                   Form::kFilesKey    => &$_FILES, 
		                   Form::kDelegateKey => $delegate);
		
		return Form::formWithContext($context);
	}
	
	private function setContext($context)
	{
		if(isset($context[Form::kDataKey]))
		{
			$this->formData =& $context[Form::kDataKey];
		}
		
		if(isset($context[Form::kFilesKey]))
		{
			$this->fileData =& $context[Form::kFilesKey];
		}
		
		if(isset($context[Form::kDelegateKey]))
		{
			$this->setDelegate($context[Form::kDelegateKey]);
		}
	}
	
	public function setDelegate(IFormDelegate &$delegate)
	{
		$this->delegate = $delegate;
	}
	
	public function delegate()
	{
		return $this->delegate;
	}
	
	public function addValidator(Validator $validator)
	{
		array_push($this->validators, $validator);
	}
	
	public function process()
	{
		if($this->delegate)
			$this->delegate->willProcessForm($this);
			
		if(count($this->validators))
			$this->validateForm();
		else
			$this->isValid = true;
		
		if($this->delegate)
			$this->delegate->didProcessForm($this);
	}
	
	public function &__get($key)
	{
		$value = null;
		if(isset($this->formData) && isset($this->formData[$key]))
		{
			$value =& $this->formData[$key];
		}
		else if(isset($this->fileData) && isset($this->fileData[$key]))
		{
			$value =& $this->fileData[$key]['name'];
		}
		
		return $value;
	}
	
	protected function validateForm()
	{
		$length  = count($this->validators);
		$tmpFlag = true;
		
		for($i = 0; $i < $length; $i++ )
		{
			$currentValidator =& $this->validators[$i];
			$currentValidator->validate();
			
			if($currentValidator->isRequired)
				$tmpFlag = ($tmpFlag && $currentValidator->isValid);
		}
		
		if($tmpFlag != $this->isValid)
			$this->isValid = $tmpFlag;
		
		if($this->isValid)
			$this->formWillSucceed();
		else
			$this->formWillFail();
	}
	
	protected function formWillSucceed() { }
	protected function formWillFail()
	{
		$this->clearInvalidValues();
	}
	
	protected function clearInvalidValues()
	{
		foreach($this->validators as &$validator)
		{
			if(!$validator->isValid)
			{
				if(is_array($validator->value))
				{
					foreach($validator->value as &$input)
						$input = null;
				}
				else
				{
					$validator->value = null;
				}
			}
		}
	}
}

?>