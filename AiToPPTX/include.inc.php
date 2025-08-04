<?php
/*
* 基础架构: 单点低代码开发平台 & AiToPPTX
* 版权所有: 郑州单点科技软件有限公司
* Email: moodle360@qq.com
* Copyright (c) 2024
* License: GPL V3 or Commercial license
* Version: 0.0.1
*/
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE & ~E_WARNING); 

header("Content-Type: application/json; charset=utf-8");

require_once(__DIR__.'/lib/functions.inc.php');
require_once(__DIR__.'/lib/AiToPptx_DrawGroupObject.php');
require_once(__DIR__.'/lib/AiToPptx_DrawSingleObject.php');
require_once(__DIR__.'/lib/AiToPptx_MakeContentTypesXml.php');
require_once(__DIR__.'/lib/AiToPptx_MakeMasterXml.php');
require_once(__DIR__.'/lib/AiToPptx_MakePresentationXml.php');
require_once(__DIR__.'/lib/AiToPptx_MakePresentationXmlRelations.php');
require_once(__DIR__.'/lib/AiToPptx_MakeRootRelations.php');
require_once(__DIR__.'/lib/AiToPptx_MakeSingleSlide.php');
require_once(__DIR__.'/lib/AiToPptx_MakeSlideLayout.php');
require_once(__DIR__.'/lib/AiToPptx_MakeThemeXml.php');

// 主要功能文件
//把JSON数据转换为PPTX文件
/**
 * Summary of AiToPptx_MakePptx
 * @param mixed $JsonData: 包含PPT结构和内容的JSON数据
 * @param mixed $TargetCacheDir
 * @param mixed $TargetPptxFilePath
 * @return void
 */
