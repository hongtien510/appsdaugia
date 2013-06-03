<?php

class Admin_ConfigController extends App_Controller_AdminController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
		$daugia = $this->view->info = App_Models_DaugiaModel::getInstance();

		$_SESSION['list_page'] = 1;
		if($this->_request->getParam("idpage") != "")
        {
			$idpagee = $this->_request->getParam("idpage");
			$_SESSION['idpage'] = $idpagee;
		}
		@$idpage = $_SESSION['idpage'];
		$checkSessionIdpage = $daugia->KiemTraSessionIdPage($idpage);
		if($checkSessionIdpage == 0)
		{
			$this->view->checkSessionIdpage = $checkSessionIdpage;
		}
		else
		{
			$sql = "Select * from ishali_config where idpage = '". $idpage ."'";
			$config = $daugia->SelectQuery($sql);
			$this->view->config = $config;
			$this->view->checkSessionIdpage = $checkSessionIdpage;
		}

    }
	
	public function xulyconfigAction() {
		$daugia = $this->view->info = App_Models_DaugiaModel::getInstance();
		
		$idpage = $_SESSION['idpage'];
		
		$banner = "";
		@$file=$_FILES['banner'];
		if($file['name']!="")//Neu nhu NSD co upload file
		{
			$banner=time().'_'.$file['name'];
			move_uploaded_file($file['tmp_name'],'public/images/banner/'.$banner);
		}
	
		$footer = $_POST['footer'];
		
		$donvitien = $_POST['donvitien'];
		$linkpage = $_POST['linkpage'];
		
		if(@$_POST['thongtinsp'] != "")
			$thongtinsp = @$_POST['thongtinsp'];
		else
			$thongtinsp = 0;
		$menuthongtinsp = $_POST['menuthongtinsp'];
		if($menuthongtinsp == "")
			$thongtinsp = 0;
		
		$sql = "Select 1 from ishali_config where idpage = '". $idpage ."'";
		$data = $daugia->SelectQuery($sql);
		
		if(count($data)==0)
		{
			if($banner == "")
			{
				$sql = "insert into ishali_config(idpage, footer, donvitien, thongtinsp, menuthongtinsp, link_page) ";
				$sql.= "value('$idpage', '$footer', '$donvitien', '$thongtinsp', '$menuthongtinsp', '$linkpage')";
			}
			else
			{
				$sql = "insert into ishali_config(idpage, banner, footer, donvitien, thongtinsp, menuthongtinsp, link_page) ";
				$sql.= "value('$idpage', '$banner', '$footer', '$donvitien', '$thongtinsp', '$menuthongtinsp', '$linkpage')";
			}
		}
		else
		{
			if($banner == "")
			{
				$sql = "Update ishali_config set ";
				$sql.= "footer = '". $footer . "', ";
				$sql.= "donvitien = '". $donvitien . "', ";
				$sql.= "thongtinsp = '". $thongtinsp . "', ";
				$sql.= "menuthongtinsp = '". $menuthongtinsp . "', ";
				$sql.= "link_page = '". $linkpage . "' ";
				
				$sql.= "where idpage = '". $idpage ."'";
			}
			else
			{
				$sql = "Select banner from ishali_config where idpage = '". $idpage ."'";
				$bn = $daugia->SelectQuery($sql);
				
				if($bn[0]['banner'] != "")
				{
					$banner_old = $bn[0]['banner'];
					if(file_exists('public/images/banner/'.$banner_old))
					{
						unlink('public/images/banner/'.$banner_old);
					}
				}

				$sql = "Update ishali_config set ";
				$sql.= "banner = '". $banner . "', ";
				$sql.= "footer = '". $footer . "', ";
				$sql.= "donvitien = '". $donvitien . "', ";
				$sql.= "thongtinsp = '". $thongtinsp . "', ";
				$sql.= "menuthongtinsp = '". $menuthongtinsp . "', ";
				$sql.= "link_page = '". $linkpage . "' ";
				
				$sql.= "where idpage = '". $idpage ."'";
			}
		}
		//echo $sql;
		
		$config = $daugia->InsertDeleteUpdateQuery($sql);
		if($config == 1)
		{
			echo "<script>ThongBaoDongY('Lưu Thành Công.', taaa.appdomain+'/admin/config');</script>";	
		}
		else
		{
			echo "<script>ThongBaoDongY('Lưu không thành công<br/>Vui Lòng thực hiện lại thao tác.', taaa.appdomain+'/admin/config');</script>";
		}
		
	}
    

}








































