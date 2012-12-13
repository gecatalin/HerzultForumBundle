<?php

namespace Herzult\Bundle\ForumBundle\Model;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

abstract class Forum{
	 protected $id;
	 protected $owningEntityId;
	 protected $owningEntityClass;


	 public function getId()
	 
	 {
	 
	     return $this->id;
	 
	 }
	 
	 
	 
	 public function setId($id)
	 
	 {
	 
	     $this->id = $id;
	 
	     return $this;
	 
	 }
	 public function getOwningEntityId()
	 
	 {
	 
	     return $this->owningEntityId;
	 
	 }
	 
	 
	 
	 public function setOwningEntityId($owningEntityId)
	 
	 {
	 
	     $this->owningEntityId = $owningEntityId;
	 
	     return $this;
	 
	 }
	 public function getOwningEntityClass()
	 
	 {
	 
	     return $this->owningEntityClass;
	 
	 }
	 
	 
	 
	 public function setOwningEntityClass($owningEntityClass)
	 
	 {
	 
	     $this->owningEntityClass = $owningEntityClass;
	 
	     return $this;
	 
	 }
	 
	 
	
	 
	 
}