function AiToPptx_MakePptx($JsonData, $TargetCacheDir, $TargetPptxFilePath) {

  global $GlobalImageCounter;
  $GlobalImageCounter            = 50;

  if(!is_dir($TargetCacheDir))   mkdir($TargetCacheDir);
  $TargetCacheDir   = realpath($TargetCacheDir);

  /**
   * 创建标准pptx目录结构
   *  ├── [Content_Types].xml          # 定义所有内容类型和文件扩展名映射
   *  ├── _rels/                       # 包级关系文件夹
   *  │   └── .rels                    # 根关系文件，定义核心文档关系
   *  ├── docProps/                    # 文档属性文件夹
   *  │   ├── app.xml                  # 应用程序特定属性√
   *  │   └── core.xml                 # 核心文档属性（标题、作者、创建时间等）√
   *  └── ppt/                         # 演示文稿主要内容文件夹
   *      ├── presentation.xml         # 演示文稿主文件，定义幻灯片顺序和全局设置
   *      ├── presProps.xml           # 演示文稿属性√
   *      ├── tableStyles.xml         # 表格样式定义√
   *      ├── viewProps.xml           # 视图属性设置√
   *      ├── _rels/                  # 演示文稿关系文件夹
   *      │   └── presentation.xml.rels # 演示文稿关系文件
   *      ├── theme/                  # 主题相关文件夹√
   *      │   ├── theme1.xml          # 主题定义文件
   *      │   └── _rels/              # 主题关系文件夹
   *      │       └── theme1.xml.rels # 主题关系文件
   *      ├── slides/                 # 幻灯片内容文件夹
   *      │   ├── slide1.xml          # 第1张幻灯片内容
   *      │   ├── slide2.xml          # 第2张幻灯片内容
   *      │   ├── slideN.xml          # 第N张幻灯片内容
   *      │   └── _rels/              # 幻灯片关系文件夹
   *      │       ├── slide1.xml.rels # 第1张幻灯片关系
   *      │       ├── slide2.xml.rels # 第2张幻灯片关系
   *      │       └── slideN.xml.rels # 第N张幻灯片关系
   *      ├── slideLayouts/           # 幻灯片版式文件夹
   *      │   ├── slideLayout1.xml    # 版式1定义
   *      │   ├── slideLayout2.xml    # 版式2定义
   *      │   ├── slideLayoutN.xml    # 版式N定义
   *      │   └── _rels/              # 版式关系文件夹
   *      │       ├── slideLayout1.xml.rels # 版式1关系
   *      │       ├── slideLayout2.xml.rels # 版式2关系
   *      │       └── slideLayoutN.xml.rels # 版式N关系
   *      ├── slideMasters/           # 幻灯片母版文件夹
   *      │   ├── slideMaster1.xml    # 母版1定义
   *      │   └── _rels/              # 母版关系文件夹
   *      │       └── slideMaster1.xml.rels # 母版1关系
   *      └── media/                  # 嵌入媒体文件夹
   *          ├── image1.png          # 图片文件1
   *          ├── image2.jpg          # 图片文件2
   *          └── imageN.ext          # 其他媒体文件
   */
	// 确保子文件夹都存在
	if(!is_dir($TargetCacheDir."/_rels")) 		mkdir($TargetCacheDir."/_rels");
	if(!is_dir($TargetCacheDir."/docProps")) 	mkdir($TargetCacheDir."/docProps");
	if(!is_dir($TargetCacheDir."/ppt")) 		  mkdir($TargetCacheDir."/ppt");
	if(!is_dir($TargetCacheDir."/ppt/_rels")) 	mkdir($TargetCacheDir."/ppt/_rels");
	if(!is_dir($TargetCacheDir."/ppt/media")) 	mkdir($TargetCacheDir."/ppt/media");
	if(!is_dir($TargetCacheDir."/ppt/theme")) 	mkdir($TargetCacheDir."/ppt/theme");
	if(!is_dir($TargetCacheDir."/ppt/slideLayouts")) 	mkdir($TargetCacheDir."/ppt/slideLayouts");
	if(!is_dir($TargetCacheDir."/ppt/slideMasters")) 	mkdir($TargetCacheDir."/ppt/slideMasters");
	if(!is_dir($TargetCacheDir."/ppt/slides")) 			mkdir($TargetCacheDir."/ppt/slides");
	if(!is_dir($TargetCacheDir."/ppt/theme/_rels")) 	mkdir($TargetCacheDir."/ppt/theme/_rels");
	if(!is_dir($TargetCacheDir."/ppt/slideLayouts/_rels")) 	mkdir($TargetCacheDir."/ppt/slideLayouts/_rels");
	if(!is_dir($TargetCacheDir."/ppt/slideMasters/_rels")) 	mkdir($TargetCacheDir."/ppt/slideMasters/_rels");
	if(!is_dir($TargetCacheDir."/ppt/slides/_rels")) 		mkdir($TargetCacheDir."/ppt/slides/_rels");
	if(!is_dir($TargetCacheDir."/ppt/theme/_rels")) 		mkdir($TargetCacheDir."/ppt/theme/_rels");

	// 生成每个Slide页面
	$pages = $JsonData['pages'];
	for($i=0;$i<sizeof($pages);$i++) {
		$FilePath 			  = $TargetCacheDir."/ppt/slides/slide".($i+1).".xml";
		$RelationPath 		= $TargetCacheDir."/ppt/slides/_rels/slide".($i+1).".xml.rels";
		AiToPptx_MakeSingleSlide($JsonData['pages'][$i], $FilePath, $RelationPath);
	}

	//生成slideMaster页面,也有可能会有多个页面
	$slideMasters 		= $JsonData['slideMasters'];
	$MakeMasterXmlData 	= AiToPptx_MakeMasterXml($JsonData['slideMasters'], $TargetCacheDir);

	// 生成theme页面,也有可能会有多个页面
	$slideMasters 		= $JsonData['slideMasters'];
	$MakeThemeXmlData 	= AiToPptx_MakeThemeXml($JsonData['slideMasters'], $TargetCacheDir);

	// 生成slideLayouts页面
	$slideLayouts = (array)$JsonData['slideMasters'][0]['slideLayouts'];
	for($i=0;$i<sizeof($slideLayouts);$i++) {
		$MakeSlideLayoutData = AiToPptx_MakeSlideLayout($slideLayouts[$i], $TargetCacheDir."/ppt/slideLayouts/slideLayout".($i+1).".xml", $TargetCacheDir."/ppt/slideLayouts/_rels/slideLayout".($i+1).".xml.rels");
		//print $MakeSlideLayoutData;
	}

	// 生成 /ppt/presentation.xml，演示文稿主文件
	AiToPptx_MakePresentationXml($JsonData, $TargetCacheDir);

	// 生成 /ppt/_rels/presentation.xml.rels，关系文件
	AiToPptx_MakePresentationXmlRelations($JsonData, $TargetCacheDir);

	// 复制必备文件，预先设定
	copy(__DIR__."/xml/presProps.xml", $TargetCacheDir."/ppt/presProps.xml");
	copy(__DIR__."/xml/tableStyles.xml", $TargetCacheDir."/ppt/tableStyles.xml");
	copy(__DIR__."/xml/theme.xml", $TargetCacheDir."/ppt/theme.xml");
	copy(__DIR__."/xml/viewProps.xml", $TargetCacheDir."/ppt/viewProps.xml");
	copy(__DIR__."/xml/app.xml", $TargetCacheDir."/docProps/app.xml");
	copy(__DIR__."/xml/core.xml", $TargetCacheDir."/docProps/core.xml");

	// 生成 /ppt/_rels/presentation.xml.rels，关系文件
	// AiToPptx_MakePresentationXmlRelations($JsonData, $TargetCacheDir);

	// 生成 /_rels/.rels，包级关系文件
	AiToPptx_MakeRootRelations($JsonData, $TargetCacheDir);

	// 生成 /Content_Types.xml，定义所有内容类型
	AiToPptx_MakeContentTypesXml($JsonData, $TargetCacheDir);

	// 压缩所有文件,并且生成PPTX
	AiToPptx_CreateZip($TargetCacheDir, $TargetPptxFilePath);

}

