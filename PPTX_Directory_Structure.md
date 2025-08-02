# PPTX 文件内部目录结构

## 概述
PPTX文件本质上是一个ZIP压缩包，包含多个XML文件和资源文件，遵循Office Open XML (OOXML) 标准。以下是完整的目录结构：

## 目录结构树状图
```
PPTX文件内部结构/
├── [Content_Types].xml          # 定义所有内容类型和文件扩展名映射
├── _rels/                       # 包级关系文件夹
│   └── .rels                    # 根关系文件，定义核心文档关系
├── docProps/                    # 文档属性文件夹
│   ├── app.xml                  # 应用程序特定属性√
│   └── core.xml                 # 核心文档属性（标题、作者、创建时间等）√
└── ppt/                         # 演示文稿主要内容文件夹
    ├── presentation.xml         # 演示文稿主文件，定义幻灯片顺序和全局设置
    ├── presProps.xml           # 演示文稿属性√
    ├── tableStyles.xml         # 表格样式定义√
    ├── viewProps.xml           # 视图属性设置√
    ├── _rels/                  # 演示文稿关系文件夹
    │   └── presentation.xml.rels # 演示文稿关系文件
    ├── theme/                  # 主题相关文件夹√
    │   ├── theme1.xml          # 主题定义文件
    │   └── _rels/              # 主题关系文件夹
    │       └── theme1.xml.rels # 主题关系文件
    ├── slides/                 # 幻灯片内容文件夹
    │   ├── slide1.xml          # 第1张幻灯片内容
    │   ├── slide2.xml          # 第2张幻灯片内容
    │   ├── slideN.xml          # 第N张幻灯片内容
    │   └── _rels/              # 幻灯片关系文件夹
    │       ├── slide1.xml.rels # 第1张幻灯片关系
    │       ├── slide2.xml.rels # 第2张幻灯片关系
    │       └── slideN.xml.rels # 第N张幻灯片关系
    ├── slideLayouts/           # 幻灯片版式文件夹
    │   ├── slideLayout1.xml    # 版式1定义
    │   ├── slideLayout2.xml    # 版式2定义
    │   ├── slideLayoutN.xml    # 版式N定义
    │   └── _rels/              # 版式关系文件夹
    │       ├── slideLayout1.xml.rels # 版式1关系
    │       ├── slideLayout2.xml.rels # 版式2关系
    │       └── slideLayoutN.xml.rels # 版式N关系
    ├── slideMasters/           # 幻灯片母版文件夹
    │   ├── slideMaster1.xml    # 母版1定义
    │   └── _rels/              # 母版关系文件夹
    │       └── slideMaster1.xml.rels # 母版1关系
    └── media/                  # 嵌入媒体文件夹
        ├── image1.png          # 图片文件1
        ├── image2.jpg          # 图片文件2
        └── imageN.ext          # 其他媒体文件
```

## 文件功能详解

### 根级文件
- **[Content_Types].xml**: 定义文件类型映射，告诉应用程序如何处理不同的文件
- **_rels/.rels**: 定义包的根关系，指向主要文档

### 文档属性 (docProps/)
- **core.xml**: 包含标题、作者、创建时间、修改时间等核心元数据
- **app.xml**: 包含应用程序特定信息，如幻灯片数量、字数统计等

### 演示文稿内容 (ppt/)
- **presentation.xml**: 演示文稿的"目录"，定义所有幻灯片的顺序和全局设置
- **presProps.xml**: 演示文稿播放属性
- **tableStyles.xml**: 表格样式库
- **viewProps.xml**: 视图设置（如缩放级别等）

### 主题系统 (ppt/theme/)
- **theme1.xml**: 定义颜色方案、字体方案、效果方案等主题元素

### 幻灯片内容 (ppt/slides/)
- **slideN.xml**: 每张幻灯片的具体内容，包括文本、图形、布局等

### 版式系统 (ppt/slideLayouts/)
- **slideLayoutN.xml**: 定义不同的幻灯片版式（标题页、内容页、对比页等）

### 母版系统 (ppt/slideMasters/)
- **slideMaster1.xml**: 定义母版，控制整体外观和默认格式

### 关系文件 (_rels/)
- **各种.rels文件**: 定义文件之间的关系，如幻灯片与媒体文件的关联

### 媒体文件 (ppt/media/)
- **图片、音频、视频文件**: 嵌入到演示文稿中的媒体资源

## 创建流程
在AiToPPTX系统中，目录创建的顺序为：
1. 创建根级目录结构
2. 创建ppt主目录及其子目录
3. 创建各级_rels关系目录
4. 生成XML内容文件
5. 复制必要的模板文件
6. 压缩成最终的PPTX文件

## 技术要点
- PPTX文件实质是ZIP格式的压缩包
- 所有内容以XML格式存储
- 关系文件(.rels)定义文件间的引用关系
- 媒体文件以二进制形式嵌入
- 遵循Office Open XML国际标准
