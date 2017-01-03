<?php if (!defined('LUB_VERSION')) exit(); ?>
<div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="{:U('Manage/Index/user',array('type'=>$type,'ifadd'=>$ifadd));}" method="post">
        <input type="hidden" name="pageCurrent" value="{$currentPage}" />
        <input type="hidden" name="pageSize" value="{$numPerPage}" />
        <input type="hidden" name="ifadd" value="{$ifadd}" />
        <div class="bjui-searchBar">
            <label>名称：</label><input type="text" value="" name="name" size="10" />&nbsp;
            <button type="submit" class="btn-default" data-icon="search">查询</button>&nbsp;
            <a class="btn btn-orange" href="javascript:;" data-toggle="reloadsearch" data-clear-query="true" data-icon="undo">清空查询</a>&nbsp;
            <if condition="$ifadd eq '1'">
            <div class="pull-right">
                <input type="checkbox" name="lookupType" value="1" data-toggle="icheck" data-label="追加">
                <button type="button" class="btn-blue" data-toggle="lookupback" data-lookupid="ids" data-warn="请至少选择一条数据" data-icon="check-square-o">选择选中</button>
            </div>
            </if>
        </div>
    </form>
</div>
<div class="bjui-pageContent tableContent">
<if condition="$ifadd eq '1'">
    <table class="table table-bordered" data-toggle="tablefixed" data-width="100%">
        <thead>
            <tr>
                <th width="25">No.</th>
                <th>名称</th>
                <th>描述</th>
                <th width="28"><input type="checkbox" class="checkboxCtrl" data-group="ids" data-toggle="icheck"></th>
                <th width="74" align="center">操作</th>
            </tr>
        </thead>
        <tbody>
            <volist name="data" id="vo">
                <tr>
                    <td>{$i}</td>
                    <td>{$vo.nickname}</td>
                    <td></td>
                    <td><input type="checkbox" name="ids" data-toggle="icheck" value="{id:'{$vo.id}', name:'{$vo.nickname}'}"></td>
                    <td align="center"><a href="javascript:;" data-toggle="lookupback" data-args="{id:'{$vo.id}', name:'{$vo.nickname}'}" class="btn btn-blue" title="选择本项" data-icon="check">选择</a></td>
                </tr>               
            </volist>
        </tbody>
    </table>
    <else />
    <table class="table table-bordered" data-toggle="tablefixed" data-width="100%">
        <thead>
            <tr>
                <th width="25">No.</th>
                <th>名称</th>
                <th>描述</th>
                <th width="74" align="center">操作</th>
            </tr>
        </thead>
        <tbody>
            <volist name="data" id="vo">
                <tr>
                    <td>{$i}</td>
                    <td>{$vo.nickname}</td>
                    <td></td>
                    <td align="center"><a href="javascript:;" data-toggle="lookupback" data-args="{id:'{$vo.id}', name:'{$vo.nickname}'}" class="btn btn-blue" title="选择本项" data-icon="check">选择</a></td>
                </tr>               
            </volist>
        </tbody>
    </table>
    </if>
</div>
<div class="bjui-pageFooter">
  <div class="pages"> <span>共 {$totalCount} 条</span> </div>
  <div class="pagination-box" data-toggle="pagination" data-total="{$totalCount}" data-page-size="{$numPerPage}" data-page-current="{$currentPage}"> </div>
</div>