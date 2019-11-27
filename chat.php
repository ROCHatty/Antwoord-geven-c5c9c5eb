<?php
if (isset($_GET["chat"])){
		$c = strtolower($_GET["chat"]);
		if (strpos($c, "bereken voor mij") === true || strpos($c, "wat is") === true || strpos($c, "hoeveel is") === true || strpos($c, "bereken het volgende") === true || strpos($c, "calculate") === true){
		$c = str_replace("bereken voor mij ", "", $c);
		$c = str_replace("wat is ", "", $c);
		$c = str_replace("hoeveel is ", "", $c);
		$c = str_replace("bereken het volgende ", "", $c);
		$c = str_replace("calculate ", "", $c);
		
		if (strpos($c, "+") === true){
			$d = explode("+", $c);
			$e = 0;
			foreach ($d as $value) {
				$e += $value;
			}
		}
		elseif (strpos($c, "-") === true){
			$d = explode("-", $c);
			$e = $d[0];
			array_shift($d);
			foreach ($d as $value) {
				$e -= $value;
			}
		}
		elseif (strpos($c, "*") === true){
			$d = explode("*", $c);
			$e = $d[0];
			array_shift($d);
			foreach ($c as $value) {
				$e *= $value;
			}
		}
		elseif (strpos($c, "/") === true){
			$d = explode("/", $c);
			$e = $d[0];
			array_shift($d);
			foreach ($d as $value) {
				$e /= $value;
			}
		}
		elseif (strpos($c, "%") === true){
			$d = explode("%", $c);
			$e = $d[0];
			array_shift($d);
			foreach ($d as $value) {
				$e %= $value;
			}
		}
	}
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
 		httpGet("chat.php?chat=" + msg);
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