//把Markdown转换为GenerateContent.php接口中最后一步的JSON Data
function Markdown_To_Generate_Content_Json($FullResponeText) {

  //非空处理
  $FullResponeTextArray = explode("\\n", $FullResponeText);
  if(sizeof($FullResponeTextArray)==1)  {
    $FullResponeTextArray = explode("\n", $FullResponeText);
  }
  $FullResponeTextArrayNotNullLine = [];
  foreach($FullResponeTextArray as $Item) {
    if(trim($Item)!="") {
      $FullResponeTextArrayNotNullLine[] = trim($Item);
    }
  }

  //转为MAP
  $Map    = [];
  $PPTX标题 = "";     // 对应markdown的 #
  $章节标题 = "";     // 对应markdown的 ## 
  $小节标题 = "";     // 对应markdown的 ###
  $小节内容 = "";     // 对应 1.1.1 point 内容
  foreach($FullResponeTextArrayNotNullLine as $Item) {
    if(substr($Item, 0, 2) == '# ') {
      $PPTX标题     = $Item;
      //$Map['标题']  = $PPTX标题;
    }
    else if(substr($Item, 0, 3) == '## ') {
      $章节标题 = $Item;
      //$Map['章节'][$章节标题] = $章节标题;
    }
    else if(substr($Item, 0, 4) == '### ') {
      $小节标题 = $Item;
      //$Map['小节'][$章节标题][] = $小节标题;
    }
    else {
      $Map[$PPTX标题][$章节标题][$小节标题][] = $Item;
    }
  }
  //print_R($Map);exit;

  //输出为层级化JSON
  $页面JSON列表 = [];
  foreach($Map[$PPTX标题] as $章节名称 => $章节信息) {
    $章节JSON列表 = [];
    foreach($章节信息 as $小节名称 => $小节列表) {
      //print_R($章节名称);
      //print_R($小节列表);
      $小节JSON列表 = [];
      for($i=0;$i<sizeof($小节列表);$i=$i+2) {
        $小节标题 = $小节列表[$i];
        $小节内容 = $小节列表[$i+1];
        //print_R($小节标题);
        //print_R($小节内容);
        $小节JSON = [];
        $小节JSON['level']      = 4;
        $小节JSON['name']       = $小节标题;
        $小节JSON['children']   = [['children'=>[], 'level'=>0, 'type'=>'-', 'name'=>$小节内容]];
        $小节JSON列表[]        = $小节JSON;
      }
      $章节JSON               = [];
      $章节JSON['level']      = 3;
      $章节JSON['name']       = $小节名称;
      $章节JSON['children']   = $小节JSON列表;
      $章节JSON列表[]         = $章节JSON;
    }
    $二级标题JSON               = [];
    $二级标题JSON['level']      = 2;
    $二级标题JSON['name']       = $章节名称;
    $二级标题JSON['children']   = $章节JSON列表;
    $页面JSON列表[]             = $二级标题JSON;
    //print_R($二级标题JSON);
  }

  $最终结构 = [];
  $最终结构['level']      = 1;
  $最终结构['name']       = $PPTX标题;
  $最终结构['children']   = $页面JSON列表;

  return $最终结构;
}

// 得到单个页面的所有文本，按照坐标位置排序
function 得到单个页面的所有文本($Page) {
	$PageChildren 	= (array)$Page['children'];
	//$Page['children'][0]['children'][0]['children'];
	//$Page['children'][0]['children'][0]['children'][0]['text'] = "PPT标题";
	//$Page['children'][1]['children'][0]['children'][0]['text'] = "汇报人";
	$Page数据信息 = [];
	foreach($PageChildren as $PageChildrenItem)  {
		if($PageChildrenItem['children'][0]['children'][0]['text']!="")  {
			//print_R($PageChildrenItem['children'][0]['children'][0]['text']);
			//除以10表示用于兼容处理细微的布局差异
			$X = intval($PageChildrenItem['point'][0]/5) + 10000;
			$Y = intval($PageChildrenItem['point'][1]/5) + 10000;
			if($PageChildrenItem['children'][0]['children'][0]['text']!="")  {
				$Page数据信息[$X."_".$Y."_".rand(1111,9999)] = $Y."_".$X."____".trim($PageChildrenItem['children'][0]['children'][0]['text']);
			}
		}
		//print $PageChildrenItem['children'][0]['children'][0]['text']."\n";
	}
	ksort($Page数据信息);
	return array_values($Page数据信息);
}

