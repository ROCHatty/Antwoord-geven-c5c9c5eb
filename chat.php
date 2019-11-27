<?php
if (isset($_GET["name"])) {
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
 	function sendMsg(){
 		var msg = document.getElementById("msg").value;
 		var chat = document.getElementById("chat").value;
 		var hours = new Date().getHours();
 		var min = new Date().getMinutes();
 		var sec = new Date().getSeconds();
 		var usr = "<?php echo $_COOKIE["name"]; ?>";
 		document.getElementById("chat").value = chat + "\n" + hours + ":" + min + ":" + sec + " - " + usr + ": " + msg;
 		document.getElementById("msg").value	 = "";
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