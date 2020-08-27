<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Simple CRUD - Login</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Edit Profile | <small><a href="<?php echo base_url('dashboard');?>">Back <<</a></small></h1>
	<div id="body">
		<?php echo form_open('update'); ?>
		<?php if (isset($message)){ ?>
		<p color="red"><?php echo $message;}?></p>
		<?php foreach($users as $user){ ?>
		<input type="hidden" name="uid" value="<?php echo $user->uid;?>">
		<p>Username</p>
		<input type="text" name="uname" value="<?php echo $user->uname;?>">
		<p>E-mail</p>
		<input type="email" name="email" value="<?php echo $user->email;?>">
		<p>Password</p>
		<input type="password" name="password" value="">
		<p>First Name</p>
		<input type="text" name="firstname" value="<?php echo $user->firstname;?>">
		<p>Last Name</p>
		<input type="text" name="lastname" value="<?php echo $user->lastname;?>">
		<p>Address</p>
		<textarea name="address"><?php echo $user->address;?></textarea>
		<p>Website</p>
		<input type="text" name="website" value="<?php echo $user->website;?>">
		<input type="submit" name="submit" value="Update">
		<?php } ?>
		<?php echo form_close(); ?>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>