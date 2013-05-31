$(document).ready(function(){
    
    //var ml = screen.width/2 - 180;
    //var ml = 150;
    //alert(ml);
    //$('#thongbao').css("margin-left",ml);
    
    
    
    

	$('.mb_gioithieu').click(function(){
		HideTab();
		RemoveActive();
		$('ul.menutab li.mb_gioithieu').addClass('active');
		$('#tabgioithieu').show();
	});
	$('.mb_thongso').click(function(){
		HideTab();
		RemoveActive();
		$('ul.menutab li.mb_thongso').addClass('active');
		$('#tabthongso').show();D
	});
	$('.mb_hinhanh').click(function(){
		HideTab();
		RemoveActive();
		$('ul.menutab li.mb_hinhanh').addClass('active');
		$('#tabhinhanh').show();
	});
	$('.mb_video').click(function(){
		HideTab();
		RemoveActive();
		$('ul.menutab li.mb_video').addClass('active');
		$('#tabvideo').show();
	});
	
	function RemoveActive(){
		$('ul.menutab li').removeClass('active');
	}
	
	function HideTab(){
		$('#tabgioithieu').hide();
		$('#tabthongso').hide();
		$('#tabhinhanh').hide();
		$('#tabvideo').hide();
	}
	

	$('.menudangnhap').live('click',function(){
		HienFormDangNhap();
	});
	
	$('.menudangxuat').live('click',function(){
		$.ajax({
			url:taaa.appdomain + '/Ajaxdaugia/dangxuat',
			type:'post',
			data:{},
			success:function(data){
				ThongBao("Bạn đã đăng xuất khỏi ứng dụng",1500);
				$('li.username').html("<a class='menudangnhap' href='javascript:;'>Đăng Nhập</a>");
			}
		});	
	});
	
	$('.menuquenmk').live('click',function(){
		HienFormDoiMK();
	});
	
	$('.btnlogin').live('click',function(){
		HienFormDangNhap();
	});
	
	$('#bg_thongbao').click(function(){
		$('#bg_thongbao').hide();
		$('#thongbao').hide();
	});
    

});

function ClickDauGia(ops)
{
    idPD = ops.idpd;
	//IdUserFB = ops.IdUserFB;
	
    //alert (idPD);
	//alert (IdUserFB);
	
    KiemTraDangNhap(idPD);
}


function KiemTraDangNhap(idPD)
{
		$.ajax({
		url:taaa.appdomain + '/Ajaxdaugia/kiemtradangnhap',
		type:'post',
		data:{},
		success:function(data){
			var obj = jQuery.parseJSON(data);
			if(obj.result==0)
			{
				//ThongBao("Bạn cần phải đăng nhập trước khi đấu giá",1500);	
				HienFormDangNhap();
			}
			else
			{
			     //alert('qqqqqqqqqqqqqq');
                KiemTraTGKetThucPD(idPD);           
			}
		}
	});		
}

function KiemTraTGKetThucPD(idPD)
{

    $.ajax({
		url:taaa.appdomain + '/Ajaxdaugia/kiemtraketthucphiendau',
		type:'post',
		data:{idPD:idPD},
		success:function(data){
			var obj = jQuery.parseJSON(data);
            if (obj.result==1)
            {
                KiemTraLanDauGia(idPD);
            }
			if(obj.result==0)
			{
				ThongBaoLoi1("Phiên đấu này sắp diển ra.<br/>Bạn vui lòng xem thời gian bắt đầu phiên đấu.");
			}
			if(obj.result==-1)
			{
				ThongBao("Thời gian đấu giá kết thúc",2000);
				window.location.reload();
			}
		}
	});
    return false;	
}

function KiemTraLanDauGia(idPD)
{
    //alert(idPD);
    //alert(idUser);
    
    $.ajax({
		url:taaa.appdomain + '/Ajaxdaugia/kiemtralandaugia',
		type:'post',
		data:{idpd:idPD},
		success:function(data){
			if(data==1)
			{
                ThongBaoDauGia();
				return false;
			}
			else
			{
                ThongBao("Bạn đang nắm giữ giá đấu cao nhất",2000);
				return false;
			}
		}
	});	  
}

function ThongBaoDauGia()
{
	$('#bg_thongbao').show();
	$('#thongbao').show();
	$('#thongbao').html("<p class='title_tb'>Thông báo</p><div class='content_tb'>Bạn có thực sự muốn đấu giá này</br><input type='button' class='dongybid' id='dongybid' value='Đồng Ý' onclick=\"DauGia({idpd:document.getElementById('hd_idpd').value, giadau:document.getElementById('hd_idgd').value})\"/><input type='button' class='huybid' id='huybid' value='Không Đồng Ý' onclick=\"HuyDauGia()\"/></div>");
}

