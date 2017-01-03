<?php if (!defined('LUB_VERSION')) exit(); ?>

<div class="bjui-pageHeader">
<Managetemplate file="Common/Nav"/>
<form id="pagerForm" data-toggle="ajaxsearch" action="{:U('Manage/Logs/loginlog',array('menuid'=>$menuid));}" method="post">
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
    
    <label>&nbsp;状态:</label>
    <select name="status" data-toggle="selectpicker">
        <option value="">全部</option>
        <option value="0" <if condition="$status eq '0'">selected</if>>失败</option>
        <option value="1" <if condition="$status eq '1'">selected</if>>成功</option>
    </select>
    &nbsp;
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
        <th width="80">ID</th>
        <th align="center">通道</th>
        <th align="center">类型</th>
        <th align="center">检票时间</th>
        <th align="center">状态</th>
        <th align="center">请求数据</th>
        <th align="center">返回数据</th>
      </tr>
    </thead>
    <tbody>
    <volist name="data" id="vo">
      <tr data-id="{$vo.id}">
        <td>{$vo.id}</td>
        <td>{$vo.code}</td>
        <td><if condition="$vo.type eq '1'">手持<else />闸机</if></td>
        <td>{$vo['datetime']|date='Y-m-d H:i:s',###}</td>
        <td><if condition="$vo.status eq '1'">成功<else />失败</if></td>
        <td>{$vo.info}</td>
        <td>{$vo.data}</td>
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