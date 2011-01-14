<?php
/**
 * @author $Author$ <papa0924@gmail.com>
 * @link http://www.phpwind.com
 * @copyright Copyright &copy; 2003-2010 phpwind.com
 * @license 
 */

/**
 * 所有module的基础抽象类
 * 主要实现__get(), __set()等方法
 * 通过继承该类
 * 
 * @author Qiong Wu <papa0924@gmail.com>
 * @version $Id$ 
 */
abstract class WindModule extends WindEnableValidateModule {
	
	public function __get($propertyName) {
		if (!$this->_validateProperties($propertyName)) return;
		return $this->$propertyName;
	}
	
	public function __set($propertyName, $value) {
		if (!$this->_validateProperties($propertyName)) return;
		$this->$propertyName = $value;
	}
	
	public function isseted($propertyName) {
		if (!$this->_validateProperties($propertyName)) return;
		return array_key_exists($propertyName, $this->_trace['setted']);
	}
	
	public function toArray() {
		$class = new ReflectionClass(get_class($this));
		$properties = $class->getProperties();
		$vars = array();
		foreach ($properties as $property) {
			$_propertyName = $property->name;
			$vars[$_propertyName] = $this->$_propertyName;
		}
		return $vars;
	}
	
	/**
	 * 验证属性文件是否存在
	 * @param string $propertyName
	 */
	protected function _validateProperties($propertyName) {
		//TODO move this method to formModule
		return $propertyName && array_key_exists($propertyName, get_object_vars($this));
	}
}