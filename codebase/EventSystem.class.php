<?php
	class EventSystem
	{
		// Liste der registrierten Events
		private static $events = array();
		
		// Globaler Zählerhler der jeden Eventeintrag eindeutig identifiziert
		private static $id_counter = 0;
		
		// Ergebnisliste
		private static $results = NULL;
	 
		// Fügt einem Event eine Funktion/Methode hinzu
		public static function registerEvent($name, $function_name, $class_name='', $priority=3)
		{
		    // Bei jeder neuen Registrierung wird der globaler Zähler um eins erhöht.
		    self::$id_counter++;
		    $name = strtolower($name);
		    if (!isset(self::$events[$name]))
		    {
		      // Wenn noch kein Eintrag für diese Event existiert, wird ein Neuer angelegt
		      self::$events[$name] = array();
		      self::$events[$name][] = array('id'=>self::$id_counter, 'priority'=>$priority, 'function_name'=>$function_name, 'class_name'=>$class_name);
		    }
		    else
		    {
		      // Existiert bereits ein Eintrag für das Event, wird der Neue angehangen
		      self::$events[$name][] = array('id'=>self::$id_counter, 'priority'=>$priority, 'function_name'=>$function_name, 'class_name'=>$class_name);
		      // Im Anschluss wird nach Priorität (bzw. bei Gleichheit nach Registrierungsreihenfolge) sortiert.
		      usort(self::$events[$name], 'self::compareEventPriorities');
		    };
		    //echo "<hr/>". self::$id_counter.'<br/>';
		    //var_dump(self::$events);
	  	}
		
	  	// Vergleicht zwei Events nach Priorität
		private static function compareEventPriorities($a, $b)
		{
		    if ($a['priority'] > $b['priority']) return 1;
		    if ($a['priority'] < $b['priority']) return -1;
		    // Sind die Prioritätswerte identisch, so wird nach der Registrierungsreihenfolge sortiert
		    if ($a['id'] < $b['id']) return 1;
		    if ($a['id'] > $b['id']) return -1;
		    return 0;
		}

		// Vergleicht zwei Zeiten (Alt vor Jung)
		public static function compareTimes($a, $b)
		{
		    if ($a['time'] > $b['time']) return 1;
		    if ($a['time'] < $b['time']) return -1;
		    return 0;
		}

		// Führt ein Event aus
		public static function handleEvent($name, $time, $params)
		{
		    // Prüfen ob mind. ein Eintrag für dieses Event existiert
		    $name = strtolower($name);
		    if (!isset(self::$events[$name]) || empty(self::$events[$name])) return false;
		    // Alle registrierten Funktionen/Methoden nacheinander ausführen
		    $result = false;
		    foreach(self::$events[$name] as $event)
		    {
				// Wurde eine Klasse angegeben?
				if (!empty($event['class_name']))
				{
			        // .. so handelt es sich um eine Methode
			        $index = strtolower($event['class_name'].'::'.$event['function_name']);
			        // Aufruf der Methode mit $time und $params als Parameter
			        echo "<hr/>".$event['class_name'].' | '.$event['function_name']." | $time | ";
			        var_dump($params);
			        $result = call_user_func(array($event['class_name'], $event['function_name']), $time, $params);
		      	}
		      	else
		      	{
			        // .. andernfalls um eine Funktion
			        $index = strtolower($event['function_name']);
			        // Aufruf der Methode mit $time und $params als Parameter
			        $result = call_user_func($event['function_name'], $time, $params);
				};
				// Das Ergebnis der Funktion/Methode wird in der Ergebnismenge gespeichert
				self::$results[$name][$index] = $result;
				if ($result===false) break;
		    };
		    // Das letzte Ergebnis wird zurück gegeben
		    return $result;
		}

		// Liefert die letzte Ergebnisliste des gewünschten Events.
		public static function getResult($event_name, $calling_name='')
		{
		    $name = strtolower($name);
		    if (!isset(self::$results[$name]) || empty(self::$results[$name])) return false;
		    if (!empty($calling_name)) 
		    {
			      $calling_name = strtolower($calling_name);
			      if (!isset(self::$results[$name][$calling_name]) || empty(self::$results[$name][$calling_name])) return false;
			      return self::$results[$name][$calling_name];
		    };
		    end(self::$results[$name]);
		    $key = key(self::$results[$name]);
		    return self::$results[$name][$key];
		}
		// Liefert alle Ergebnislisten.
		public static function getResults($event_name='')
		{
		    if (!empty($event_name))
		    {
			      // Wird ein Eventname angegeben, wird zunächst geprüft ob dieser existiert ..
			      $name = strtolower($name);
			      if (!isset(self::$results[$name]) || empty(self::$results[$name])) return false;
			      // .. und bei erfolgreichen Prüfung zurückgegeben
			      return self::$results[$name];
		    }
		    else
		    {
			      // Wird kein Eventname angegeben, wird die gesamte Ergebnisliste zurückgegeben
			      return self::$results;
		    }
		}

		// Setzt alle Ergebnisse zurück
		public static function resetResults(){ self::$results = array(); }
	}
		 
	// Sammlung von Skripten die in den Events aufgerufen werden
	class EventScripts1
	{
		public static function scriptA($calling_time, $params)
		{
			return $calling_time.' | '.$params['soldiers'].' Soldaten erreichen das Heimatdorf.';
		}
		
		public static function scriptB($calling_time, $params)
		{
			return $calling_time.' | '.'Folgende Waren werden ins Lager gebracht: Gold='.intval($params['gold']).', Holz='.intval($params['wood']);
		}
		  
		public static function scriptC($calling_time, $params)
		{
		    return $calling_time.' | '.$params['soldiers'].' Soldaten greifen das Dorf '.$params['target_name'].' an.';
		}
		  
		public static function scriptD($calling_time, $params)
		{
			return $calling_time.' | '.'Bauauftrag abgeschlossen. '.$params['building_name'].' wurde auf Stufe '.$params['new_level'].' ausgebaut.';
		}
	}
	
?>