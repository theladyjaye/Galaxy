<?php
class SubscriptionDetail
{
	
	public $data;
	
	public function __construct($data)
	{
		$this->data = $data;
	}
	
	public function __toString()
	{
		$source  = $_SERVER['DOCUMENT_ROOT'].'/application/controls/SubscriptionDetail.html';
		
		$this->data['permission_read']   = RenegadeConstants::kPermissionRead;
		$this->data['permission_write']  = RenegadeConstants::kPermissionWrite;
		$this->data['permission_delete'] = RenegadeConstants::kPermissionDelete;
		$this->data['has_read']          = ($this->data['permissions'] & RenegadeConstants::kPermissionRead)   ? 'checked' : '';
		$this->data['has_write']         = ($this->data['permissions'] & RenegadeConstants::kPermissionWrite)  ? 'checked' : '';
		$this->data['has_delete']        = ($this->data['permissions'] & RenegadeConstants::kPermissionDelete) ? 'checked' : '';
		$this->data['action']            = $_SERVER['REDIRECT_URL'];
		return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($source, $this->data);
		
	}
}
?>