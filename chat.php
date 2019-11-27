<?php
if (isset($_GET["chat"])){
		$c = strtolower($_GET["chat"]);
		if (strpos($c, "bereken voor mij") !== false || strpos($c, "wat is") !== false || strpos($c, "hoeveel is") !== false || strpos($c, "bereken het volgende") !== false || strpos($c, "calculate") !== false){
		$c = str_replace("bereken voor mij ", "", $c);
		$c = str_replace("wat is ", "", $c);
		$c = str_replace("hoeveel is ", "", $c);
		$c = str_replace("bereken het volgende ", "", $c);
		$c = str_replace("calculate ", "", $c);
		$c = str_replace("?", "", $c);
		$c = str_replace(" ", "", $c);
		
		if (strpos($c, "+") !== false){
			$d = explode("+", $c);
			$e = 0;
			foreach ($d as $value) {
				$e += $value;
			}
		}
		elseif (strpos($c, "-") !== false){
			$d = explode("-", $c);
			$e = $d[0];
			array_shift($d);
			foreach ($d as $value) {
				$e -= $value;
			}
		}
		elseif (strpos($c, "*") !== false){
			$d = explode("*", $c);
			$e = $d[0];
			array_shift($d);
			foreach ($d as $value) {
				$e *= $value;
			}
		}
		elseif (strpos($c, "/") !== false){
			$d = explode("/", $c);
			$e = $d[0];
			array_shift($d);
			foreach ($d as $value) {
				$e /= $value;
			}
		}
		elseif (strpos($c, "%") !== false){
			$d = explode("%", $c);
			$e = $d[0];
			array_shift($d);
			foreach ($d as $value) {
				$e %= $value;
			}
		} else {
			echo json_encode(array("success"=>false, "a"=>$c));
			die();
		}
		echo json_encode(array("success"=>true, "a"=>$e, "b"=>$c));
		die();
	}
	else 
		echo "10";
}
elseif (isset($_GET["name"])) {
	setcookie("name", $_GET["name"], time() + 3600);
	header("Location: chat.php");
}
elseif (!isset($_COOKIE["name"])) {
?>
<h1>Wat is je naam?</h1>
<form>
	<input type="text" name="name">
	<input type="submit" name="submit">
</form>
<?php
}
else {
 ?>
 <p>Je praat nu met een chatbot</p>
 <textarea id="chat" style="height: 300px; width: 500px;"	 disabled></textarea><br>
 <p>Type een bericht</p>
 <input type="text" id="msg">
 <button onclick="sendMsg();">send</button>
 <script>
 	function httpGet(theUrl){
 		var xmlHttp = new XMLHttpRequest();
 		xmlHttp.open("GET", theUrl, false);
 		xmlHttp.send(null);
 		return xmlHttp.responseText;
 	}
 	function sendMsg(){
 		var msg = document.getElementById("msg").value;
 		var chat = document.getElementById("chat").value;
 		var hours = new Date().getHours();
 		var min = new Date().getMinutes();
 		var sec = new Date().getSeconds();
 		var usr = "<?php echo $_COOKIE["name"]; ?>";
 		document.getElementById("chat").value = chat + "\n" + hours + ":" + min + ":" + sec + " - " + usr + ": " + msg;
 		document.getElementById("msg").value	 = "";
 		var o = JSON.parse(httpGet("chat.php?chat=" + encodeURIComponent(msg)));
		if (o.success) {
			document.getElementById("chat").value = document.getElementById("chat").value + "\n" + hours + ":" + min + ":" + sec + " - greuBot: " + o.b + " = " + o.a;
		}
 		var a = document.getElementById("chat");
 		a.scrollTop = a.scrollHeight;
 	}
 	var input = document.getElementById("msg");
 	input.addEventListener("keyup", function(event) {
 		if (event.keyCode === 13)
 			sendMsg();
 	});
 </script>
 <?php
}
?>