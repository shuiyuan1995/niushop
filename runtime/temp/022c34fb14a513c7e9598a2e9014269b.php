<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:50:"template/wap\default_new\pay\credit_card_info.html";i:1554650593;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="UTF-8">
	<title><?php echo lang('choose_payment_method'); ?>-<?php echo $title; ?></title>
		<link type="text/css" rel="stylesheet" href="__TEMP__/<?php echo $style; ?>/public/css/pay/pcPayValue.css">
		<style>
			.payment-wrap{
				text-align: center;
			}
			.payment-wrap label{
				display: block;
				margin-top: 10px;
			}
			.payment-wrap label span{
				display: inline-block;
				width: 100px;
				text-align: right;
				color: #999;
			}
			.payment-wrap label select{
				border: 1px solid #ddd;
				height: 35px;
				width: 104px;
				line-height: 30px;
				padding: 0px 5px;
				color: #333333;
			}
			.payment-wrap label input{
				border: 1px solid #ddd;
				height: 30px;
				width: 200px;
				line-height: 30px;
				padding: 0px 5px;
				color: #333333;
			}
			.payment-wrap label:first-of-type select{
				width: 212px;
			}
			.payment-wrap button{
				margin-top: 10px;
				padding: 6px 15px;
				cursor: pointer;
				border: none;
				background: #3bbae5;
			}
		</style>
		<link rel="stylesheet" href="__TEMP__/<?php echo $style; ?>/public/css/layer.css" id="layuicss-skinlayercss">
	</head>
	<body class="body">
		<div class="header">
			<div class="container">
				<div class="logo fl">
					<img alt="<?php echo $web_info['title']; ?><?php echo lang('cashier_desk'); ?>" src="<?php echo __IMG($web_info['logo']); ?>" />
				</div>
			</div>
		</div>
		<!-- 订单支付内容区域 -->
		<div class="pay-body">
			<div class="payment-wrap">
				<h2>信息填写</h2>
				<form action="APP_MAIN/pay/credit_card_info" method="post">
					<label for="">
						<span>选择信用卡:</span>
						<select name="ckind" id="">
							<option value="Visa">Visa</option>
							<option value="Master">Master card</option>
							<option value="Discover">Discover</option>
							<option value="Amex">Amex</option>
						</select>
					</label>
					<label for="">
						<span>持卡人姓名:</span>
						<input id="" type="text" name="username">
					</label>
					<label for="">
						<span>卡号:</span>
						<input id="" type="text" name="cid">
					</label>
					<label for="">
						<span>失效日期:</span>
						<select name="month" id="">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
						</select>/<select name="year" id="">
							<option value="2019">2019</option>
							<option value="2020">2020</option>
							<option value="2021">2021</option>
							<option value="2022">2022</option>
							<option value="2023">2023</option>
						</select>
					</label>
					<label for="">
						<span>安全码:</span>
						<input id="code" type="text" name="pwd">
					</label>
					<button type="submit" onclick="aa()">提交</button>
					<!-- <a href="APP_MAIN/pay/credit_card_info" onclick="aa()" id="btn-success">提交</a> -->
				</form>
			</div>
		</div>
		<script src="__TEMP__/<?php echo $style; ?>/public/js/jquery.js"></script>
		<script type="text/javascript" src="__TEMP__/<?php echo $style; ?>/public/js/layer.js"></script>
		<script type="text/javascript">
			function aa(){
				if($('#name').val() == ''){
					layer.msg("收货人姓名不能为空", {
						time: 2000
					});
					return false;
				}
				if($('#card').val() == ''){
					layer.msg("卡号不能为空", {
						time: 2000
					});
					return false;
				}
				if($('#code').val() == ''){
					layer.msg("安全码不能为空", {
						time: 2000
					});
					return false;
				}
			}
		</script>
	</body>
</html>