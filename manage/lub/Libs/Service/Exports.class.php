<?php
// +----------------------------------------------------------------------
// | LubTMP 报表导出
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>2014-12-19
// +----------------------------------------------------------------------
namespace Libs\Service;
class Exports{
	//导出数据方法
    protected function goods_export($goods_list=array())
    {
        //print_r($goods_list);exit;
        $goods_list = $goods_list;
        $data = array();
        foreach ($goods_list as $k=>$goods_info){
            $data[$k][id] = $goods_info['id'];
            $data[$k][title] = $goods_info['title'];
            $data[$k][PNO] = $goods_info['PNO'];
            $data[$k][old_PNO] = $goods_info['old_PNO'];
            $data[$k][price]  = $goods_info['price'];
            $data[$k][brand_id]  = get_title('brand',$goods_info['brand_id']);
            $data[$k][category_id]  = get_title('category',$goods_info['category_id']);
            $data[$k][type_ids] = get_type_title($goods_info['id']);
            $data[$k][add_time] = $goods_info['add_time'];
        }

        //print_r($goods_list);
        //print_r($data);exit;

        foreach ($data as $field=>$v){
            if($field == 'id'){
                $headArr[]='产品ID';
            }

            if($field == 'title'){
                $headArr[]='产品名称';
            }

            if($field == 'PNO'){
                $headArr[]='零件号';
            }

            if($field == 'old_PNO'){
                $headArr[]='原厂参考零件号';
            }

            if($field == 'price'){
                $headArr[]='原厂参考面价';
            }

            if($field == 'type_ids'){
                $headArr[]='品牌';
            }

            if($field == 'brand_id'){
                $headArr[]='类别';
            }
            if($field == 'category_id'){
                $headArr[]='适用机型';
            }

            if($field == 'add_time'){
                $headArr[]='添加时间';
            }
        }

        $filename="goods_list";

        $this->getExcel($filename,$headArr,$data);
    }
	/**
	 * 一般导出导出方法
	 * Enter description here ...
	 * @param $fileName 导出文件名称
	 * @param $headArr 列表标题
	 * @param $data 表格数据
	 */
	function getExcelss($fileName,$headArr,$data){
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Libs.Org.PHPExcel");
        import("Libs.Org.PHPExcel.Writer.Excel5");
        import("Libs.Org.PHPExcel.IOFactory.php");
		
        $date = date("Y_m_d",time());
        $fileName .= "_{$date}.xls";

        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        $objProps = $objPHPExcel->getProperties();

        //设置表头
        $key = ord("A");
        //print_r($headArr);exit;
        foreach($headArr as $v){
            $colum = chr($key);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $key += 1;
        }

        $column = 2;
        $objActSheet = $objPHPExcel->getActiveSheet();

        //print_r($data);exit;
        foreach($data as $key => $rows){ //行写入
            $span = ord("A");
            foreach($rows as $keyName=>$value){// 列写入
                $j = chr($span);
                $objActSheet->setCellValue($j.$column, $value);
                $span++;
            }
            $column++;
        }

        $fileName = iconv("utf-8", "gb2312", $fileName);
        //重命名表
        //$objPHPExcel->getActiveSheet()->setTitle('test');
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        exit;
    }
    /**
     * 一般导出导出方法
     * Enter description here ...
     * @param $fileName 导出文件名称
     * @param $headArr 列表标题
     * @param $data 表格数据
     */
    function getExcel($fileName,$headArr,$data){
        Vendor('PHPExcel.PHPExcel');
        $date = date("Y_m_d");
        $fileName .= "_{$date}.xls";
        //创建PHPExcel对象，注意，不能少了\ 新建一个execl
        $objPHPExcel = new \PHPExcel();
        //获取当前活动sheet操作对象
        $objSheet = $objPHPExcel->getActiveSheet();
        //给当前sheet命名
        $objSheet->setTitle($fileName);
        //设置表头
        $key = ord("A");
        foreach($headArr as $v){
            $colum = chr($key);
            $objSheet->setCellValue($colum.'1', $v);
            $objSheet ->setCellValue($colum.'1', $v);
            $key += 1;
        }

        $column = 2;
        foreach($data as $key => $rows){ //行写入
            $span = ord("A");
            foreach($rows as $keyName=>$value){// 列写入
                $j = chr($span);
                $objSheet->setCellValue($j.$column, $value);
                $span++;
            }
            $column++;
        }
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        exit;
    }
    /*
    *按模板导出
    *@param $type int 报表类型
    */
    function templateExecl($data,$templateName,$type = null){
        
        Vendor('PHPExcel.PHPExcel');
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $temExcel= $objReader->load(SITE_PATH.'d/execl/'.$templateName.".xls");
        //获取当前活动的表
        $objActSheet = $temExcel->getActiveSheet();
        $a = 'A';$b = 'B';$c = 'C';$d = 'D';$e = 'E';$f = 'F';$g = 'G';$h = 'H';$i = 'I';$j = 'J';
        switch ($type) {
            case '1':
                /* excel文件内容 */
                $zz = 4;
                $objActSheet->setCellValue ('B2', $data['starttime'] );
                $objActSheet->setCellValue ('E2', userName($data['user_id'],1));
                $objActSheet->setCellValue ('J2', date('Y-m-d H:s',$data['createtime']));
                
                $info = unserialize($data['info']);
                foreach ($info as $ke=>$ve){
                    $plan_name = planShows($ke,1);
                    $objActSheet->setCellValue ($h.$zz, $ve['money']);
                    $objActSheet->setCellValue ($i.$zz, $ve['moneys']);
                    $objActSheet->setCellValue ($j.$zz, $ve['number']);
                    foreach ($ve as $k=>$da){
                        if(!empty($da['priceid'])){
                            $ticketname = ticketName($da['priceid'],1);
                            $objActSheet->setCellValue ($a.$zz, $plan_name);
                            $objActSheet->setCellValue ($b.$zz, $ticketname);
                            $objActSheet->setCellValue ($c.$zz, $da['number'] ); 
                            $objActSheet->setCellValue ($d.$zz, $da['price'] ); 
                            $objActSheet->setCellValue ($e.$zz, $da['discount'] );
                            $objActSheet->setCellValue ($f.$zz, $da['money'] );
                            $objActSheet->setCellValue ($g.$zz, $da['moneys'] );
                            $zz=$zz+1;
                        }
                    }
                    $zz=$zz+1;
                }
                $filename = "Lubtoday_user_".time();
                break;
            case '2':
                
                $objActSheet->setTitle ('景区日报表');
                $objActSheet->setCellValue ('A1', $data['title'] );
                /* excel文件内容 */
                $zz = 4;
                $objActSheet->setCellValue ('B3', product_name($data['product_id'],1) );
                $objActSheet->setCellValue ('F3', $data['starttime'] );
                $objActSheet->setCellValue ('J3', date('Y-m-d H:s',$data['createtime']));
                $info = unserialize($data['info']);
                foreach ($info as $ke=>$ve){
                    $plan_name = planShows($ke,1);
                    $objActSheet->setCellValue ($h.$zz, $ve['money']);
                    $objActSheet->setCellValue ($i.$zz, $ve['moneys']);
                    $objActSheet->setCellValue ($j.$zz, $ve['number']);
                    foreach ($ve as $k=>$da){
                        if(!empty($da['priceid'])){
                            $ticketname = ticketName($da['priceid'],1);
                            $objActSheet->setCellValue ($a.$zz, $plan_name);
                            $objActSheet->setCellValue ($b.$zz, $ticketname);
                            $objActSheet->setCellValue ($c.$zz, $da['number'] ); 
                            $objActSheet->setCellValue ($d.$zz, $da['price'] ); 
                            $objActSheet->setCellValue ($e.$zz, $da['discount'] );
                            $objActSheet->setCellValue ($f.$zz, $da['money'] );
                            $objActSheet->setCellValue ($g.$zz, $da['moneys'] );
                            $zz=$zz+1;
                        }
                    }
                    $zz=$zz+1;
                }
                $filename = "Lubtoday_scenic_".time();
                break;
            case '4':
                /* excel文件内容 */
                $zz = 4;
                $objActSheet->setCellValue ('B2', $data['starttime'] );
                $objActSheet->setCellValue ('E2', userName($data['user_id'],1));
                $objActSheet->setCellValue ('J2', date('Y-m-d H:s',$data['createtime']));
                
                $info = unserialize($data['info']);
                dump($info);
                foreach ($info as $ke=>$ve){
                    $plan_name = planShows($ke,1);
                    $objActSheet->setCellValue ($h.$zz, $ve['money']);
                    $objActSheet->setCellValue ($i.$zz, $ve['moneys']);
                    $objActSheet->setCellValue ($j.$zz, $ve['number']);
                    foreach ($ve as $k=>$da){
                        if(!empty($da['priceid'])){
                            $ticketname = ticketName($da['priceid'],1);
                            $objActSheet->setCellValue ($a.$zz, $plan_name);
                            $objActSheet->setCellValue ($b.$zz, $ticketname);
                            $objActSheet->setCellValue ($c.$zz, $da['number'] ); 
                            $objActSheet->setCellValue ($d.$zz, $da['price'] ); 
                            $objActSheet->setCellValue ($e.$zz, $da['discount'] );
                            $objActSheet->setCellValue ($f.$zz, $da['money'] );
                            $objActSheet->setCellValue ($g.$zz, $da['moneys'] );
                            $zz=$zz+1;
                        }
                    }
                    $zz=$zz+1;
                }
                $filename = "Lubtoday_user_".time();
                break;
            case '7':
                /* excel文件内容 */
                $zz = 4;
                $objActSheet->setCellValue ('A2', $data['starttime'] );
                $objActSheet->setCellValue ('C2', date('Y-m-d H:s',$data['createtime']));
                $info = unserialize($data['info']);
                foreach ($info as $ke=>$ve){
                    $objActSheet->setCellValue ($a.$zz, $ve['name']);
                    $objActSheet->setCellValue ($b.$zz, $ve['money']);
                    $zz=$zz+1;
                }
                $filename = "Lubtoday_credit_".time();
                break;
            default:
                # code...
                break;
        }
        
            
        header('Content-Type: application/vnd.ms-excel' );
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"' );
        header('Cache-Control: max-age=0' );
        $objWriter = \PHPExcel_IOFactory::createWriter ($temExcel, 'Excel5' );
        $objWriter->save ('php://output');
    }
	
}