function 替换首页或尾页($指定页面JSON, $PPTX标题, $PPTX作者, $页面页码, $页面标题)  {
  //print_R($指定页面JSON);exit;
  //替换首页信息
  //$Page['children'][0]['children'][0]['children'][0]['text'] = "PPT标题";
	//$Page['children'][1]['children'][0]['children'][0]['text'] = "汇报人";
  $PageChildren 	= (array)$指定页面JSON['children'];
  $Counter        = 0;
	for($i=0;$i<sizeof($PageChildren);$i++) {
		if($PageChildren[$i]['type'] == 'text' && $PageChildren[$i]['children'][0]['children'][0]['text']!="" && $Counter == 0)  {
      $PageChildren[$i]['children'][0]['children'][0]['text'] = $PPTX标题;
      $Counter += 1;
      //print $PageChildrenItem['children'][0]['children'][0]['text']."<BR>";
    }
    else if($PageChildren[$i]['type'] == 'text' && $PageChildren[$i]['children'][0]['children'][0]['text']!="" && $Counter == 1)  {
      $PageChildren[$i]['children'][0]['children'][0]['text'] = $PPTX作者;
      $Counter += 1;
      //print $PageChildrenItem['children'][0]['children'][0]['text']."<BR>";
    }
    //print_R($PageChildren[$i]['children'][0]['children'][0]['text']);
  }
  $指定页面JSON['children'] = $PageChildren;
  $指定页面JSON['title']    = $页面标题;
  $指定页面JSON['page']     = $页面页码;
  //print_R($指定页面JSON);
  return $指定页面JSON;
}

function 替换目录页($指定页面JSON, $目录LIST)  {
  //print_R($指定页面JSON);exit;
  //替换首页信息
  //$Page['children'][0]['children'][0]['children'][0]['text'] = "PPT标题";
	//$Page['children'][1]['children'][0]['children'][0]['text'] = "汇报人";
  $Page数据信息    = [];
  $PageChildren 	= (array)$指定页面JSON['children'];
	for($i=0;$i<sizeof($PageChildren);$i++) {
		if(
      $PageChildren[$i]['type'] == 'text' &&
      $PageChildren[$i]['children'][0]['type']=="p" &&
      $PageChildren[$i]['children'][0]['children'][0]['text']!=""
      )  {
      //$PageChildren[$i]['children'][0]['children'][0]['text'] = $PPTX标题;
      //print $PageChildren[$i]['children'][0]['children'][0]['text']."<BR>";
      //除以10表示用于兼容处理细微的布局差异
			$X = intval($PageChildren[$i]['point'][0]/5) + 10000;
			$Y = intval($PageChildren[$i]['point'][1]/5) + 10000;
			if($PageChildren[$i]['children'][0]['children'][0]['text']!="" && $PageChildren[$i]['children'][0]['children'][0]['text']!="CONTENTS")  {
				$Page数据信息[$Y."_".$X] = ['title'=>trim($PageChildren[$i]['children'][0]['children'][0]['text']), 'id'=>$i];
			}
    }
  }
	ksort($Page数据信息);
  $标题列表 = [];
  foreach($Page数据信息 as $KEY => $Title_Id)  {
    if(strlen($Title_Id['title'])>5)  {
      $标题列表[] = $Title_Id;
    }
  }

  //把当前页面参数转为TEXT,然后做替换,最后再转化为JSON
  $指定页面JSONText = json_encode($指定页面JSON);
  for($i=0;$i<sizeof($目录LIST);$i++)  {
    $目录新标题       = $目录LIST[$i];
    $目录旧标题Title  = $标题列表[$i]['title'];
    $目录旧标题Id     = $标题列表[$i]['id'];
    $PageChildren[$目录旧标题Id]['children'][0]['children'][0]['text'] = $目录新标题;
  }

  $指定页面JSON['children'] = $PageChildren;

  return $指定页面JSON;
}

