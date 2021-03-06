<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>成都先讯后台管理平台</title>
    <!-- Bootstrap Core CSS -->
    <link href="/Public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/Public/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/Public/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/Public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/Public/css/sing/common.css" />
    <link rel="stylesheet" href="/Public/css/party/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="/Public/css/party/uploadify.css">

    <!-- jQuery -->
    <script src="/Public/js/jquery.js"></script>
    <script src="/Public/js/bootstrap.min.js"></script>
    <script src="/Public/js/dialog/layer.js"></script>
    <script src="/Public/js/dialog.js"></script>
    <script type="text/javascript" src="/Public/js/party/jquery.uploadify.js"></script>

</head>

    



<body>

<div id="wrapper">

    <?php
 $navs = D("Menu")->getAdminMenus(); $username = getLoginUsername(); foreach($navs as $k=>$v) { if($v['c'] == 'admin' && $username != 'admin') { unset($navs[$k]); } } $index = 'index'; ?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">

    <a class="navbar-brand" >成都先讯管理平台</a>
  </div>
  <!-- Top Menu Items -->
  <ul class="nav navbar-right top-nav">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo getLoginUsername()?> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li>
          <a href="/admin.php?c=admin&a=personal"><i class="fa fa-fw fa-user"></i> 个人中心</a>
        </li>
        <li class="divider"></li>
        <li>
          <a href="/admin.php?c=login&a=loginout"><i class="fa fa-fw fa-power-off"></i> 退出</a>
        </li>
      </ul>
    </li>
  </ul>
  <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav nav_list">
      <li <?php echo (getActive($index)); ?>>
        <a href="/admin.php"><i class="fa fa-fw fa-dashboard"></i> 首页</a>
      </li>
      <?php if(is_array($navs)): $i = 0; $__LIST__ = $navs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$navo): $mod = ($i % 2 );++$i; if(checkOperModule($navo['c'])){ ?>
      <li <?php echo (getActive($navo["c"])); ?>>
        <a href="<?php echo (getAdminMenuUrl($navo)); ?>"><i class="fa fa-fw fa-bar-chart-o"></i> <?php echo ($navo["name"]); ?></a>
      </li>
      <?php } endforeach; endif; else: echo "" ;endif; ?>

    </ul>
  </div>
  <!-- /.navbar-collapse -->
</nav>


<script type="text/javascript">
  setInterval(function(){
    $.get('/admin.php?c=login&a=heart', '');
  }, 5000);
</script>
<div id="page-wrapper">

	<div class="container-fluid">

		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">

				<ol class="breadcrumb">
					<li>
						<i class="fa fa-dashboard"></i>  <a href="javascript:void(0)">货机管理</a>
					</li>
					<li class="active">
						<i class="fa fa-edit"></i> 修改
					</li>
				</ol>
			</div>
		</div>
		<!-- /.row -->

		<div class="row">
			<div class="col-lg-6">

				<form class="form-horizontal" id="singcms-form">
					<div class="form-group">
						<label  class="col-sm-2 control-label">设备名称:</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="devicename" id="inputPassword1" placeholder="" value="<?php echo ($vo["devicename"]); ?>">
						</div>
					</div>
					<div class="form-group">
						<label  class="col-sm-2 control-label">设备类型:</label>
						<select class="btn btn-default" name="devicetypeid" style="margin-left: 14px;">
							<option value=''>请选择类型</option>
							<?php if(is_array($devicetype)): foreach($devicetype as $key=>$v): ?><option value="<?php echo ($v["devicetypeid"]); ?>" <?php if($vo["devicetype"] == $v['devicetypeid']): ?>selected="selected"<?php endif; ?> ><?php echo ($v["devicetypename"]); ?></option><?php endforeach; endif; ?>
						</select>
					</div>
					<div class="form-group">
						<label  class="col-sm-2 control-label">商品:</label>
						<select class="btn btn-default" name="goods_id" style="margin-left: 14px;">
							<option value=''>请选择商品</option>
							<?php if(is_array($goods)): foreach($goods as $key=>$v): ?><option value="<?php echo ($v["goods_id"]); ?>" <?php if($vo["goods_id"] == $v['goods_id']): ?>selected="selected"<?php endif; ?> ><?php echo ($v["goods_name"]); ?></option><?php endforeach; endif; ?>
						</select>
					</div>
					<div class="form-group">
						<label  class="col-sm-2 control-label">会员:</label>
						<select class="btn btn-default" name="user_id" style="margin-left: 14px;">
							<option value=''>请选择类型</option>
							<?php if(is_array($users)): foreach($users as $key=>$v): ?><option value="<?php echo ($v["user_id"]); ?>" <?php if($vo["userid"] == $v['user_id']): ?>selected="selected"<?php endif; ?> ><?php echo ($v["username"]); ?></option><?php endforeach; endif; ?>
						</select>
					</div>
					<input type="hidden" name="dev_id" value="<?php echo ($vo["id"]); ?>"/>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="button" class="btn btn-default" id="singcms-button-submit">提交</button>
						</div>
					</div>
				</form>


			</div>

		</div>
		<!-- /.row -->

	</div>
	<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
<script>
	var SCOPE = {
		'save_url' : '/admin.php?c=machine&a=save',
		'jump_url' : '',
	};

</script>
<!-- /#wrapper -->
<script type="text/javascript" src="/Public/js/admin/form.js"></script>
<script src="/Public/js/admin/common.js"></script>



</body>

</html>