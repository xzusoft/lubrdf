<?php if (!defined('LUB_VERSION')) exit(); ?>

<div class="bjui-pageHeader">
<Managetemplate file="Common/Nav"/>
<form id="pagerForm" data-toggle="ajaxsearch" action="{:U('Manage/Logs/refundlog',array('menuid'=>$menuid));}" method="post">
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
    <label>&nbsp;状态:</label>
    <select name="status" data-toggle="selectpicker">
        <option value="">全部</option>
        <option value="2" <if condition="$where['status'] eq '2'">selected</if>>申请成功</option>
        <option value="1" <if condition="$where['status'] eq '1'">selected</if>>退票成功</option>
        <option value="0" <if condition="$where['status'] eq '0'">selected</if>>退票驳回</option>
    </select>
    <input type="hidden" name="user.id" value="">
    <input type="text" name="user.name" disabled value="" size="10" data-toggle="lookup" data-url="{:U('Manage/Index/user');}" data-group="user" data-width="600" data-height="445" data-title="操作员" placeholder="操作员">
    &nbsp;
    <input type="hidden" name="plan.id" value="">
    <input type="text" name="plan.name" disabled value="" size="17" data-toggle="lookup" data-url="{:U('Manage/Index/date_plan');}" data-group="plan" data-width="600" data-height="445" data-title="销售计划(场次)" placeholder="销售计划(场次)">
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
        <th align="center">ID</th>
        <th align="center">申请人</th>
        <th align="center">订单号</th>
        <th align="center">创建场景</th>
        <th align="center">所属场次</th>
        <th align="center">退票时间</th>
        <th align="center">退还金额</th>
        <th align="center">手续费</th>
        <th align="center">说明</td>
        <th align="center">操作员</th>
        <th align="center">状态</th>
      </tr>
    </thead>
    <tbody>
    <volist name="data" id="vo">
      <tr data-id="{$vo.id}">
            <td align="center">{$vo.id}</td>
            <td align="center">{$vo.applicant|userName}</td>
            <td align="center">{$vo.order_sn}</td>
            <td><if condition="$vo['launch'] eq '1'">窗口<else/>渠道商</if></td>
            <td>{$vo.plan_id|planShows}</td>
            <td align="center">{$vo.updatetime|date="Y-m-d H:i:s",###}</td>
            <td align="right">{$vo.re_money}</td>
            <td align="right">{$vo.poundage|format_money}</td>
            <td align="center">{$vo.reason}</td>
            <td align="center">{$vo.user_id|userName}</td>
            <td align="center"><if condition="$vo['status'] eq '1'">申请成功<elseif condition="$vo['status'] eq '2'"/>驳回<else/>退票成功</if></td>
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