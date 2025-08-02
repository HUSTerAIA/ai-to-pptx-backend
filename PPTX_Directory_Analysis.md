# PPTX内部目录结构对照表

## 源代码对应关系

您选中的代码（`include.inc.php` 第66-79行）创建了以下PPTX标准目录结构：

```php
// 确保子文件夹都存在
if(!is_dir($TargetCacheDir."/_rels")) 		mkdir($TargetCacheDir."/_rels");
if(!is_dir($TargetCacheDir."/docProps")) 	mkdir($TargetCacheDir."/docProps");
if(!is_dir($TargetCacheDir."/ppt")) 		mkdir($TargetCacheDir."/ppt");
if(!is_dir($TargetCacheDir."/ppt/_rels")) 	mkdir($TargetCacheDir."/ppt/_rels");
if(!is_dir($TargetCacheDir."/ppt/media")) 	mkdir($TargetCacheDir."/ppt/media");
if(!is_dir($TargetCacheDir."/ppt/theme")) 	mkdir($TargetCacheDir."/ppt/theme");
if(!is_dir($TargetCacheDir."/ppt/slideLayouts")) 	mkdir($TargetCacheDir."/ppt/slideLayouts");
if(!is_dir($TargetCacheDir."/ppt/slideMasters")) 	mkdir($TargetCacheDir."/ppt/slideMasters");
if(!is_dir($TargetCacheDir."/ppt/slides")) 			mkdir($TargetCacheDir."/ppt/slides");
if(!is_dir($TargetCacheDir."/ppt/theme/_rels")) 	mkdir($TargetCacheDir."/ppt/theme/_rels");
if(!is_dir($TargetCacheDir."/ppt/slideLayouts/_rels")) mkdir($TargetCacheDir."/ppt/slideLayouts/_rels");
if(!is_dir($TargetCacheDir."/ppt/slideMasters/_rels")) mkdir($TargetCacheDir."/ppt/slideMasters/_rels");
if(!is_dir($TargetCacheDir."/ppt/slides/_rels")) 		mkdir($TargetCacheDir."/ppt/slides/_rels");
```

## 生成的目录结构树

```
$TargetCacheDir/  (PPTX根目录)
├── _rels/                           # 包级关系目录
├── docProps/                        # 文档属性目录
├── ppt/                            # PPT主要内容目录
│   ├── _rels/                      # PPT关系文件目录
│   ├── media/                      # 媒体文件目录 (图片、音频、视频)
│   ├── theme/                      # 主题目录
│   │   └── _rels/                  # 主题关系文件目录
│   ├── slideLayouts/               # 幻灯片版式目录
│   │   └── _rels/                  # 版式关系文件目录
│   ├── slideMasters/               # 幻灯片母版目录
│   │   └── _rels/                  # 母版关系文件目录
│   └── slides/                     # 幻灯片内容目录
│       └── _rels/                  # 幻灯片关系文件目录
```

## 目录功能说明

| 目录路径 | 功能说明 | 包含文件示例 |
|---------|---------|-------------|
| `/_rels/` | 包级关系定义 | `.rels` |
| `/docProps/` | 文档元数据 | `core.xml`, `app.xml` |
| `/ppt/` | 演示文稿主要内容 | `presentation.xml`, `presProps.xml` |
| `/ppt/_rels/` | 演示文稿关系 | `presentation.xml.rels` |
| `/ppt/media/` | 嵌入的媒体资源 | `image1.png`, `audio1.mp3` |
| `/ppt/theme/` | 主题样式定义 | `theme1.xml` |
| `/ppt/theme/_rels/` | 主题关系文件 | `theme1.xml.rels` |
| `/ppt/slideLayouts/` | 版式定义 | `slideLayout1.xml`, `slideLayout2.xml` |
| `/ppt/slideLayouts/_rels/` | 版式关系 | `slideLayout1.xml.rels` |
| `/ppt/slideMasters/` | 母版定义 | `slideMaster1.xml` |
| `/ppt/slideMasters/_rels/` | 母版关系 | `slideMaster1.xml.rels` |
| `/ppt/slides/` | 幻灯片内容 | `slide1.xml`, `slide2.xml`, `slideN.xml` |
| `/ppt/slides/_rels/` | 幻灯片关系 | `slide1.xml.rels`, `slide2.xml.rels` |

## 创建顺序说明

代码按以下顺序创建目录（对应代码行号）：

1. **根级目录** (第67-69行)
   - `_rels/` - 包关系目录
   - `docProps/` - 文档属性目录  
   - `ppt/` - PPT主目录

2. **PPT一级子目录** (第70-74行)
   - `ppt/_rels/` - PPT关系目录
   - `ppt/media/` - 媒体文件目录
   - `ppt/theme/` - 主题目录
   - `ppt/slideLayouts/` - 版式目录
   - `ppt/slideMasters/` - 母版目录
   - `ppt/slides/` - 幻灯片目录

3. **关系文件目录** (第75-79行)
   - `ppt/theme/_rels/` - 主题关系目录
   - `ppt/slideLayouts/_rels/` - 版式关系目录  
   - `ppt/slideMasters/_rels/` - 母版关系目录
   - `ppt/slides/_rels/` - 幻灯片关系目录

## 注意事项

- **关系文件(_rels)**：PPTX使用关系文件来定义文档各部分之间的引用关系
- **重复目录创建**：第79行重复创建了`ppt/theme/_rels`，这是冗余的但不会造成错误
- **目录检查**：使用`is_dir()`检查避免重复创建已存在的目录
- **路径分隔符**：使用正斜杠`/`作为路径分隔符，适用于跨平台

## 实际生成演示

运行 `Generate-PPTX-Structure.ps1` 脚本可生成完整的目录结构演示，包含示例XML文件。
