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
        <div style = "color: #546E7A; width: 530px;"><a href = "https://twitter.com/'.$data["user"]["screen_name"].'">
            <div class="name" style="font-size: 23pt; font-weight: 300;">' . $data["user"]["name"] . '</div>
            <div class="scr_name" style="color: #90A4AE;">@' . $data["user"]["screen_name"] . '</div></a>
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
    <link rel="shortcut icon" href="srchfv.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="design.css">
    <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 hdr no-pad">
            <div class="logo">#tag<span style="font-weight: 300">Search</span></div>

        </div>
        <div class="col-md-8 no-pad">
            <div class="sbxcont">
                <form action="">
                    <input type="text" name="query" placeholder="Search for #anything #you #like....">
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 no-pad" style="border-right:1px solid #b9b9b9;">
            <footer>
                Build 2016 | Shubhesh Dwivedi (<a href='https://twitter.com/cafeshoes'
                                                  style='text-decoration:none; color:#2196f3;'>@cafeshoes</a>)
            </footer>
        </div>
        <div class="col-md-8 no-pad">
            <div class="result">
                <div class="rhdr"><h2>Results</h2> <?php echo $query ?></div>
                <hr>
                <?php echo $response; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>