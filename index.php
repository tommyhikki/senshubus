<?php
date_default_timezone_set('Asia/Tokyo');
$time = date("H:i:s", time());
$day = date("N", time());
if($day >= 1 && $day <= 5) {
  $day = 1;
}else {
  $day = 6;
}
try {
	$dbh = new PDO('mysql:host=localhost;dbname=Jikokuhyo', 'root', 'root');
  $sql = 'select * from times where time > cast(' . '"' . $time . '"' . 'as time) and day = '. $day . ' order by time asc limit 1';
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	foreach($stmt as $row) {
    $leaveTime = preg_replace('/:00$/', '', $row['time']);
    $timeLimit = intval((strtotime($row['time']) - strtotime($time)) / 60);
	}
} catch (Exception $e) {
	print "エラー!: " . $e->getMessage() . "<br/>";
	die();
}
?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
<meta name="description" content="専修大学のバスの時刻表">
<meta name="keyword" content="専修大学,時刻表,バス">
<title>重要キーワードを入れてください。</title>
<meta name="author" content="">
<meta name="keywords" content="">
<meta name="description" content="">
<link rel="stylesheet" type="text/css" href="css/common.css" media="screen">
<link rel="shortcut icon" href="icon URL.ico">
<link href="css/bootstrap-timepicker.css" type="text/css" rel="stylesheet">
<!-- jQuery -->
<script type="text/javascript" src="jquery-1.2.6.js"></script>

<!-- ui tabs.js -->
<script type="text/javascript" src="ui.core.js"></script>
<script type="text/javascript" src="ui.tabs.js"></script>
<link href="css/ui.tabs.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	$(function() {
		$('#ui-tab > ul').tabs();
	});
</script>
<script type="text/javascript">
	$(function() {
    $("#daytab li").click(function() {
        var num = $("#daytab li").index(this);
        $(".content_wrap").addClass('disnon');
        $(".content_wrap").eq(num).removeClass('disnon');
        $("#daytab li").removeClass('select');
        $(this).addClass('select')
    });
});
</script>
<script src="bootstrap.min.js" type="text/javascript"></script>
<script src="bootstrap-timepicker.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    $('#search_id').datepicker({
        template: 'modal',
    });
});
</script>
</head>
<body>

<!-- ▼ヘッダー▼ -->
<header>
  <hgroup id="top">
    <h1>専修大学バス時刻案内</h1>
    <p id="h_image"> <img src="" alt=""> </p>
  </hgroup>
</header>
<!-- ▲ヘッダー▲ -->

<!-- ▼コンテンツ1▼ -->
<div id="ui-tab">
  <div id="fragment-1">
    <article>　
      <!-- ▼コンテンツ2▼ -->
      <section class="going"> <img src="img/busgoing.png" alt="">
        <p>専修大学120年記念館前 行</p>
      </section>
      <!-- ▲コンテンツ2▲ -->
      <section class="nowtime">
        <h2>つぎにでるバス　あと<?php echo $timeLimit; ?>分ででるよ</h2>
        <p><?php echo $leaveTime; ?></p>
      </section>
      <!-- ▲コンテンツ1▲ -->

      <!-- ▼コンテンツ3▼ -->
      <section class="money">
        <div id="moneyleft">
          <h2>料金</h2>
          <p>大人<strong>200</strong>円</p><p>（中学生以上）</p>
        </div>
        <div id="moneyright"><span>専修大学生は学生生活課の自販機でバスの6枚つづり券を買うと片道100円になります。</span></div>
      </section>
       <section class="money">
        <div id="moneyleft">
          <h2>料金</h2>
          <p>子供<strong>100</strong>円</p><p>（小学生以下）</p>
        </div>
        <div id="moneyright"><span>※深夜料金大人４００円<br>※深夜料金子供２００円</span></div>
      </section>
      <!-- ▲コンテンツ3▲ -->
      <section class="busstop">
        <h2>バス経由詳細</h2>
         <img src="img/busstop.png" alt="">
       </section>
    </article>
  </div>

  <div id="fragment-2">
  <article>　
  <section class="search">
  <form action="" method="">
