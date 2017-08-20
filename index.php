<?php

require_once ('TwitterAPIExchange.php');
$settings = array(
    'oauth_access_token' => "1317626606-gDCZr3lKquP71Dx6x9R2ZCIep2KmnNDvu2KLAqj",
    'oauth_access_token_secret' => "IjAEhd8t0nDwgOI7CnzMoDx5HUxXCjMA6KvxGgJAWoGbL",
    'consumer_key' => "r7kQW9LMUcPplKpIACB2l5LY5",
    'consumer_secret' => "cfsd8vWVNWosSijWiTegLT7RWB4J9aRmHEaXthJpqlFrLx9v1v"
);

$url = 'https://api.twitter.com/1.1/search/tweets.json';
$requestMethod = 'GET';
$query = $response = '';
if(isset($_GET['query'])) {
    $query = $_GET['query'];
    if(strchr($query,'#')==false)
        $query = '#'.$query;
    $getfield = '?q=%23' . urlencode($query) . '&result_type=recent';
    $twitter = new TwitterAPIExchange($settings);
    $twi_json = $twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest();
    $twiarr = json_decode($twi_json, true);
    $response = '';
    foreach ($twiarr['statuses'] as $data)
        $response = $response . '<div class="twtBx">
        <div class="propic" style="background: url(' . $data["user"]["profile_image_url"] . ');background-size: cover;">
        </div>
        <div style = "color: #546E7A; width: 530px;">
            <div class="name" style="font-size: 23pt; font-weight: 300;">' . $data["user"]["name"] . '</div>
            <div class="scr_name" style="color: #90A4AE;">@' . $data["user"]["screen_name"] . '</div>
            <div class="tweet">
                ' . $data["text"] . '
            </div>
        </div>
    </div>';
    echo "
            <style>
               .result {
               display: block;
               }
            </style>
          ";
    }
    else {
        echo "
            <style>
               .result {
               display: none;;
               }
            </style>
          ";
    }

?>

<html>
<head>
    <title>#tagSearch</title>
    <link rel="stylesheet" href="design.css">
    <link rel="shortcut icon" href="srchfv.png">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">#tag<span style="font-weight: 300">Search</span></div>
        </div>
        <div class="sbxcont">
            <div class="outercover">
                <form action="" style="height: 23px;">
                    <input type="text" class="sbox" name="query" placeholder="Search for #anything #you #like...." >
                </form>
            </div>
        </div>
        <div class="result">
            <div class="rhdr">Results for <?php echo $query ?> | #tag<span style="font-weight: 300">Search</span> </div>
            <?php echo $response; ?>
            <div class="end">-finish-</div>
        </div>
        <div class="footer">
            Build 2017 | Shubhesh Dwivedi (@cafeshoes)
        </div>
    </div>
</body>
</html>