function 得到所有的内容明细页面($pages)     {
  $可以随机抽取使用的页面数据 = [];
  for($i=3;$i<sizeof($pages);$i++)    {
    $Page                     = $pages[$i];
    $得到指定页面的标题列表Data = 得到指定页面的标题列表($Page);
    if(sizeof($得到指定页面的标题列表Data) == 5) { //5代表是两个大项, 再加一个标题
      $可以随机抽取使用的页面数据[5][] = $Page;
    }
    if(sizeof($得到指定页面的标题列表Data) == 7) { //7代表是三个大项, 再加一个标题
      $可以随机抽取使用的页面数据[7][] = $Page;
    }
    if(sizeof($得到指定页面的标题列表Data) == 9) { //9代表是四个大项, 再加一个标题
      $可以随机抽取使用的页面数据[9][] = $Page;
    }
  }
  //额外复制两份模板的数据出来,为随后的模板匹配创造更多的匹配项
  if(is_array($可以随机抽取使用的页面数据[5])) {
    $可以随机抽取使用的页面数据[5] = array_merge($可以随机抽取使用的页面数据[5], $可以随机抽取使用的页面数据[5], $可以随机抽取使用的页面数据[5], $可以随机抽取使用的页面数据[5]);
  }
  //额外复制两份模板的数据出来,为随后的模板匹配创造更多的匹配项
  if(is_array($可以随机抽取使用的页面数据[7])) {
    $可以随机抽取使用的页面数据[7] = array_merge($可以随机抽取使用的页面数据[7], $可以随机抽取使用的页面数据[7], $可以随机抽取使用的页面数据[7], $可以随机抽取使用的页面数据[7]);
  }
  //额外复制两份模板的数据出来,为随后的模板匹配创造更多的匹配项
  if(is_array($可以随机抽取使用的页面数据[9])) {
    $可以随机抽取使用的页面数据[9] = array_merge($可以随机抽取使用的页面数据[9], $可以随机抽取使用的页面数据[9], $可以随机抽取使用的页面数据[9], $可以随机抽取使用的页面数据[9]);
  }

  return $可以随机抽取使用的页面数据;
}

function 得到指定页面的标题列表($指定页面JSON)  {
  //print_R($章节小节名称);exit;
  //替换首页信息
  //$Page['children'][0]['children'][0]['children'][0]['text'] = "PPT标题";
	//$Page['children'][1]['children'][0]['children'][0]['text'] = "汇报人";
  $Page数据信息    = [];
  $PageChildren 	= (array)$指定页面JSON['children'];
	for($i=0;$i<sizeof($PageChildren);$i++) {
    //检查是否需要把第0和第1进行互换
    if( $PageChildren[$i]['type'] == 'text' &&
        $PageChildren[$i]['children'][0]['type']=="p" &&
        $PageChildren[$i]['children'][1]['type']=="p" &&
        $PageChildren[$i]['children'][0]['children'][0]['text']=="" &&
        $PageChildren[$i]['children'][1]['children'][0]['text']!=""
      )  {
        $Temp = $PageChildren[$i]['children'][0];
        $PageChildren[$i]['children'][0] = $PageChildren[$i]['children'][1];
        $PageChildren[$i]['children'][1] = $Temp;
      }
		if( $PageChildren[$i]['type'] == 'text' &&
        $PageChildren[$i]['children'][0]['type']=="p" &&
        $PageChildren[$i]['children'][0]['children'][0]['text']!=""
      )  {
      //$PageChildren[$i]['children'][0]['children'][0]['text'] = $PPTX标题;
      //print $PageChildren[$i]['children'][0]['children'][0]['text']."<BR>";
      //除以10表示用于兼容处理细微的布局差异
			$X = intval($PageChildren[$i]['point'][0]/5) + 10000;
			$Y = intval($PageChildren[$i]['point'][1]/5) + 10000;
			if($PageChildren[$i]['children'][0]['children'][0]['text']!="" && $PageChildren[$i]['children'][0]['children'][0]['text']!="CONTENTS")  {
				$Page数据信息[$Y."_".$X] = ['title'=>trim($PageChildren[$i]['children'][0]['children'][0]['text']), 'id'=>$i];
			}
    }
  }
	ksort($Page数据信息);
  //print_R($Page数据信息);//exit;
  $标题列表 = [];
  foreach($Page数据信息 as $KEY => $Title_Id)  {
    if(strlen($Title_Id['title'])>5)  {
      $标题列表[] = $Title_Id;
    }
  }

  return $标题列表;
}

