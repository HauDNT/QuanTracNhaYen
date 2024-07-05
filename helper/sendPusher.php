<?php
function sendPusherEvent($channel, $event, $data)
{
  $options = array(
    'cluster' => 'ap1',
    'useTLS' => true
  );
  $pusher = new Pusher\Pusher(
    'ce8cd0fde22ea5ff4a20',
    '8ecc88ce2483b84b5e57',
    '1811035',
    $options
  );
  $pusher->trigger($channel, $event, $data);
}
