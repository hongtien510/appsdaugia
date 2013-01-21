$(document).ready(function(){
	
	if(getParameterValue('result') == 1)
		ThongBao("Thêm mới thành công",2000);
	if(getParameterValue('result') == 2)
		ThongBao("Chỉnh sửa thành công",2000);
	if(getParameterValue('result') == 3)
		ThongBao("Xóa thành công",2000);
        
  //
//    $('.btLoginAdmin').click(function(){
//        
//        //alert(taaa.appdomain);//http://localhost/appfb/ishalidaugia
//        $.ajax({
//			url:taaa.appdomain + '/admin/loginadmin/xulylogin',
//			type:'post',
//			data:{},
//			success:function(data){
//				ThongBao("B?n dã dang xu?t kh?i ?ng d?ng",1500);
//				$('li.username').html("<a class='menudangnhap' href='javascript:;'>Ðang Nh?p</a>");
//			}
//		});	
//        
//    });
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
                window.location="../admin/";
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