<?php
include 'classes/FileList.class.php';
ini_set("display_errors", 0);
$files = new OpenFile();
?>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">	
		<link class="main-stylesheet" href="pages/css/pages.css" rel="stylesheet" type="text/css"/>
		<style> .messError{color:red} .sign-style{ border:solid; border-width:1px;} </style>
	</head>
	<body>
		<div class="container" align="center" style="width:50%; margin-top: 10%;" >
			<h2>Welcome in GlobalVoices <br>  QAReview!</h2> 
			<div class="panel panel-transparent m-t-10" style="width:50%"; >
				<br>
				<div class="form-group form-group-default ">
					<form id="loginForm">
						<div id="loginError" class="messError"></div>
							<label>User name</label>
							<input type="text" style="border:solid; border-width:1px;" class="form-group" id="username" required="true">
							<label>Password</label>
							<input type="password" style="border:solid; border-width:1px;" class="form-group" id="pw" required="true">
						</div>
					<br>
						<button class="btn btn-primary form-group" type="button" data-toggle="modal" data-target="#signUpForm"> Sign Up </button>
						<button type="submit" onclick="login()" class=" btn btn-primary form-group">        Login      </button>
					</form>
			</div>
		</div>
<!-- MODAL SIGN UP-->
	<div class="modal fade" id="signUpForm" tabindex="-1" role="dialog" aria-labelledby="signUpnLabel" aria-hidden="true">
	<form>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Sign Up</h4>
				<div id="errorSignUp"></div>
				</div>
				<div class="modal-body ">
						<div>
							<label for="inputEmail" class="sr-only">Nome</label>
									<input name="user" id="nome" class="form-control form-group "  placeholder="Nome" aria-describedby="nomeStatus" required onfocusout="check(this)">
						</div>
						<div>
							<label for="inputEmail" class="sr-only">Cognome</label>
								<input name="user" id="cognome" class="form-control form-group" placeholder="Cognome" required onfocusout="check(this)">
						</div>
						<div>
							<label for="inputEmail" class="sr-only">User Name</label>
								<input name="user" id="userName" class="form-control form-group" placeholder="UserName" required onfocusout="check(this)">
						</div>
						<fieldset class="form-group">
							<label class="checkbox-inline"><input type="radio" name="gender" value="m" >M</label>
							<label class="checkbox-inline"><input type="radio" name="gender" value="f">F</label>
						</fieldset>
						<div>
							<label for="pwd" class="sr-only">Password</label>
								<input type="password" id="pwd1" name="pwd" class="form-control form-group" placeholder="Password" required onfocusout="check(this)">
						</div>
						<div>
							<label for="pwd" class="sr-only">Conferma Password</label>
								<input type="password" id="pwd2" name="pwd" class="form-control form-group" placeholder="Conferma Password" required onfocusout="check(this)">
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn resetSignUp" data-dismiss="modal">Annulla</button>
					<button class="btn btn-primary" type="submit"> Sign Up </button>
				</div>
			</div>
		</div>
	</form>
</div>
		
</body>
</html>
<script src="js/ModalCorrectionComment.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
<script src="js/notify.js"></script>
<script src="js/main.js"></script>
