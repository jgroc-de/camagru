<?php

function deletePic($c)
{
	$response['code'] = 404;
	$response['flash'] = "Something went wrong. Plz contact us!";
    if (isset($_POST['url']))
    {
		$response['url'] = $_POST['url'];
        $picManager = $c->picture;
        $pic = $picManager->getPicByUrl($_POST['url']);
        if ($pic && $_SESSION['id'] === $pic['id_author'])
        {
            $picManager->deletePic($pic['id'], $pic['id_author']);
            unlink($_POST['url']); 
			$response['code'] = 200;
			$response['flash'] = "Picture successfully deleted!";
        }
	}
	return $response;
} 
