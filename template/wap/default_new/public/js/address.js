function saveAddress() {
	if (!Check_Consignee()) {
		return false;
	}
	var province = $("#detailed_province").val();
	var city = $("#detailed_city").val();
	var country = $("#selCountry").val();
	var name=$("#Name").val();
	var mobile=$("#Moblie").val();
	var address=$("#AddressInfo").val();
	var address_id=$("#adressid").val();
	var data_json='',ajax_url='';
	var phone = $("#phone").val();
	var zipcode = $("#zipcode").val();
	var id = $("#hidden_id").val();
	var bargain_id = $("#hidden_bargain_id").val();
	
	if(typeof(address_id)=='undefined'){
		data_json = {"consigner":name,"mobile":mobile,"province":province,"city":city,"country":country,"address":address,"phone":phone,"zipcode":zipcode};
		ajax_url = __URL(APPMAIN+"/member/addmemberaddress");
	}else{
		data_json = {"id":address_id,"consigner":name,"mobile":mobile,"province":province,"city":city,"country":country,"address":address,"phone":phone,"zipcode":zipcode};
		ajax_url = __URL(APPMAIN+"/member/updatememberaddress");
	}
	var flag = $("#hidden_flag").val();
	var ref_url = $("#ref_url").val();
	$.ajax({
		type: "post",
		url: ajax_url,
		data: data_json,
		success: function (txt) {
			if (txt["code"] >0) {
				if(flag == 1){
					location.href=__URL(APPMAIN+"/member/memberaddress?flag=1");
				}else if(flag == 4){
					location.href=__URL(APPMAIN+"/PintuanOrder/paymentorder");
				}else if(flag == 2){
					location.href=__URL(APPMAIN+"/member/toReceiveThePrize");
				}else if(flag == 9){
					location.href=__URL(APPMAIN+"/goods/goodsdetail?id="+id+"&bargain_id="+bargain_id);
				}else{
					if(ref_url != ''){
						location.href=__URL(APPMAIN+"/order/paymentorder");
					}
				}
			} else {
				showBox(txt,"error");
			}
		}
	});
}

function Check_Consignee() {
	var reg = /^[0-9]*$/;
	if ($("#Name").val() == "") {
		showBox("姓名不能为空","warning");
		$("#Name").focus();
		return false;
	} 
	if ($("#Moblie").val() == "") {
		showBox("手机号码不能为空","warning");
		$("#Moblie").focus();
		return false;
	} 
	if (!reg.test($("#Moblie").val())) {
		showBox("请输入正确的手机号码","warning");
		$("#Moblie").focus();
		return false;
	} 
	
	var phone = $("#phone").val();
	if(phone.length > 0){
		var pattern=/(^[0-9]{3,4}\-[0-9]{3,8}$)|(^[0-9]{3,8}$)|(^\([0-9]{3,4}\)[0-9]{3,8}$)|(^0{0,1}13[0-9]{9}$)/; 
		if(!pattern.test(phone)) { 
			showBox("请输入正确的固定电话","warning");
			$("#phone").focus();
			return false; 
		} 
	}
	
	if ($("#selCountry").val() == 0) {
		showBox("请选择国家","warning");
		$("#selCountry").focus();
		return false;
	}

    if ($("#detailed_province").val() == ''){
        showBox("省份不能为空","warning");
        $("#detailed_province").focus();
        return false;
    }

	if($("#detailed_city").val() == ''){
        showBox("城市不能为空","warning");
        $("#detailed_city").focus();
        return false;
	}
	
	if ($("#AddressInfo").val() == "") {
		showBox("详细地址不能为空","warning");
		$("#AddressInfo").focus();
		return false;
	}

    if ($("#selCountry option:selected").text() != '爱尔兰')
    {
        if($("#zipcode").val() == ''){
            $("#zipcode").focus();
            showBox("请填写邮编","warning");
            return false;
        }
    }
	
	return true;
}
