<?php
require __DIR__ . '/../vendor/autoload.php';

// If account is public you can query Instagram without auth

$user_name = "";
if(isset($_GET["u"]))
{
  $user_name = $_GET["u"];
}

$instagram = new \InstagramScraper\Instagram();
$medias = $instagram->getMedias($user_name, 25);

$scrapedData = array();
foreach ($medias as $media) {
	$account = $media->getOwner();
	$data = array(
				'id' => $media->getId(),
				'url' => $media->getLink(),
				'title' => $media->getCaption(),
				'type' => $media->getType(),
				'nsfw' => '0',
				'content' => $media->getImageHighResolutionUrl(),
				'acc_ur' => $account->getUsername(),
				'acc_name' => $account->getFullName(),
				'acc_pic' => $account->getProfilePicUrl()
			);
	array_push($scrapedData, $data);
}

echo (json_encode($scrapedData));

// Let's look at $media
/*$media = $medias[0];

echo "Media info:\n";
echo "Id: {$media->getId()}\n";
echo "Shotrcode: {$media->getShortCode()}\n";
echo "Created at: {$media->getCreatedTime()}\n";
echo "Caption: {$media->getCaption()}\n";
echo "Number of comments: {$media->getCommentsCount()}";
echo "Number of likes: {$media->getLikesCount()}";
echo "Get link: {$media->getLink()}";
echo "High resolution image: {$media->getImageHighResolutionUrl()}";
echo "Media type (video or image): {$media->getType()}";
$account = $media->getOwner();
echo "Account info:\n";
echo "Id: {$account->getId()}\n";
echo "Username: {$account->getUsername()}\n";
echo "Full name: {$account->getFullName()}\n";
echo "Profile pic url: {$account->getProfilePicUrl()}\n";*/


// If account private you should be subscribed and after auth it will be available
$instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', 'path/to/cache/folder');
$instagram->login();
$medias = $instagram->getMedias('private_account', 100);
