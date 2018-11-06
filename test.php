<?php
require_once 'config.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perpage = 10;
$start = ($page > 1) ? ($page * $perpage) - $perpage : 0;
echo $page."<br>";
echo $start."<br>";
//query
$query = $conn->prepare("SELECT  SQL_CALC_FOUND_ROWS * FROM books limit {$start},{$perpage} ");
$query->execute();

$books = $query->fetchAll(PDO::FETCH_ASSOC);

//pages
$total = $conn->prepare("SELECT FOUND_ROWS() as total");
$total->execute();
$total = $total->fetch()['total'];
$pages =  ceil($total / $perpage);
echo $pages;
$img_link = 'https://dzadzb82azfku.cloudfront.net/library/com.snapplify.snapplifylibrary.ecoschool/com.snapplify.snapplifylibrary.ecoschool/asset/image/';
$img_size = '.jpg?w=100&h=150';

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Books</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="css/searchresults.css">
  </head>
  <body>
    <section class="container some_about"><br>
      <div class="container">
 	<div class="row">
 		<h4>Search results for ""</h4>
     <p><h6>You are viewing results from <?php echo $start+1;?> to <?php echo $start+$perpage;?> of <?php echo $total;?></h6></p>
 	</div>
     <hr>
    <?php foreach ($books as $book):
      $img_actual = $img_link.$book['isbn'].$img_size;
      file_get_contents($img_actual);
      if ($http_response_header[0] === 'HTTP/1.1 404 Not Found') {
        # code...
        $img_actual = "img/placeholder.png";
      }
      ?>
      <div class="col-md-4">
    <div class="well well-sm">
        <div class="media">
            <a class="thumbnail pull-left" href="https://ecoschool.snapplify.com/product/<?php echo $book['isbn'];?>" data-toggle="tooltip" data-placement="top" title="click here to buy!" target="_blank" style="width:100px;height:150px;margin-right:10px;">
                <img class="media-object" src="<?php echo $img_actual; ?>">
            </a>
            <div class="media-body">
                <small><h4 class="media-heading"><?php echo $book['title'];?></h4></small>
                <p><?php echo $book['price'];?></p>
                <p>
                    <?php echo $book['bookid']; ?><a href="https://ecoschool.snapplify.com/product/<?php echo $book['isbn'];?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-money"></span> Buy Now</a>
                </p>
            </div>
        </div>
    </div>
</div>
  <?php endforeach; ?>
</div>
<div class="">
  <?php if ($page <= $pages): ?>
    <a href="?page=<?php echo $page-1;?>">previous</a>
    <a href="?page=<?php echo $page+1;?>">next</a>
  <?php endif; ?>
</div>
<div class="space-30"></div>
</section>
  </body>
</html>