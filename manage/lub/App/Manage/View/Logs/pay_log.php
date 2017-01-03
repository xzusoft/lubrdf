<?php if (!defined('LUB_VERSION')) exit(); ?>

<div class="bjui-pageHeader">
<Managetemplate file="Common/Nav"/>
<form id="pagerForm" data-toggle="ajaxsearch" action="{:U('Manage/Logs/pay_log',array('menuid'=>$menuid));}" method="post">
 <!--Page --> 
  <input type="hidden" name="pageSize" value="{$numPerPage}">             
  <input type="hidden" name="pageCurrent" value="{$currentPage}">       
  <input type="hidden" name="orderField" value="${param.orderField}">         
  <input type="hidden" name="orderDirection" value="${param.orderDirection}">

<!--Page end-->
<!--条件检索 s-->
  <div class="bjui-searchBar">
    <label>日期:</label>
    <input type="text" size="11" name="starttime" data-toggle="datepicker" value="{$starttime}">
    <label>至</label>
    <input type="text" size="11" name="endtime" data-toggle="datepicker"  value="{$endtime}">
    &nbsp;
    <label>&nbsp;类型:</label>
    <select name="status" data-toggle="selectpicker">
        <option value="">全部</option>
        <option value="0" <if condition="$where['status'] eq '0'">selected</if>>待支付</option>
        <option value="1" <if condition="$where['status'] eq '1'">selected</if>>支付完成</option>
    </select>
    <input type="text" value="{$where['sn']}" name="sn" class="form-control" size="10" placeholder="单号">&nbsp;
    <button type="submit" class="btn-default" data-icon="search">查询</button>&nbsp;
    <a class="btn btn-orange" href="javascript:;" data-toggle="reloadsearch" data-clear-query="true" data-icon="undo">清空查询</a>
  </div>
  <!--检索条件 e-->
  </form>
</div>
<div class="bjui-pageContent tableContent">
  <table data-toggle="tablefixed" data-width="100%" data-nowrap="true">
    <thead>
      <tr>
        <th>ID</th>
        <th>订单号</th>
        <th align="center">网银单号</th>
        <th align="center">金额</th>
        <th align="center">创建时间</th>
        <th align="center">更新时间</th>
        <th>状态</th>
      </tr>
    </thead>
    <tbody>
    <volist name="data" id="vo">
      <tr data-id="{$vo.id}">
        <td>{$vo.id}</td>
        <td><a title="订单详情" target="dialog" href="{:U('Item/Work/orderinfo',array('sn'=>$vo['order_sn']))}" width="900" height="600">{$vo.order_sn}</a></td>
        <td>{$vo['out_trade_no']}</td>
        <td>{$vo.money}</td>
        <td>{$vo.create_time|date="Y-m-d H:i:s",###}</td>
        <td>{$vo.update_time|date="Y-m-d H:i:s",###}</td>
        <td><if condition="$vo['status'] eq '1'">支付完成<else />待支付</if></td>
       </tr>
    </volist>
     
    </tbody>
  </table>
</div>
<div class="bjui-pageFooter">
  <div class="pages">
    <span>共 {$totalCount} 条</span>
  </div>
  <div class="pagination-box" data-toggle="pagination" data-total="{$totalCount}" data-page-size="{$numPerPage}" data-page-current="{$currentPage}"> </div>
</div>