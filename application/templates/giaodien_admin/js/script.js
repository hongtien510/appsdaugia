$(document).ready(function(){
	
	if(getParameterValue('result') == 1)
		ThongBao("Thêm mới thành công",2000);
	if(getParameterValue('result') == 2)
		ThongBao("Chỉnh sửa thành công",2000);
	if(getParameterValue('result') == 3)
		ThongBao("Xóa thành công",2000);
        
  
    $('.dangxuatadmin').click(function(){
        
        $.ajax({
		url:taaa.appdomain + '/admin/loginadmin/xulydangxuat',
		type:'post',
		data:{},
		success:function(data){
            alert("Đăng xuất thành công");
            window.location= taaa.appdomain + '/admin/loginadmin';
		}
	   });	
    });
});

function LoginAdmin(ops)
{
    UserAdmin = ops.useradmin;
    PassAdmin = ops.passadmin;
    
    //alert(UserAdmin);
    //alert(PassAdmin);
    
    $.ajax({
		url:taaa.appdomain + '/admin/loginadmin/xulylogin',
		type:'post',
		data:{useradmin: UserAdmin, passadmin:PassAdmin},
		success:function(data){
			if(data==1)
            {
                alert("Đăng nhập thành công");
                window.location= taaa.appdomain + '/admin';
            }
            else
                alert("Đăng nhập không thành công");
		}
	});
	
}

function getParameterValue(name)
{
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( window.location.href );
	if( results == null ) return "";
	else return results[1];
}


function ThongBao(nd,time)
{
	$('#bg_thongbao').show();
	$('#thongbao').show();
	$('#thongbao').html("<p class='title_tb'>Thông Báo</p><div class='content_tb'>"+nd+"</div>");
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

function ThongBaoDongY(nd, link)
{
    $('#bg_thongbao').show();
	$('#thongbao').show(); 
	$('#thongbao').html("<p class='title_tb'>Thông Báo</p><div class='content_tb'><p>" +nd+ "</p><p class='dong_thongbao' onclick=\"CloseThongBaoDongY('"+link+"')\">Đóng</p>");
}

function CloseThongBaoDongY(link)
{
	$('#thongbao').hide(); 
	$('#bg_thongbao').hide();
	//window.location = link;
	top.location.href = link;
}


function ThongBaoTuChuyenTrang(nd, time, link)
{
	$('#bg_thongbao').show();
	$('#thongbao').show();
	$('#thongbao').html("<p class='title_tb'>Thông Báo</p><div class='content_tb'>"+nd+"</div>");
	/*myVar = setTimeout(function(){
		top.location.href = link;
		return false
	},time);*/
}


function customerLoadWindow(pageURL, title,w,h) {
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}

function ChangeListPage(idpage)
{
	if(idpage != 0)
		window.location = "?idpage="+idpage;
}

