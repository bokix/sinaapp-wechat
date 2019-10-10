<%@ page language="java" contentType="text/html; charset=utf-8"
	pageEncoding="utf-8"%>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>DC</title>
<%@ include file="head.jsp" %>
<%
String userName = (String)request.getAttribute("userName");
String companyId = (String)request.getAttribute("companyId");
String msg = (String) request.getAttribute("msg");
if(msg==null){
	msg = "系统错误";
}

%>
</head>
<body>
<div data-role="page" data-title="error">
		<div data-role="header" data-theme="b" >
		<a href="javascript:back2MyOrder()" data-mini="true" data-corners="false" class="ui-btn-left">我的订单</a>
		<h1></h1>
		<a href="javascript:showItems()" data-mini="true" data-corners="false"class="ui-btn-right">查看菜单</a>
		</div>
<script>
	function back2MyOrder(){
		//$.mobile.changePage( "dc",{data :{t:"list",companyId:"<%=companyId%>",userName:"<%=userName%>"},type:"post"});
		$.mobile.navigate( "dc?t=list&companyId=<%=companyId%>&userName=<%=userName%>");
	}
	function showItems(){
		//$.mobile.changePage( "dc",{data :{t:"showItems",companyId:"<%=companyId%>",userName:"<%=userName%>"},type:"post"});
		$.mobile.navigate( "dc?t=showItems&companyId=<%=companyId%>&userName=<%=userName%>");
	}
</script>
<div data-role="content">
<h3>出错了！</h3>
<p>
<%=msg %>
</p>
</div>
</div>	

</body>
</html>