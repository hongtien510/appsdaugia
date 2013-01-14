$(document).ready(function(){

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
		$('#tabthongso').show();
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
	
	// $('.dsnguoibid').click(function(){
		// ThongBao("Bạn đã đấu giá thành công");
	// });
	
	$('#bg_thongbao').click(function(){
		$('#bg_thongbao').hide();
		$('#thongbao').hide();
	});
	
	$('.btn_daugia').click(function(){
		//ThongBaoDauGia();
			KiemTraDangNhap();
	});

	$('.btnregister').live('click',function(){
		HienThiFormDangKy();
	});
	
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
	
	$('.btnlogin').live('click',function(){
		HienFormDangNhap();
	});
});

function ThongBao(nd,time)
{
	$('#bg_thongbao').show();
	$('#thongbao').show();
	$('#thongbao').html("<p class='title_tb'>Thông báo</p><div class='content_tb'>"+nd+"</div>");
	myVar = setTimeout(function(){$('#thongbao').hide(); $('#bg_thongbao').hide();return false},time);
}


function HuyDauGia()
{
	$('#bg_thongbao').hide();
	$('#thongbao').hide();
}

function ThongBaoDauGia()
{
	$('#bg_thongbao').show();
	$('#thongbao').show();
	$('#thongbao').html("<p class='title_tb'>Thông báo</p><div class='content_tb'>Bạn có thực sự muốn đấu giá này</br><input type='button' class='dongybid' id='dongybid' value='Đồng Ý' onclick=\"DauGia({idpd:document.getElementById('hd_idpd').value, iduser:document.getElementById('hd_iduser').value, giadau:document.getElementById('hd_idgd').value})\"/><input type='button' class='huybid' id='huybid' value='Không Đồng Ý' onclick=\"HuyDauGia()\"/></div>");
}
function DauGia(ops)
{
// alert(ops.idpd);
// alert(ops.iduser);
// alert(ops.giadau);
// return false;
	$.ajax({
		url:taaa.appdomain + '/Ajaxdaugia',
		type:'post',
		data:{idpd:ops.idpd, iduser:ops.iduser, giadau:ops.giadau},
		success:function(data){
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

function KiemTraDangNhap()
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
				//ThongBao("Bạn đã đăng nhập",1500);
				ThongBaoDauGia();
			}
		}
	});		
}
function HienFormDangNhap()
{
	$('#bg_thongbao').show();
	$('#thongbao').show();
	$('#thongbao').html("<p class='title_tb'>Đăng Nhập</p><div class='content_tb'><table class='login'><tr><td colspan='2'><span class='thongbaologin'>Bạn cần đăng nhập trước khi đấu giá</span></td></tr><tr><td width='115'>Tên Đăng Nhập</td><td><input class='inputstyle' type='text' id='username' name='username'/></td></tr><tr><td>Mật Khẩu</td><td><input class='inputstyle' type='password' id='password' name='password'/></td></tr><tr><td><a href='javascript:;' class='btnregister'>Đăng Ký</a></td><td><input class='inputstyle2' type='button' name='btnlogin' value='Đăng Nhập' onclick=\"DangNhap({username:document.getElementById('username').value, password:document.getElementById('password').value, IdUserFB:document.getElementById('IdUserFB').value})\"/></td></tr><tr><td colspan='2'><span class='loidangnhap'></span></td></tr></table></div>");
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
				$('li.username').html("<a href='javascript:;'>"+ obj.data[0]["hoten"] +"</a><ul><li><a class='menudangxuat' href='javascript:;'>Đăng Xuất</a></li></ul>");
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
			
			if(obj.IdUserFB==1)
			{
				$('span.loidangky').html("Tài khoản Facebook của bạn đã được đăng ký");
				return false;
			}
			if(obj.username==1)
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