// 识别标题和内容的位置关系，布局方案匹配
function 替换内容页($指定页面JSON, $章节小节名称, $章节小节内容, $页面页码)  {
  //print_R($章节小节名称);exit;
  //替换首页信息
  //$Page['children'][0]['children'][0]['children'][0]['text'] = "PPT标题";
	//$Page['children'][1]['children'][0]['children'][0]['text'] = "汇报人";
  $Page数据信息    = [];
  $PageChildren 	= (array)$指定页面JSON['children'];
	for($i=0;$i<sizeof($PageChildren);$i++) {
    //检查是否需要把第0和第1进行互换
    if( $PageChildren[$i]['type'] == 'text' &&
        $PageChildren[$i]['children'][0]['type']=="p" &&
        $PageChildren[$i]['children'][1]['type']=="p" &&
        $PageChildren[$i]['children'][0]['children'][0]['text']=="" &&
        $PageChildren[$i]['children'][1]['children'][0]['text']!=""
      )  {
        $Temp = $PageChildren[$i]['children'][0];
        $PageChildren[$i]['children'][0] = $PageChildren[$i]['children'][1];
        $PageChildren[$i]['children'][1] = $Temp;
      }
		if( $PageChildren[$i]['type'] == 'text' &&
        $PageChildren[$i]['children'][0]['type']=="p" &&
        $PageChildren[$i]['children'][0]['children'][0]['text']!=""
      )  {
      //$PageChildren[$i]['children'][0]['children'][0]['text'] = $PPTX标题;
      //print $PageChildren[$i]['children'][0]['children'][0]['text']."<BR>";
      //除以10表示用于兼容处理细微的布局差异
			$X = intval($PageChildren[$i]['point'][0]/5) + 10000;
			$Y = intval($PageChildren[$i]['point'][1]/5) + 10000;
			if($PageChildren[$i]['children'][0]['children'][0]['text']!="" && $PageChildren[$i]['children'][0]['children'][0]['text']!="CONTENTS")  {
				$Page数据信息[$Y."_".$X] = ['title'=>trim($PageChildren[$i]['children'][0]['children'][0]['text']), 'id'=>$i];
			}
    }
  }
	ksort($Page数据信息);
  $标题列表 = [];
  foreach($Page数据信息 as $KEY => $Title_Id)  {
    if(strlen($Title_Id['title'])>5)  {
      $标题列表[] = $Title_Id;
    }
  }
  //对标题和内容再次过滤,防止有颠倒的情况发生 不能使用FOR 情况特殊
  if(strlen($标题列表[2]['title']) < 50 && strlen($标题列表[3]['title']) > 50)  {
    $TempValue = $标题列表[2];
    $标题列表[2] = $标题列表[3];
    $标题列表[3] = $TempValue;
  }

  //判断是否是前三个都是标题,后三个都是内容的情况
  if(sizeof($标题列表)==7)  {
    if(strlen($标题列表[1]['title']) < strlen($标题列表[4]['title']) && strlen($标题列表[2]['title']) < strlen($标题列表[5]['title']) && strlen($标题列表[3]['title']) < strlen($标题列表[6]['title']) ) {
      //需要转换为标题,内容,标题,内容,标题,内容的形式
      $标题列表NEW    = [];
      $标题列表NEW[0] = $标题列表[0];
      $标题列表NEW[1] = $标题列表[1];
      $标题列表NEW[2] = $标题列表[4];
      $标题列表NEW[3] = $标题列表[2];
      $标题列表NEW[4] = $标题列表[5];
      $标题列表NEW[5] = $标题列表[3];
      $标题列表NEW[6] = $标题列表[6];
      $标题列表 = $标题列表NEW;
      //print_R(array_values($标题列表NEW));exit;
    }
  }
  //print_R($标题列表);exit;

  //print_R($标题列表);print_R($章节小节名称);print_R($章节小节内容); //exit;
  //把当前页面参数转为TEXT,然后做替换,最后再转化为JSON
  array_unshift($章节小节内容, $章节小节名称);
  for($i=0;$i<sizeof($章节小节内容);$i++)  {
    $目录新标题       = $章节小节内容[$i];
    $目录旧标题Title  = $标题列表[$i]['title'];
    $目录旧标题Id     = $标题列表[$i]['id'];
    $PageChildren[$目录旧标题Id]['children'][0]['children'][0]['text'] = $目录新标题;
  }

  $指定页面JSON['children'] = $PageChildren;
  $指定页面JSON['title']    = $章节小节名称;
  $指定页面JSON['page']     = $页面页码;

  return $指定页面JSON;
}

//把Markdown转为JSON Data
/**
 * Summary of Markdown_To_JsonData
 * @param mixed $OUTLINE 原始大纲
 * @param mixed $MarkdownData ai扩展后的详细内容
 * @param mixed $JsonData 模板json数据
 * @param mixed $Finished
 * @param mixed $个性化信息
 * @param mixed $OutPutLastPageId
 */
