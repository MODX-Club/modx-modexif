<?php
$events = array();

$event_name = 'On'.PKG_NAME_UPPER.'MetaTagAdd';
$event = $modx->newObject('modEvent', array(
  'service'   => 1,
  'groupname' => PKG_NAME,
));
$event->set('name', "{$event_name}");
$events[] = $event;

unset($event, $event_name);

return $events;