function HuyDauGia()
{
	$('#bg_thongbao').hide();
	$('#thongbao').hide();
}

function DauGia(ops)
{
 //alert(ops.idpd);
 //alert(ops.giadau);
 //return false;
	$.ajax({
		url:taaa.appdomain + '/Ajaxdaugia',
		type:'post',
		data:{idpd:ops.idpd, giadau:ops.giadau},
		success:function(data){
		  //alert(data);
			ThongBao("Bạn đã đấu giá thành công",1500);
			location.reload(true);
		}
	});	
}

function DanhSachDauGia(ops)
{
    
	$.ajax({
		url:taaa.appdomain + '/Ajaxdaugia/dsdaugia',
		type:'post',
		data:{idpd:ops.idpd},
		success:function(data){
		$('#bg_thongbao').show();
		$('#thongbao').show();
		$('#thongbao').html(data);
		}
	});	
    
}



function ThongBao(nd,time)
{
	$('#bg_thongbao').show();
	$('#thongbao').show();
	$('#thongbao').html("<p class='title_tb'>Thông báo</p><div class='content_tb'>"+nd+"</div>");
	myVar = setTimeout(function(){$('#thongbao').hide(); $('#bg_thongbao').hide();return false},time);
}

function ThongBaoLoi1(nd)
{
	$('#bg_thongbao').show();
	$('#thongbao').show();
	$('#thongbao').html("<p class='title_tb'>Thông báo</p><div class='content_tb'>"+nd+"</div><p class='bt_dongy_tb' onclick=\"Ok_ThongBaoLoi1()\">Đồng ý</p>");
}

function Ok_ThongBaoLoi1()
{
	$('#thongbao').hide(); 
	$('#bg_thongbao').hide();
	return false;
}


function HienFormDangNhap()
{
	$('#bg_thongbao').show();
	$('#thongbao').show();
	$('#thongbao').html("<p class='title_tb'>Đăng Nhập</p><div class='content_tb'><table class='login'><tr><td colspan='2'><span class='thongbaologin'>Bạn cần đăng nhập trước khi đấu giá</span></td></tr><tr><td width='115'>Tên Đăng Nhập</td><td><input class='inputstyle' type='text' id='username' name='username'/></td></tr><tr><td>Mật Khẩu</td><td><input class='inputstyle' type='password' id='password' name='password'/></td></tr><tr><td></td><td><input class='inputstyle2' type='button' name='btnlogin' value='Đăng Nhập' onclick=\"DangNhap({username:document.getElementById('username').value, password:document.getElementById('password').value, IdUserFB:document.getElementById('IdUserFB').value})\"/></td></tr><tr><td colspan='2'><span class='loidangnhap'></span></td></tr><tr><td></td><td><a href='javascript:;' onclick=\"KiemTraIDFBDangKy(document.getElementById('IdUserFB').value)\" class='btnregister'>Đăng Ký</a>/<a href='javascript:;' onclick=\"HienFormQuenMK(document.getElementById('IdUserFB').value)\" class='btnregister'>Quên mật khẩu</a></td></tr></table></div>");
}



function DangNhap(ops)
{
	if(ops.username=="")
	{
		$('span.loidangnhap').html("Tên đăng nhập không được để trống");
		return false;
	}
	if(ops.password=="")
	{
		$('span.loidangnhap').html("Mật khẩu không được để trống");
		return false;
	}
	$.ajax({
		url:taaa.appdomain + '/Ajaxdaugia/dangnhap',
		type:'post',
		data:{username:ops.username, password:ops.password, IdUserFB:ops.IdUserFB},
		success:function(data){
		//alert(data);
			var obj = jQuery.parseJSON(data);
			//alert('aaaaaaaa');
				//alert(obj.result);return false;
			if(obj.result == 1)
			{
				ThongBao("Đăng nhập thành công",1500);
				$('li.username').html("<a href='javascript:;'>"+ obj.data[0]["hoten"] +"</a><ul class='ul_child_menu'><li><a class='menuquenmk' href='javascript:;'>Đổi Mật Khẩu</a><li><a class='menudangxuat' href='javascript:;'>Đăng Xuất</a></li></ul>");
			}
			else
				$('span.loidangnhap').html("Tên đăng nhập hoặc mật khẩu không đúng.</br>Lưu ý : Tài khoản trên ứng dụng chỉ đăng nhập thành công trên tài khoản Facebook đã tạo ra trước đó.");
		}
	});		
}

function checkmail(email){
	var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
	var returnval=emailfilter.test(email)
	return returnval;
}
function checkphone(phone)
{
	if(phone.length<10)
		return false;
	var phonefilter = /^[0-9]+$/;
	var returnval = phonefilter.test(phone);
		return returnval;
}

