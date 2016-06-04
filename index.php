<!DOCTYPE html>
<html lang="en">
<head>
  <title>Youtube Downloader</title>
    <link rel="icon" href="suramshivareddy.com/photo.png" type="image/gif">
    <meta name="author" content="Suram ShivaReddy" />
    <meta name="keywords"  content="ShivaReddy, Suram ShivaReddy, Suram Shiva, Shiva R'dy" />
<meta name="description" content="I'm Suram ShivaReddy a Webdeveloper from India (Hyderabad). If you are looking for a
good looking Responsive website, I can help you with it">

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/951d746165.js"></script>
  <style>
  @media only screen and (max-width: 770px) {
  #headerform input{
  margin-top:-20px;
  }
  #headerform button{
  display:none;
  }
  }
#related:hover{
cursor:pointer;
}
#searchdiv:hover{
cursor:pointer;
}
  </style>
</head>
	<script>
		function myfun(a){
		 window.location.href = "youtubedownloader.php?v=" +a;
		}
		</script>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
   <p style="text-align:center;color:black;margin-top:-5px;"class="lead"> Youtube Downloader</p>
      </a>
    </div>
	<form  id="headerform" method="post" action="youtubedownloader.php" style="border:none;border-shadow:none;" class="navbar-form navbar-right" role="search">
  <div class="form-group">
    <input type="text" autofocus name="query"class="form-control" placeholder="Search or Youtube Link">
  </div>
  <button type="submit"class="btn btn-default">Submit</button>
</form> 
  </div>
</nav>

<div class="container">
<?php
if(isset($_GET['v'])){
download($_GET['v']); 
}
if(isset($_POST['query'])){
$query=$_POST['query'];
if(stripos($query,"youtu")){
download($query);
}
else{
search($query);
}
}

function download($query){
if(preg_match('/[\w-]{10,12}/',$query,$match)){
$vid=$match['0'];
$data = file_get_contents("https://www.youtube.com/get_video_info?video_id=$vid");
	parse_str($data);

	if(stripos($data,"url_encoded_fmt_stream_map")){
		$arr=explode(",",$url_encoded_fmt_stream_map);
$stats=file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=".$vid."&part=statistics&key=AIzaSyD-uePXae6iWeuxmwjQHZqt_XFDr4E_waU");
	$searchResponse = json_decode($stats,true);
	echo "<style>body{background-color:#efefef;}.container .col-sm-4{background-color:white;}</style>";
echo "<style>.jumbotron{display:none;}</style>";
echo '<div class="row" style="margin-bottom:5px;"><div class="col-sm-8" style="margin-bottom:5px;">
<div align="center" class="embed-responsive embed-responsive-16by9">
 <iframe width="560" height="315" src="https://www.youtube.com/embed/'.$vid.'" frameborder="0" allowfullscreen></iframe>
</div>

</div>';
echo '<div id="dbox" class="col-sm-4" style="border:1px solid grey;border-radius:3px;"><h2 align="center"style="border-bottom:1px solid grey; ">Download</h2>
<h4>'.$title.'</h4>
<p>Views= '.$view_count.' | Likes= '.$searchResponse['items']['0']['statistics']['likeCount'].' | Dislikes= '.$searchResponse['items']['0']['statistics']['dislikeCount'].'</p>
<p class="lead" style="border-bottom:1px solid grey" align="center">List of Downloadable Formats</p>';
	foreach ($arr as $item) {
parse_str($item);
$a=explode(";",$type);
$typ=$a['0'];
echo "<a style='border-bottom:none;margin-bottom:-10px;' href='$url?title=$title'><button style='width:100%;margin-bottom:10px;'class='btn btn-danger btn-sm  '>Quality= $quality  - <small>  $typ</small> </button></a></br>";
	}	
?>

</div></div>

<?php
echo '<div class="row"><div class="col-xs-12" style="border:1px solid grey;padding-top:5px;border-radius:3px;background-color:white;">';
echo '<div style="margin:0 auto;">';
$query=clean($title);
$response = file_get_contents("https://www.googleapis.com/youtube/v3/search?part=snippet&q={$query}&type=video&key=AIzaSyD-uePXae6iWeuxmwjQHZqt_XFDr4E_waU&maxResults=12");

$searchResponse = json_decode($response,true);
foreach ($searchResponse['items'] as $searchResult) {?>
<div id='related' style='float:left;' onclick="myfun('<?php echo $searchResult['id']['videoId']; ?>');">
<?php
echo'<img class="img-responsive" style="padding:10px;max-width:250px;" 
src="'.$searchResult['snippet']['thumbnails']['medium']['url'].'" alt="Youtube Video"><p style="margin-top:-10px;margin-left:10px;max-width:227px;height:50px;margin-bottom:35px;">'.$searchResult['snippet']['title'].'</p>';
echo"</div>";

}
echo '</div></div></div>';
}
else {
echo "<style>.jumbotron{display:none;}</style>";
echo "<style>footer{position:fixed;bottom:0;}</style>";
echo "<h2>This video can't be Downloaded..Try another Video.</h2>";
}


}
else {search($query);}
}

function search($query){
echo "<style>.jumbotron{display:none;}</style>";
echo "<style>body{background-color:#efefef;}.container .col-sm-10{background-color:white;}</style>";
	
	$query=preg_replace("/ /","+",$query);
	
	$response = file_get_contents("https://www.googleapis.com/youtube/v3/search?part=snippet&q={$query}&type=video&key=AIzaSyD-uePXae6iWeuxmwjQHZqt_XFDr4E_waU&maxResults=30");
	
	$searchResponse = json_decode($response,true);

	echo '<div class="row"><div class="col-sm-1"></div><div class="col-sm-10">';
		foreach ($searchResponse['items'] as $searchResult) {?>
	
		<div id="searchdiv" onclick="myfun('<?php echo $searchResult['id']['videoId']; ?>');">
		<?php
		echo'<h4 style="color:#167ac6;clear:both;"><img class="img-responsive" style="float:left;clear:both; padding-bottom:20px;padding-right:10px;max-width:250px;" src="'.$searchResult['snippet']['thumbnails']['medium']['url'].'" alt="Youtube Video"> '.$searchResult['snippet']['title'].'
		</h4><p>'.$searchResult['snippet']['channelTitle'].'</p><small>'.$searchResult['snippet']['description'].'</small></div>';
		}

	?></div><div class="col-sm-1"></div></div><?php
}
function clean($string) {
   $string = str_replace(' ', '+', $string); 

   return preg_replace('/[#|&!@$%^*()]/', '', $string); 
}
?>

  <div class="jumbotron">
    <h1 style=" text-align:center;"><i style="color:#d9534f;"class="fa  fa-2x fa-youtube" aria-hidden="true"></i> Downloader</h1>
    <p align="center" class="lead">Get Youtube videos to your Devices !</p> <br>
		<form  role="search" method="post" action="youtubedownloader.php">
  <div class="form-group">
    <input type="text"  class="form-control" name="query"placeholder="Search or Paste a Youtube Link">
  </div>
  <button type="submit"class="btn btn-danger btn-block">Submit</button>
</form>
  </div>

<footer style=" height:30px; margin-top:10px;background-color:#F8F8F8;width: 100%;">
<p style="padding-top:5px;" align="center">Production - <a href="https://www.facebook.com/shivareddy0">Shiva R'dy</a> </p>
</footer>
</div>

</body>

</html>
