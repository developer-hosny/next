<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta>
	<title></title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    
    <style type="text/css">
    body{
        font-size: 50px;
    }
    </style>
</head>
<body>

<div class="countdown">
	
</div>



<script type="text/javascript">
<?php

require 'vendor/autoload.php';

use Carbon\Carbon;

$url = 'http://timesprayer.com/prayer-times-in-sharijah.html';

$htmlInput = file_get_contents($url);


$next_prayer_time = null;
if(strpos($htmlInput, "countdown_clock(",1700)>0){

    $next_prayer_time = str_replace(['countdown_clock(',')',';'],'', substr($htmlInput, strpos($htmlInput, 'countdown_clock(',1700),35));

}
$htmlInput = mb_convert_encoding($htmlInput, 'HTML-ENTITIES', "UTF-8");
$dom = new DOMDocument;
@$dom->loadHTML($htmlInput);
$x = new DOMXPath($dom);
$entries = $x->query('//td[@class="next_prayer"]');

$_countdown = $x->query('//div[@class="countdown"]');
$next_prayer_time_12 = $entries[0]->nodeValue;
$next_prayer_name = $entries[0]->getAttribute('data-th');


    $city_date_time = 
    Carbon::now('Asia/Dubai')->year .','.Carbon::now('Asia/Dubai')->month.','.
    Carbon::now('Asia/Dubai')->day .','.Carbon::now('Asia/Dubai')->hour.','.Carbon::now('Asia/Dubai')->minute.','.'0';
    
?>

var next_prayer_name = '<?php echo trim($next_prayer_name); ?>';

function pad(n) {
    return (n < 10) ? ("0" + n) : n;
}

function countdown_clock(year, month, day, hour, minute, format)

         {

         Today = new Date();

         Todays_Year = Today.getFullYear() - 2000;

         Todays_Month = Today.getMonth() + 1;


         Server_Date = (new Date(<?php echo $city_date_time; ?>)).getTime();//توقيت المدينة يتم وضعه هنا

         Todays_Date = (new Date(Todays_Year, Todays_Month, Today.getDate(), Today.getHours(), Today.getMinutes(), Today.getSeconds())).getTime();

         minute = minute + 4; //fix sharjah time
         countdown(year, month, day, hour, minute, (Todays_Date - Server_Date));

         }



function countdown(year, month, day, hour, minute, time_difference, format)

         {

         Today = new Date();

         Todays_Year = Today.getYear() - 2000;

         Todays_Month = Today.getMonth() + 1;



         Todays_Date = (new Date(Todays_Year, Todays_Month, Today.getDate(), Today.getHours(), Today.getMinutes(), Today.getSeconds())).getTime();

         Target_Date = (new Date(year, month, day, hour, minute, 00)).getTime();



         Time_Left = Math.round((Target_Date - Todays_Date + time_difference) / 1000);



         if(Time_Left < 0)

            Time_Left = 0;



                    days = Math.floor(Time_Left / (60 * 60 * 24));

                    Time_Left %= (60 * 60 * 24);

                    hours = Math.floor(Time_Left / (60 * 60));

                    Time_Left %= (60 * 60);

                    minutes = Math.floor(Time_Left / 60);

                    Time_Left %= 60;

                    seconds = Time_Left;




                    
				if(hours<=0&&minutes<=0&&seconds<=1){

                    // $("#countdown").html("00:00:00");
                    if($("#eqama_prayer").is(":visible")){
                         $("#eqama_prayer").html(' حان الأن موعد إقامة صلاة ' + next_prayer_name);
                         setTimeout("location.reload(true);",300000);
                         return;
                    }

                    $("#next_prayer").hide();
                    $("#countdown").hide();
                    $("#eqama_prayer").show();
                    // eqama();
            setTimeout('countdown(' + year + ',' + month + ',' + day + ',' + hour + ',' + (minute + getEqamaTime()) + ',' +

                     time_difference + ');', 1000);

                    // $('.playsound').html('<object width="120" height="35" data="swf/normal.swf"></object>');
                    // setTimeout("location.reload(true);",((getEqamaTime() * 60 * 1000) + 300000 ));
                 					return

					} else {



                    var timeleft = pad(hours) + ":" + pad(minutes) + ":" + pad(seconds);


                    // $(".countdown").html(timeleft);

                        $("#countdown").html(timeleft);
                        $("#eqama_prayer").html( 'إقامة الصلاة بعد ' + timeleft);
					}



         setTimeout('countdown(' + year + ',' + month + ',' + day + ',' + hour + ',' + minute + ',' +

                     time_difference + ');', 1000);

			}
            
            // var eqama_prayer = 20; //20 minutes by seconds
            // var eqama_Interval;
            // function eqama(){
            //    var eqama_prayer = getEqamaTime();
               
            //     var eqama_Interval = setInterval(function(){
            //         if(eqama_prayer <=1 ){                       
            //              $("#eqama_prayer").html('حان الأن موعد إقامة الصلاة');
                         
            //              // setTimeout(function(){
            //              //    location.reload(true);
            //              //    },120000);

            //              clearInterval(eqama_Interval);

            //              return;
            //         }
            //         eqama_prayer--;
            //         $("#eqama_prayer").html( 'إقامة الصلاة بعد ' + eqama_prayer + ' دقيقة');
            //     },1000);
            // }

            function getEqamaTime(){
                if(next_prayer_name == 'المغرب'){
                    return 5;
                }

                return 20;
            }

 countdown_clock(<?php echo trim($next_prayer_time); ?>); //وقت الصلاة القادمة
 // countdown_clock(2015,12,12,01,54,01);
</script> 


    <rss version='2.0'>
    
<!--     <item>   
    <title>next_prayer_name</title>
    <description><?php //echo $next_prayer_name ?></description>   
    </item> -->

    <item>
    <title>next_prayer_time</title>
    <description id="next_prayer"><?php echo $next_prayer_name . ' ' . trim($next_prayer_time_12) ?></description>
    </item>

    <item>
    <title>countdown</title>
    <description id="countdown"></description>
    </item>

    <item>
    <title>eqama</title>
    <description hidden id="eqama_prayer"></description>
    </item>


    </channel>
    </rss> 
</body>
</html>