function KiemTraIDFBDangKy(IdUserFB)
{
	$.ajax({
		url:taaa.appdomain + '/Ajaxdaugia/kiemtraidfacebookdadangky',
		type:'post',
		data:{IdUserFB:IdUserFB},
		success:function(data){

			var obj = jQuery.parseJSON(data);
			if(obj.IdUserFB == 1)
			{
				HienThiFormDangKy();
			}
			else
			{
				//alert('Khong DK duoc roi');
				ThongBaoLoi1("IDFB : " + obj.IdUserFB + "<br/>Tài khoản FB này đã tạo tài khoản trên ứng dụng. ");
			}
		}
	});		


}

function KiemTraDangKy(ops)
{

	var IdUserFB = ops.IdUserFB;
	var NameUserFB = ops.NameUserFB;
	var LinkFB = ops.LinkFB;
	//var IdUserFB = 123456789;
	var username = ops.username;
	var hoten = ops.hoten;
	var password = ops.password;
	var repassword = ops.repassword;
	var sdt = ops.sdt;
	var email = ops.email;
	var diachi = ops.diachi;

	// alert(NameUserFB);
	// alert(IdUserFB);alert(hoten);alert(username);alert(password);alert(repassword);alert(sdt);alert(email);alert(diachi);
	// return false;
	$.ajax({
		url:taaa.appdomain + '/Ajaxdaugia/kiemtrathongtindangky',
		type:'post',
		data:{IdUserFB:IdUserFB, username:username},
		success:function(data){
			var obj = jQuery.parseJSON(data);

			if(obj.username==0)
			{
				$('span.loidangky').html("Tên đăng nhập đã được đăng ký");
				return false;
			}
			
			if(hoten=="" || username=="" || password=="" || repassword=="" || sdt=="" || email=="" ||diachi=="")
			{
				$('span.loidangky').html("Chưa nhập đủ thông tin");
				return false;
			}
			else
			{
				if(password != repassword)
				{
					$('span.loidangky').html("2 mật khẩu không giống nhau");
					return false;
				}
				else if(password.length < 6)
				{
					$('span.loidangky').html("Mật khẩu tối thiểu 6 ký tự");
					return false;
				}
				if(checkphone(sdt)==false)
				{
					$('span.loidangky').html("Số điện thoại không hợp lệ");
					return false;
				}
				if(checkmail(email)==false)
				{
					$('span.loidangky').html("Email không hợp lệ");
					return false;
				}
				else
				{
					$('span.loidangky').html("");
					DangKy(IdUserFB, NameUserFB, LinkFB, username, password, hoten, sdt, email, diachi);
					
				}
			}
		}
	});	
	
}

function HienThiFormDangKy()
{
	$('#bg_thongbao').show();
	$('#thongbao').show();
	var str = "";
	str +="<p class='title_tb'>Đăng Ký</p>";
	str +="<div class='content_tb'>";
	str +="<table class='login'>";
	str +="<tr><td width='115'>Họ Tên</td><td><input class='inputstyle' type='text' id='hoten' name='hoten'/></td></tr>";
	str +="<tr><td>Tên Đăng Nhập</td><td><input class='inputstyle' type='text' id='username' name='username'/></td></tr>";
	str +="<tr><td>Mật Khẩu</td><td><input class='inputstyle' type='password' id='password' name='password'/></td></tr>";
	str +="<tr><td>Nhập Lại Mật Khẩu</td><td><input class='inputstyle' type='password' id='repassword' name='repassword'/></td></tr>";
	str +="<tr><td>Số Điện Thoại</td><td><input class='inputstyle' type='text' id='sdt' name='sdt'/></td></tr>";
	str +="<tr><td>Email</td><td><input class='inputstyle' type='text' id='email' name='email'/></td></tr>";
	str +="<tr><td>Địa Chỉ</td><td><input class='inputstyle' type='text' id='diachi' name='diachi'/></td></tr>";
	str +="<tr><td><a class='btnlogin' href='javascript:;'>Đăng Nhập</a></td><td><input type='button' class='btndangky inputstyle2' value='Đăng Ký' onclick=\"KiemTraDangKy({IdUserFB:document.getElementById('IdUserFB').value, NameUserFB:document.getElementById('NameUserFB').value, LinkFB:document.getElementById('LinkFB').value, hoten:document.getElementById('hoten').value, username:document.getElementById('username').value, password:document.getElementById('password').value, repassword:document.getElementById('repassword').value, sdt:document.getElementById('sdt').value, email:document.getElementById('email').value, diachi:document.getElementById('diachi').value})\"/></td></tr>";
	str +="<tr><td colspan='2'><span class='loidangky'></span></td></tr></table></div>";
	$('#thongbao').html(str);
}