function Markdown_To_JsonData($OUTLINE, $MarkdownData, $JsonData, $Finished, $个性化信息, $OutPutLastPageId) {
  
  $MarkdownData = str_replace("```markdown", "", $MarkdownData);
  $MarkdownData = str_replace("```", "", $MarkdownData);

  //得到PPTX目录
  $OUTLINEArray = explode("\\n", $OUTLINE);
  if(sizeof($OUTLINEArray) == 1) {
    $OUTLINEArray = explode("\n", $OUTLINE);
  }
  $第一章标题 = "";
  foreach($OUTLINEArray as $Item) {
    if(substr(Trim($Item), 0, 3) == '## ') {
      $目录LIST[] = substr($Item, 6, strlen($Item));
    }
    if(substr(Trim($Item), 0, 4) == '### ' && $第一章标题 == "") {
      $第一章标题 = substr($Item, 8, strlen($Item));
    }
  }

  //非空处理
  $FullResponeTextArray = explode("\\n", $MarkdownData);
  if(sizeof($FullResponeTextArray) == 1) {
    $FullResponeTextArray = explode("\n", $MarkdownData);
  }
  $FullResponeTextArrayNotNullLine = [];
  foreach($FullResponeTextArray as $Item) {
    if(trim($Item)!="") {
      $FullResponeTextArrayNotNullLine[] = trim($Item);
    }
  }

  $标题编号数字列表 = [ "1.1.1","1.1.2","1.1.3","1.1.4","1.2.1","1.2.2","1.2.3","1.2.4","1.3.1","1.3.2","1.3.3","1.3.4","1.4.1","1.4.2","1.4.3","1.4.4",
                       "2.1.1","2.1.2","2.1.3","2.1.4","2.2.1","2.2.2","2.2.3","2.2.4","2.3.1","2.3.2","2.3.3","2.3.4","2.4.1","2.4.2","2.4.3","2.4.4",
                       "3.1.1","3.1.2","3.1.3","3.1.4","3.2.1","3.2.2","3.2.3","3.2.4","3.3.1","3.3.2","3.3.3","3.3.4","3.4.1","3.4.2","3.4.3","3.4.4",
                       "4.1.1","4.1.2","4.1.3","4.1.4","4.2.1","4.2.2","4.2.3","4.2.4","4.3.1","4.3.2","4.3.3","4.3.4","4.4.1","4.4.2","4.4.3","4.4.4",
                       "5.1.1","5.1.2","5.1.3","5.1.4","5.2.1","5.2.2","5.2.3","5.2.4","5.3.1","5.3.2","5.3.3","5.3.4","5.4.1","5.4.2","5.4.3","5.4.4",
                       "6.1.1","6.1.2","6.1.3","6.1.4","6.2.1","6.2.2","6.2.3","6.2.4","6.3.1","6.3.2","6.3.3","6.3.4","6.4.1","6.4.2","6.4.3","6.4.4",
                       "7.1.1","7.1.2","7.1.3","7.1.4","7.2.1","7.2.2","7.2.3","7.2.4","7.3.1","7.3.2","7.3.3","7.3.4","7.4.1","7.4.2","7.4.3","7.4.4",
                       "8.1.1","8.1.2","8.1.3","8.1.4","8.2.1","8.2.2","8.2.3","8.2.4","8.3.1","8.3.2","8.3.3","8.3.4","8.4.1","8.4.2","8.4.3","8.4.4",
                       "9.1.1","9.1.2","9.1.3","9.1.4","9.2.1","9.2.2","9.2.3","9.2.4","9.3.1","9.3.2","9.3.3","9.3.4","9.4.1","9.4.2","9.4.3","9.4.4",
                      ];

  //转为MAP
  $Map    = [];
  $PPTX标题 = "";
  $章节标题 = "";
  $小节标题 = "";
  $小节内容 = "";
  foreach($FullResponeTextArrayNotNullLine as $Item) {
    if(substr($Item, 0, 2) == '# ') {
      $PPTX标题     = substr($Item, 2, strlen($Item));
      //$Map['标题']  = $PPTX标题;
    }
    else if(substr($Item, 0, 3) == '## ') {
      $章节标题 = substr($Item, 6, strlen($Item));
      //$Map['章节'][$章节标题] = $章节标题;
    }
    else if(substr($Item, 0, 4) == '### ') {
      $小节标题 = substr($Item, 8, strlen($Item));
      //$Map['小节'][$章节标题][] = $小节标题;
    }
    else if(substr($Item, 0, 5) == '#### ') {
      //示例数据
      //#### 1.1.1 主要经济体的增长预期
      if(in_array(substr($Item, 5, 5), $标题编号数字列表))  {
        $Item = substr($Item, 11, strlen($Item));
      }
      $Map[$PPTX标题][$章节标题][$小节标题][] = $Item;
    }
    else {
      //示例数据
      //1.1.1 主要经济体的增长预期
      if(in_array(substr($Item, 0, 5), $标题编号数字列表))  {
        $Item = substr($Item, 6, strlen($Item));
      }
      $Map[$PPTX标题][$章节标题][$小节标题][] = $Item;
    }
  }
  $pages      = (array)$JsonData['pages'];
  $首页       = $pages[0];
  $目录页     = $pages[1];
  $章节标题页 = $pages[2];
  $尾页       = $pages[sizeof($pages)-1];
  //print_R($Map);exit;
  //$替换后首页 = 替换首页或尾页($首页, $PPTX标题, $个性化信息['Author'], 1, $PPTX标题);
  //print_R($替换后首页);

  //$替换后尾页 = 替换首页或尾页($尾页, '非常感谢大家聆听', $个性化信息['Author'], sizeof($pages), '非常感谢大家聆听');
  //print_R($替换后尾页);

  //$替换后目录页  = 替换目录页($目录页, $目录LIST, 2, $PPTX标题);
  //print_R($替换后目录页);

  //$替换后章节标题页 = 替换首页或尾页($章节标题页, "01", $章节标题, 3, $章节标题);
  //print_R($替换后章节标题页);

  $得到所有的内容明细页面Data = 得到所有的内容明细页面($pages);
  //print_R($得到所有的内容明细页面Data[7]);exit;

  $最终输出页面数据     = [];
  $最终输出页面数据[0]  = 替换首页或尾页($首页, $PPTX标题, $个性化信息['Author'], 1, $PPTX标题);

  //print_R($FullResponeTextArrayNotNullLine);
  $最终输出页面数据[1]  = 替换目录页($目录页, $目录LIST, 2, $PPTX标题);
  if($Map[$PPTX标题] == null) {
    $Map[$PPTX标题][$第一章标题] = '';
  }

  $StartPage = 2;
  $章节序号 = 0;
  foreach((array)$Map[$PPTX标题] as $章节名称 => $章节小节列表)  {
    $章节序号 += 1;
    $最终输出页面数据[$StartPage]       = 替换首页或尾页($章节标题页, $章节名称, $章节序号<10 ? "0".$章节序号 : $章节序号, $StartPage+1, $章节名称);
    $StartPage += 1;
    foreach($章节小节列表 as $章节小节名称 => $章节小节内容)  {
      // 模板匹配
      //二组标题和内容
      if(sizeof($章节小节内容) == 4 && isset($得到所有的内容明细页面Data[5]) )  {
        $内容页                         = array_shift($得到所有的内容明细页面Data[5]);
        $最终输出页面数据[$StartPage]    = 替换内容页($内容页, $章节小节名称, $章节小节内容, $StartPage+1);
        $StartPage += 1;
      }
      //三组标题和内容
      else if(sizeof($章节小节内容) == 6 && isset($得到所有的内容明细页面Data[7]) )  {
        $内容页                         = array_shift($得到所有的内容明细页面Data[7]);
        $最终输出页面数据[$StartPage]    = 替换内容页($内容页, $章节小节名称, $章节小节内容, $StartPage+1);
        $StartPage += 1;
      }
      //四组标题和内容
      else if(sizeof($章节小节内容) == 8 && isset($得到所有的内容明细页面Data[9]) )  {
        $内容页                         = array_shift($得到所有的内容明细页面Data[9]);
        $最终输出页面数据[$StartPage]    = 替换内容页($内容页, $章节小节名称, $章节小节内容, $StartPage+1);
        $StartPage += 1;
      }
      //四组标题和内容 - 但是没有找到对应的四组模板进行匹配,就使用三组的模板
      else if(sizeof($章节小节内容) == 8 && !isset($得到所有的内容明细页面Data[9]) )  {
        $内容页                         = array_shift($得到所有的内容明细页面Data[7]);
        $最终输出页面数据[$StartPage]    = 替换内容页($内容页, $章节小节名称, $章节小节内容, $StartPage+1);
        $StartPage += 1;
      }
    }
  }

  if($Finished == true)  {
    $最终输出页面数据[$StartPage] = 替换首页或尾页($尾页, $个性化信息['LastPageText'], $个性化信息['Author'], $StartPage+1, $个性化信息['LastPageText']);
  }

  $JsonData['pages2'] = $最终输出页面数据;
  $OutPutLastPageId   = intval($OutPutLastPageId);
  //$OutPutLastPageId > 0 时, 只显示这个值以后的所有页面
  if($OutPutLastPageId > 3)  {
    $最终输出页面数据 = array_slice($最终输出页面数据, $OutPutLastPageId, null, true);
  }

  $JsonData['pages'] = $最终输出页面数据;

  return $JsonData;

}

function 根据大纲得到PPTX页码($outlineMarkdown) {
  $TotalPages       = [];
  $TotalPages[]     = ['type'=>'Content', 'content'=>'Content'];
  $outlineMarkdownArray = explode("\\n", $outlineMarkdown);
  if(sizeof($outlineMarkdownArray)==1)  {
    $outlineMarkdownArray = explode("\n", $outlineMarkdown);
  }
  foreach($outlineMarkdownArray as $Item)  {
    if(substr(trim($Item), 0, 2) == "# ") {
      $TotalPages[] = ['type'=>'Cover', 'content'=>substr(trim($Item), 2, strlen($Item))];
    }
    if(substr(trim($Item), 0, 3) == "## ") {
      $TotalPages[] = ['type'=>'Chapter', 'content'=>substr(trim($Item), 3, strlen($Item))];
    }
    if(substr(trim($Item), 0, 4) == "### ") {
      $TotalPages[] = ['type'=>'Page', 'content'=>substr(trim($Item), 4, strlen($Item))];
    }
  }
  $TotalPages[]     = ['type'=>'Thank', 'content'=>'Thank'];
  $TotalPagesNumber = sizeof($TotalPages);

  return $TotalPagesNumber;
}
?>