<fieldset>
時刻入力：
<input type="text" id="search_id" placeholder="キーワードを入力"><br>
</fieldset>
</form>
  </section>
  <section class="timebox">
		<div class="button-holder">
			<input type="radio" id="radio-1-1" name="radio-1-set" class="regular-radio" checked /><label for="radio-1-1">現在時刻</label>
			<input type="radio" id="radio-1-2" name="radio-1-set" class="regular-radio" /><label for="radio-1-2">到着時刻</label>
			<input type="radio" id="radio-1-3" name="radio-1-set" class="regular-radio" /><label for="radio-1-3">出発時刻</label>
			<input type="radio" id="radio-1-4" name="radio-1-set" class="regular-radio" /><label for="radio-1-4">指定時刻</label>
		</div>
   </section>
<div id="btn_search">
<p><button type="submit">検索する</button></p>
</div>
<section class="result">
 <form action="" method="">
<fieldset>
時刻結果：
<input type="text" id="result_id" placeholder="時刻表示"><br>
</fieldset>
</form>
</section>
    </article>　
  </div>


  <div id="fragment-3">
   <ul id="daytab">
    <li class="select">平日のバス時間</li>
    <li>土曜のバス時間</li>
    <li>日曜のバス時間</li>
  </ul>
  <div class="content_wrap">
    <table class="workday">
      <tbody>
        <tr>
          <th width="20%">時間</th>
          <th width="80%">平日</th>
        </tr>
        <tr>
          <td>6時</td>
          <td>06／29／41／53 </td>
        </tr>
        <tr>
          <td>7時</td>
          <td>05／17／29／41／53 </td>
        </tr>
        <tr>
          <td>8時</td>
          <td>03／13／22／30／35／40／46／55</td>
        </tr>
        <tr>
          <td>9時</td>
          <td>05／15／25／35／45／55 </td>
        </tr>
        <tr>
          <td>10時</td>
          <td>05／14／23／30／40／50</td>
        </tr>
        <tr>
          <td>11時</td>
          <td>00／10／20／30／40／50
</td>
        </tr>
        <tr>
          <td>12時</td>
          <td>00／10／20／30／40／50
</td>
        </tr>
        <tr>
          <td>13時</td>
          <td>00／20／40
</td>
        </tr>
        <tr>
          <td>14時</td>
          <td>00／20／40</td>
        </tr>
        <tr>
          <td>15時</td>
          <td>00／20／40</td>
        </tr>
        <tr>
          <td>16時</td>
          <td>00／20／40</td>
        </tr>
        <tr>
          <td>17時</td>
          <td>00／20／40
</td>
        </tr>
        <tr>
          <td>18時</td>
          <td>00／30</td>
        </tr>
        <tr>
          <td>19時</td>
          <td>00／30</td>
        </tr>
        <tr>
          <td>20時</td>
          <td>05／42／56
</td>
        </tr>
        <tr>
          <td>21時</td>
          <td>15／30
</td>
        </tr>
        <tr>
          <td>22時</td>
          <td>00／20／33
</td>
        </tr>
        <tr>
          <td>23時</td>
          <td>03深／33深
</td>
        </tr>
        <tr>
          <td>24時</td>
          <td>03深／33深
</td>
        </tr>
        <tr>
          <td>25時</td>
          <td></td>
        </tr>
      </tbody>
    </table>
        </div>
     <div class="content_wrap disnon">
     <table class="saturday">
      <tbody>
        <tr>
          <th width="20%">時間</th>
          <th width="80%">土曜日</th>
        </tr>
        <tr>
          <td>6時</td>
          <td>10／50</td>
        </tr>
        <tr>
          <td>7時</td>
          <td>10／30／50</td>
        </tr>
        <tr>
          <td>8時</td>
          <td>10／30／50</td>
        </tr>
        <tr>
          <td>9時</td>
          <td>10／30／50 </td>
        </tr>
        <tr>
          <td>10時</td>
          <td>20／50</td>
        </tr>
        <tr>
          <td>11時</td>
          <td>20／50