function DangKy(IdUserFB, NameUserFB, LinkFB, username, password, hoten, sdt, email, diachi)
{
	$.ajax({
		url:taaa.appdomain + '/Ajaxdaugia/dangky',
		type:'post',
		data:{IdUserFB:IdUserFB, NameUserFB:NameUserFB, LinkFB:LinkFB, username:username, password:password, hoten:hoten, sdt:sdt, email:email, diachi:diachi },
		success:function(data){
		//alert(data);
			ThongBao(data,2000);
		}
	});		
}

function HienFormQuenMK(iduserFB)
{
	$('#bg_thongbao').show();
	$('#thongbao').show();
	$('#thongbao').html("<p class='title_tb'>Quên Mật Khẩu</p><div class='content_tb'><table class='login'><tr><td width='115'>ID Facebook</td><td><input class='inputstyle' readonly='true' type='text' id='iduserfb' name='iduserfb' value='"+iduserFB+"'/></td></tr><tr><td>Tên đăng nhâp</td><td><input class='inputstyle' type='text' id='username' name='username'/></td></tr><tr><td>Email</td><td><input class='inputstyle' type='text' id='email' name='email'/></td></tr><tr><td></td><td><input class='inputstyle2' type='button' name='btnlogin' value='Lấy lại mk' onclick = \"LayLaiMK(document.getElementById('email').value, document.getElementById('iduserfb').value, document.getElementById('username').value)\" /></td></tr><tr><td colspan='2'><span class='loilaymk'></span></td></tr></table></div>");
}

function LayLaiMK(email, iduserfb, username)
{
	//alert(email);
	//alert(iduserfb);
	if(username == "")
	{
		$('span.loilaymk').html("Tên đăng nhập không được để trống.");
		return false;
	}
	if(checkmail(email) == false)
	{
		$('span.loilaymk').html("Email chưa đúng định dạng.");
		return false;
	}
	$.ajax({
		url:taaa.appdomain + '/Ajaxdaugia/laymatkhau',
		type:'post',
		data:{email:email, iduserfb:iduserfb, username:username},
		success:function(data){
			if(data == 1)
			{
				ThongBaoLoi1('Mật khẩu bạn đã thay đổi về 123456<br/>Hãy đổi lại mật khẩu.');
				return false;
			}
			if(data == 0)
			{
				$('span.loilaymk').html("Không thể lấy lại mật khẩu.<br/>Thông tin bạn nhập chưa chính xác.");
				return false;
			}
			
		}
	});
}
function HienFormDoiMK()
{
	$('#bg_thongbao').show();
	$('#thongbao').show();
	$('#thongbao').html("<p class='title_tb'>Đổi Mật Khẩu</p><div class='content_tb'><table class='login'><tr><td width='145'>Mật khẩu cũ</td><td><input class='inputstyle' type='password' id='oldpass' name='oldpass' /></td></tr><tr><td>Mật khẩu mới</td><td><input class='inputstyle' type='password' id='newpass' name='newpass'/></td></tr><tr><td>Nhập lại mật khẩu mới</td><td><input class='inputstyle' type='password' id='newrepass' name='newrepass'/></td></tr><tr><td></td><td><input class='inputstyle2' type='button' name='btnlogin' value='Đổi mật khẩu' onclick = \"ThayDoiMK(document.getElementById('IdUserFB').value, document.getElementById('oldpass').value, document.getElementById('newpass').value, document.getElementById('newrepass').value)\" /></td></tr><tr><td colspan='2'><span class='loidoimk'></span></td></tr></table></div>");
}

function ThayDoiMK(iduserfb, oldpass, newpass, newrepass)
{
	if(oldpass == "" || newpass == "" || newrepass == "")
	{
		$('span.loidoimk').html("Bạn cần phải nhập đủ thông tin.");
			return false;
	}
	else
	{
		if(newpass.length <6)
		{
			$('span.loidoimk').html("Mật khẩu mới phải có chiều dài tối thiểu 6 ký tự.");
				return false;
		}
		else
		if(newpass != newrepass)
		{
			$('span.loidoimk').html("2 mật khẩu mới nhập không giống nhau.");
			return false;
		}
	}
	$('span.loidoimk').html("");
	$.ajax({
		url:taaa.appdomain + '/Ajaxdaugia/thaydoimatkhau',
		type:'post',
		data:{iduserfb:iduserfb, oldpass:oldpass, newpass:newpass},
		success:function(data){
			if(data == 1)
			{
				ThongBaoLoi1('Mật khẩu của bạn thay đổi thành công.');
				return false;
			}
			if(data == 0)
			{
				$('span.loidoimk').html("Mật khẩu cũ nhập chưa chính xác.");
				return false;
			}
			
		}
	});	
	
}

function danglentuong(title, cap, des, link, pic) {
	FB.ui(
	  {
		method: 'feed',
		name: title,
		link: link,
		caption: cap,
		picture: pic,
		message: 'Message',
		description: des
	  }
	);
}


























