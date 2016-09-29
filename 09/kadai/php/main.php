<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>お気に入りの場所</title>
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="https://cdn.mlkcca.com/v0.6.0/milkcocoa.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAocaFmhTlV3Kbf-1ylWNjmzwoPnUyhOEA&callback=initMap" async defer></script><!-- Map -->
    </head>
    <body>
        <header>
            <p>こんにちは！<?= $_SESSION["name"] ?>さん！</p>
            <nav>
            <a href="logout.php">ログアウト</a>
            <a href="user_detail.php">アカウント情報</a>
            </nav>
            <h1>お気に入り・行きたい場所のリスト(^^)</h1>
        </header>   
        <div class="main">
        <!-- Map -->
        <div class="left">
            <div class="mapArea">
            <div id="map"></div></div>
<!--            <div class="manageBox"></div>-->
            <div class="registBox">
                <div class="button"><input id="btnCurrent" type="button" value="現在地を設定する"></div>
                <p>title</p><input id="title" type="text" size="40" maxlength="40"><br>
                <p>memo</p><textarea id="memo" rows="3" cols="38">(ここにmemoを入力してください)</textarea><br>
                <canvas id="imgCan" width="150px" height="150px"></canvas>
            	<input type="file">
                <div class="button"><input id="btnRegist" type="button" value="登録"></div>
            </div>
            
        </div>
        <div class="listArea">
            <ul id="board"></ul>
        </div></div>
        <script>
            //一覧を保存しておく変数
            var cafeAllList = [];
            //画像保存用変数
            var cnt = $("#imgCan")[0].getContext("2d");
            //画像保存フラグ
            var isSaveImg = false;
                
            //データストアを作成（データを送受信するために必要）
            var milkcocoa = new MilkCocoa('[milkcocoaのidを入れてください].mlkcca.com');
            //データベースストア：オブジェクト生成
            var dsCafe = milkcocoa.dataStore("cafeList"); //自分でつけたアプリ名指定
            //milkcocoa内に保存されているリストを初期表示する
            showList();
            
            
            //Main:位置情報を取得する処理 //getCurrentPosition :or: watchPosition
            function initMap(){
                mapsStart();
            }
            
            var map; //mapオブジェクト保管用

            //1．初期表示の処理
            function mapsStart(position) {
                try {
                    var lat = 35.681143;   //緯度を代入する変数
                    var lon = 139.766392;  //経度を代入する変数
                    //div#mapを「GoogleMap」化
                    map = new google.maps.Map(document.getElementById('map'), {
                        center: {lat: lat, lng: lon}, //緯度,経度を設定
                        zoom: 15 //Zoom値設定
                    });

                    main();
                    
                } catch (error) {
                    console.log("getGeolocation: " + error);
                }
            };

            //2． 位置情報の取得に失敗した場合の処理
            function mapsError(error) {
                var e = "";
                if (error.code == 1) { //1＝位置情報取得が許可されてない（ブラウザの設定）
                    e = "位置情報が許可されてません";
                }
                if (error.code == 2) { //2＝現在地を特定できない
                    e = "現在位置を特定できません";
                }
                if (error.code == 3) { //3＝位置情報を取得する前にタイムアウトになった場合
                    e = "位置情報を取得する前にタイムアウトになりました";
                }
                alert("エラー：" + e);
            };

            //3.位置情報取得オプション
            var set ={
                enableHighAccuracy: true, //より高精度な位置を求める
                maximumAge: 20000,        //最後の現在地情報取得が20秒以内であればその情報を再利用する設定
                timeout: 10000            //10秒以内に現在地情報を取得できなければ、処理を終了
            };
            
            //地図の読み込みが成功してから実行する
            function main(){
                //登録用マーカーの変数
                var registMarker = new google.maps.Marker({
                    map: map,
                    visible: false
                });
                
                //クリックした位置に登録用ピンを表示する,中心に設定する
                $('#map').on('click', function(){
                    google.maps.event.addListener(map, 'click', function(e){
                        registMarker.setVisible(true);
                        registMarker.setPosition(e.latLng); 
                        map.setCenter(e.latLng);
                    });
                });
                
                //現在地に登録用ピンを表示する
                $('#btnCurrent').on('click', function(){
                    navigator.geolocation.getCurrentPosition(getCurrent, mapsError, set);
                    
                });
                //現在地を取得し、中心に設定する
                function getCurrent(position){
                    //lat=緯度、lon=経度 を取得
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    registMarker.setPosition({lat: lat, lng: lng});
                    registMarker.setVisible(true);
                    map.setCenter({lat: lat, lng: lng});
                }
                
                //現在地からのルートを検索する
                function searchRoute(goal){
                    try{
                        var goalLatLng = goal;
                        var directionsService = new google.maps.DirectionsService();
                        var directionsDisplay = new google.maps.DirectionsRenderer();
                        directionsDisplay.setMap(map);
                        directionsDisplay.setPanel(document.getElementById("route2"));
                        
                        navigator.geolocation.getCurrentPosition(function(position){
                            var current = new google.maps.LatLng({
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            });
                            var request = {
                                origin: current,
                                destination: goal,
                                travelMode: google.maps.TravelMode.TRANSIT
                            };
                            directionsService.route(request, function(response, status){
                                if(status == google.maps.DirectionsStatus.OK){
                                    directionsDisplay.setDirections(response);
                                }
                            });
                        },function(){throw "現在地取得エラー"}, set);
                        
                    }catch(e){
                        alert(e);
                    }
                    
                };
                
                
                //milkcocoaにデータを追加登録する
                $('#btnRegist').on('click', function(){
                    try{
                        //登録用のマーカーが選択されていない場合エラー
                        if(false == registMarker.getVisible()){
                            throw "登録用マーカーが設定されていません";
                        }
                        //登録用マーカーの位置を取得する
                        var latlng = new google.maps.LatLng({lat: registMarker.getPosition().lat(), lng: registMarker.getPosition().lng()});
                        
                        //titleの入力チェックする
                        var title = $('#title').val();
                        if("" === title){
                            //title未入力の場合エラー
                            throw "titleが入力されていません";
                        }
                        
                        //memoの入力内容を取得する
                        var memo = $('#memo').val();
                        
                        //画像保存用フラグがtrueの場合の処理
                        if(true == isSaveImg){
                            //選択した画像のurlをlocalStrageに保存する
                            localStorage.setItem(title, $('#imgCan')[0].toDataURL());
                        }
                        
                        dsCafe.push({"title": title, "latlng": latlng, "memo": memo});
                        alert("登録しました: " + title);
                        
                        //画面を初期状態に戻す
                        $('#memo').val("(ここにmemoを入力してください)");
                        $('#title').val("");
                        registMarker.setVisible(false);
                        cnt.clearRect(0,0,0,0);
                    }catch(e){
                        alert("登録に失敗しました: " + e);
                    }
                });
                
                //memo入力欄をクリックされたら文字列を全選択する
                $('#memo').on('click', function(){
                    $(this).select();
                });

                // アップロードするファイルを選択
                $('input[type=file]').change(function() {
                    var file = $(this).prop('files')[0];
                    //一旦表示している画像を消す
                    cnt.clearRect(0,0,0,0);
                    //一旦保存フラグをfalseにする
                    isSaveImg = false;
                    // 画像以外は処理を停止
                    if (! file.type.match('image.*')) {
                      // クリア
                      $(this).val('');
                      //$('#imgUpload li').remove();
                      return;
                    }

                    // 選択した画像を表示
                    var reader = new FileReader();
                    reader.onload = function() {
                        var image = new Image()
                        image.src = reader.result;
                        cnt.drawImage(image, 0, 0, 150, 150);
                        isSaveImg = true;
                    }
                    reader.readAsDataURL(file);
                });

                //ここへ行くボタンをクリックしたら、現在地ルート検索する
                $(document).on('click', '.btnSearch', function(){
                    var clickedId = $(this).attr('name');
                    var goal;
                    for(var i = 0; i < cafeAllList.length; i++){
                        if(clickedId == cafeAllList[i].id){
                            goal = cafeAllList[i].latlng;
                        }
                    }
                    //現在地からのルートを検索する
                    searchRoute(goal);
                })
                
                
                //listをクリックした時に地図に情報を表示する
                $(document).on('click', '.list', function(){
                    var index = $(this).parent().children().index(this)
                    console.log(cafeAllList[index]);
                    
                    var contStr = "<div class='iwindow'><p class='conTitle'>" + cafeAllList[index].title + "</p><p class='conMemo'>" + cafeAllList[index].memo + "</p><input class='btnSearch' name='" + cafeAllList[index].id +  "' type='button' value='ここへ行く' style='cursor:pointer'></div>";
                    
                    //マーカーに設定するinfowindowを用意する
                    var infowindow = new google.maps.InfoWindow({
                       content: contStr
                    });
                    
                    //マーカーを設置する
                    var cafeMarker = new google.maps.Marker({
                        map: map,
                        position: cafeAllList[index].latlng,
                        visible: true,
                        title: cafeAllList[index].title,
                        cursor: "pointer"
                    });
                    cafeMarker.addListener('click', function(){
                        infowindow.open(map, cafeMarker);
                    });
                    
                    //マップの中心にする
                    map.setCenter(cafeAllList[index].latlng);
                    infowindow.open(map, cafeMarker);
                });
                
            }
            
            //-----地図以外の処理-----
            
            //milkcocoa内に保存されているリストを初期表示する
            function showList(){
                var history = dsCafe.history();
                history.sort('desc');
                history.size(100);
                history.limit(100);
                history.on('data', function(data) {
                    console.log(data);

                    data.reverse();
                    data.forEach(function(d){
                        showMsg(d);
                    });
                });
                history.on('end', function() {
                    console.log('end');
                    console.dir(cafeAllList);
                });
                history.on('error', function(err) {
                    console.error(err);
                });
                history.run();

            }

            //milkcocoaに登録されているデータを1件表示する
            function showMsg(data){
                var imgSrc = ""
                if(localStorage.getItem(data.value.title)){
                    imgSrc = localStorage.getItem(data.value.title);
                }else{
                    imgSrc = "img/noimage.jpg"
                }

                //appendするhtmlの文字列
                var addStr = ""
                addStr = "<li class='list'><div class='cafeImg'><img src='" + imgSrc + "' width='150px' height='150px'></div><ul class='cafeDetail'><li class='cafeName'>" + data.value.title + "</li><li class='cafeMemo'>" + data.value.memo + "</li></ul></li>"

                //追加する
                $("#board").append(addStr);

                //１件の情報をcafeAllListに追加する
                var detail = {
                    id: data.id,
                    title: data.value.title,
                    memo: data.value.memo,
                    latlng: data.value.latlng
                }
                cafeAllList.push(detail);
            }

            //milkcocoaのDBにpushされた内容を表示する
            dsCafe.on('push', function(data){
                showMsg(data);
                //追加したところまでスクロールする
                $(".listArea").animate({scrollTop: $(".listArea")[0].scrollHeight}, 'fast');
            });
            
            
            
        </script>
    </body>
</html>