</td>
        </tr>
        <tr>
          <td>12時</td>
          <td>20／50
</td>
        </tr>
        <tr>
          <td>13時</td>
          <td>20／50
</td>
        </tr>
        <tr>
          <td>14時</td>
          <td>20／50</td>
        </tr>
        <tr>
          <td>15時</td>
          <td>20／50</td>
        </tr>
        <tr>
          <td>16時</td>
          <td>10／30／50</td>
        </tr>
        <tr>
          <td>17時</td>
          <td>10／30／50
</td>
        </tr>
        <tr>
          <td>18時</td>
          <td>10／30／50</td>
        </tr>
        <tr>
          <td>19時</td>
          <td>10／40</td>
        </tr>
        <tr>
          <td>20時</td>
          <td>10／40
</td>
        </tr>
        <tr>
          <td>21時</td>
          <td>10／40
</td>
        </tr>
        <tr>
          <td>22時</td>
          <td>16／47
</td>
        </tr>
        <tr>
          <td>23時</td>
          <td>17深／50深
</td>
        </tr>
        <tr>
          <td>24時</td>
          <td>
</td>
        </tr>
        <tr>
          <td>25時</td>
          <td></td>
        </tr>
      </tbody>
    </table>
    </div>
<div class="content_wrap disnon">
 <table class="sunday">
      <tbody>
        <tr>
          <th width="20%">時間</th>
          <th width="80%">日曜日</th>
        </tr>
        <tr>
          <td>6時</td>
          <td>10／50</td>
        </tr>
        <tr>
          <td>7時</td>
          <td>10／30／50</td>
        </tr>
        <tr>
          <td>8時</td>
          <td>10／30／50</td>
        </tr>
        <tr>
          <td>9時</td>
          <td>10／30／50 </td>
        </tr>
        <tr>
          <td>10時</td>
          <td>20／50</td>
        </tr>
        <tr>
          <td>11時</td>
          <td>20／50
</td>
        </tr>
        <tr>
          <td>12時</td>
          <td>20／50
</td>
        </tr>
        <tr>
          <td>13時</td>
          <td>20／50
</td>
        </tr>
        <tr>
          <td>14時</td>
          <td>20／50</td>
        </tr>
        <tr>
          <td>15時</td>
          <td>20／50</td>
        </tr>
        <tr>
          <td>16時</td>
          <td>10／30／50</td>
        </tr>
        <tr>
          <td>17時</td>
          <td>10／30／50
</td>
        </tr>
        <tr>
          <td>18時</td>
          <td>10／30／50</td>
        </tr>
        <tr>
          <td>19時</td>
          <td>10／40</td>
        </tr>
        <tr>
          <td>20時</td>
          <td>10／40
</td>
        </tr>
        <tr>
          <td>21時</td>
          <td>10／40
</td>
        </tr>
        <tr>
          <td>22時</td>
          <td>16／47
</td>
        </tr>
        <tr>
          <td>23時</td>
          <td>17深／50深
</td>
        </tr>
        <tr>
          <td>24時</td>
          <td>
</td>
        </tr>
        <tr>
          <td>25時</td>
          <td></td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>

  <!-- ▼フッター▼ -->
  <ul class="tabs">
    <li><a href="#fragment-1"><span><img src="img/busnow.png" alt=""></span></a></li>
    <li><a href="#fragment-2"><span><img src="img/bussearch.png" alt=""></span></a></li>
    <li><a href="#fragment-3"><span><img src="img/bushyou.png" alt=""></span></a></li>
  </ul>
</div>
<!-- ▲フッター▲ -->

</body>
</html>
