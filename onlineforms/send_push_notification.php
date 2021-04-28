<?php
ini_set('display_errors',1);

// ignore_user_abort(true);
// set_time_limit(0);
// $data = file_get_contents('filename.txt');
// while (!file_exists('stop.txt')) {
//     // Add 1 to $data
//     $data = $data+1;
//     // Update file
//     file_put_contents('filename.txt', $data);

//     // Wait 10 seconds
//     sleep(10);
// }

require __DIR__ . '/vendor/autoload.php';
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;


$filepath = dirname( __FILE__ ).'/push_subscription.json';


if(file_exists($filepath)){
    $inp = file_get_contents($filepath);
    $arr_data = json_decode($inp,true);


    $auth = array(
        'VAPID' => array(
            'subject' => 'mailto:web2.charlyn@gmail.com',
            'publicKey' => file_get_contents(__DIR__ . '/keys/public_key.txt'), // don't forget that your public key also lives in app.js
            'privateKey' => file_get_contents(__DIR__ . '/keys/private_key.txt'), 
        ),
    );

    $webPush = new WebPush($auth);

    $content  	= array(
    	'title' => 'Online Form Notification',
        'msg'   => 'You have a new message!',
        'url'   => (explode("wp-content",$_SERVER['HTTP_REFERER'],2))[0].'onlineforms/index.php',
    	'icon'	=> 'images/pwa/icon.png',
    	'badge'	=> 'images/pwa/icon-192x192.png'
    );

    $payload = json_encode($content);

    foreach ($arr_data as $notification) {
        $webPush->sendOneNotification(
            Subscription::create($notification),
            $payload
        );
    }

    foreach ($webPush->flush() as $report){
        $endpoint = $report->getRequest()->getUri()->__toString();

        if ($report->isSuccess()) {
            echo "[v] Message sent successfully for subscription {$endpoint}.";
        } else {
            echo "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
        }
    }

} //end if file_exists


// $report = $webPush->sendOneNotification(
//     $subscription,
//    	$payload
// );

// // handle eventual errors here, and remove the subscription from your server if it is expired
// $endpoint = $report->getRequest()->getUri()->__toString();

// if ($report->isSuccess()) {
//     echo "[v] Message sent successfully for subscription {$endpoint}.";
// } else {
//     echo "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
// }
