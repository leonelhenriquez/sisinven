<?php
	namespace Wave\util{
		class ReflectionClassConstants {
			private static function getConstants() {
				$oClass = new ReflectionClass(get_called_class());
				return $oClass->getConstants();
			}
		}
		class enum extends ReflectionClassConstants{
			private static $constants;

			function __construct(){
				self::getArraysConstants();
			}
			private static function getArraysConstants(){
				if(!isset(self::$constants)){
					self::$constants = parent::getConstants();
				}
			}
			public static function isValid($value){
				self::getArraysConstants();
				return array_key_exists($value, self::$constants);
			}

			/*public static function getValueByKey($key){
				self::getArraysConstants();
				return self::$constants[$key];
			}*/

			/*public static function getKeyByValue($value){
				self::getArraysConstants();
				return (array_flip(self::$constants))[$value];
			}*/
		}
		abstract class BasicEnum { 
			private static $constCacheArray = NULL; 
			private function __construct(){} 

			private static function getConstants() { 
				if (self::$constCacheArray == NULL) { 
					self::$constCacheArray = []; 
				} 
				$calledClass = get_called_class(); 
				if (!array_key_exists($calledClass, self::$constCacheArray)) { 
					$reflect = new ReflectionClass($calledClass); 
					self::$constCacheArray[$calledClass] = $reflect->getConstants(); 
				} 
				return self::$constCacheArray[$calledClass]; 
			} 

			public static function isValidName($name, $strict = false) { 
				$constants = self::getConstants(); 

				if ($strict) { 
					return array_key_exists($name, $constants); 
				} 

				$keys = array_map('strtolower', array_keys($constants)); 
				return in_array(strtolower($name), $keys); 
			} 

			public static function isValidValue($value) { 
				$values = array_values(self::getConstants()); 
				return in_array($value, $values, $strict = true); 
			} 
		}
	}
	/* ejemplo
		abstract class DaysOfWeek extends enum{
			const SUNDAY = 'Sunday';
			const MONDAY = 'Monday';
			const TUESDAY = 'Tuesday';
			const WEDNESDAY = 'Wednesday';
			const THURSDAY = 'Thursday';
			const FRIDAY = 'Friday';
			const SATURDAY = 'Saturday';


			//no realizado aun
			private static $days = [
				self::SUNDAY => 0,
				self::MONDAY => 1,
				self::TUESDAY => 2,
				self::WEDNESDAY => 3,
				self::THURSDAY => 4,
				self::FRIDAY => 5,
				self::SATURDAY => 6,
			];
		}
		echo var_dump(DaysOfWeek::SUNDAY); //Sunday

		echo var_dump(DaysOfWeek::isValidDay('Funday')); //false
		echo var_dump(DaysOfWeek::isValidDay('Monday')); //true

		echo var_dump(DaysOfWeek::getValueByKey('Sunday')); // 0
		echo var_dump(DaysOfWeek::getKeyByValue(0)); // Sunday

		echo print_r(DaysOfWeek::getConstants());
		$te1 = DaysOfWeek::SUNDAY;
		if($te1 == DaysOfWeek::SUNDAY){
			echo "es igual";
		}
	 */