# PPTX目录结构生成脚本
# 用于理解和测试PPTX文件的内部结构

param(
    [string]$OutputPath = ".\pptx_structure_demo"
)

Write-Host "正在创建PPTX目录结构演示..." -ForegroundColor Green

# 创建根目录
if (Test-Path $OutputPath) {
    Remove-Item $OutputPath -Recurse -Force
}
New-Item -ItemType Directory -Path $OutputPath | Out-Null

# 创建主要目录结构
$directories = @(
    "_rels",
    "docProps", 
    "ppt",
    "ppt\_rels",
    "ppt\media",
    "ppt\theme",
    "ppt\theme\_rels",
    "ppt\slideLayouts",
    "ppt\slideLayouts\_rels",
    "ppt\slideMasters",
    "ppt\slideMasters\_rels",
    "ppt\slides",
    "ppt\slides\_rels"
)

Write-Host "创建目录结构..." -ForegroundColor Yellow
foreach ($dir in $directories) {
    $fullPath = Join-Path $OutputPath $dir
    New-Item -ItemType Directory -Path $fullPath -Force | Out-Null
    Write-Host "  ✓ 创建目录: $dir" -ForegroundColor Gray
}

# 创建示例文件
Write-Host "创建示例文件..." -ForegroundColor Yellow

# 根级文件
@{
    "[Content_Types].xml" = @"
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
    <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
    <Default Extension="xml" ContentType="application/xml"/>
    <Override PartName="/ppt/presentation.xml" ContentType="application/vnd.openxmlformats-presentationml.presentation.main+xml"/>
    <Override PartName="/ppt/slides/slide1.xml" ContentType="application/vnd.openxmlformats-presentationml.slide+xml"/>
    <Override PartName="/ppt/theme/theme1.xml" ContentType="application/vnd.openxmlformats-officedocument.theme+xml"/>
    <Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/>
    <Override PartName="/docProps/app.xml" ContentType="application/vnd.openxmlformats-officedocument.extended-properties+xml"/>
</Types>
"@
    "_rels\.rels" = @"
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="ppt/presentation.xml"/>
    <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/>
    <Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties" Target="docProps/app.xml"/>
</Relationships>
"@
    "docProps\core.xml" = @"
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties">
    <dc:title xmlns:dc="http://purl.org/dc/elements/1.1/">AI生成PPT演示</dc:title>
    <dc:creator xmlns:dc="http://purl.org/dc/elements/1.1/">AiToPPTX</dc:creator>
    <cp:lastModifiedBy>AiToPPTX</cp:lastModifiedBy>
    <dcterms:created xmlns:dcterms="http://purl.org/dc/terms/" xsi:type="dcterms:W3CDTF" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">$(Get-Date -Format "yyyy-MM-ddTHH:mm:ssZ")</dcterms:created>
    <dcterms:modified xmlns:dcterms="http://purl.org/dc/terms/" xsi:type="dcterms:W3CDTF" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">$(Get-Date -Format "yyyy-MM-ddTHH:mm:ssZ")</dcterms:modified>
</cp:coreProperties>
"@
    "docProps\app.xml" = @"
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties" xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">
    <Application>AiToPPTX</Application>
    <ScaleCrop>false</ScaleCrop>
    <HeadingPairs>
        <vt:vector size="6" baseType="variant">
            <vt:variant><vt:lpstr>主题</vt:lpstr></vt:variant>
            <vt:variant><vt:i4>1</vt:i4></vt:variant>
            <vt:variant><vt:lpstr>幻灯片</vt:lpstr></vt:variant>
            <vt:variant><vt:i4>1</vt:i4></vt:variant>
        </vt:vector>
    </HeadingPairs>
    <TitlesOfParts>
        <vt:vector size="2" baseType="lpstr">
            <vt:lpstr>默认主题</vt:lpstr>
            <vt:lpstr>AI生成PPT演示</vt:lpstr>
        </vt:vector>
    </TitlesOfParts>
    <Company>郑州单点科技软件有限公司</Company>
    <LinksUpToDate>false</LinksUpToDate>
    <SharedDoc>false</SharedDoc>
    <HyperlinksChanged>false</HyperlinksChanged>
    <AppVersion>16.0000</AppVersion>
</Properties>
"@
    "ppt\presentation.xml" = @"
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<p:presentation xmlns:p="http://schemas.openxmlformats.org/presentationml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
    <p:sldMasterIdLst>
        <p:sldMasterId id="2147483648" r:id="rId1"/>
    </p:sldMasterIdLst>
    <p:sldIdLst>
        <p:sldId id="256" r:id="rId2"/>
    </p:sldIdLst>
    <p:sldSz cx="9144000" cy="6858000" type="screen4x3"/>
    <p:notesSz cx="6858000" cy="9144000"/>
    <p:defaultTextStyle>
        <p:defPPr>
            <p:defRPr lang="zh-CN"/>
        </p:defPPr>
    </p:defaultTextStyle>
</p:presentation>
"@
    "ppt\_rels\presentation.xml.rels" = @"
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/slideMaster" Target="slideMasters/slideMaster1.xml"/>
    <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/slide" Target="slides/slide1.xml"/>
    <Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/theme" Target="theme/theme1.xml"/>
</Relationships>
"@
    "ppt\slides\slide1.xml" = @"
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<p:sld xmlns:p="http://schemas.openxmlformats.org/presentationml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
    <p:cSld>
        <p:spTree>
            <p:nvGrpSpPr>
                <p:cNvPr id="1" name=""/>
                <p:cNvGrpSpPr/>
                <p:nvPr/>
            </p:nvGrpSpPr>
            <p:grpSpPr>
                <a:xfrm xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main">
                    <a:off x="0" y="0"/>
                    <a:ext cx="0" cy="0"/>
                    <a:chOff x="0" y="0"/>
                    <a:chExt cx="0" cy="0"/>
                </a:xfrm>
            </p:grpSpPr>
            <p:sp>
                <p:nvSpPr>
                    <p:cNvPr id="2" name="标题 1"/>
                    <p:cNvSpPr>
                        <a:spLocks noGrp="1" xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main"/>
                    </p:cNvSpPr>
                    <p:nvPr>
                        <p:ph type="ctrTitle"/>
                    </p:nvPr>
                </p:nvSpPr>
                <p:spPr/>
                <p:txBody>
                    <a:bodyPr xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main"/>
                    <a:lstStyle xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main"/>
                    <a:p xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main">
                        <a:r>
                            <a:rPr lang="zh-CN" dirty="0" smtClean="0"/>
                            <a:t>AI生成PPT示例</a:t>
                        </a:r>
                    </a:p>
                </p:txBody>
            </p:sp>
        </p:spTree>
    </p:cSld>
    <p:clrMapOvr>
        <a:masterClrMapping xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main"/>
    </p:clrMapOvr>
</p:sld>
"@
} | ForEach-Object {
    $_.GetEnumerator() | ForEach-Object {
        $filePath = Join-Path $OutputPath $_.Key
        $content = $_.Value
        $content | Out-File -FilePath $filePath -Encoding UTF8
        Write-Host "  ✓ 创建文件: $($_.Key)" -ForegroundColor Gray
    }
}

# 创建README文件
$readmeContent = @"
# PPTX目录结构演示

这个目录展示了PPTX文件的完整内部结构。

## 目录说明

### 根级文件
- [Content_Types].xml: 内容类型定义
- _rels/.rels: 包关系文件

### docProps/ - 文档属性
- core.xml: 核心属性（标题、作者等）
- app.xml: 应用程序属性

### ppt/ - 演示文稿主要内容
- presentation.xml: 主演示文稿文件
- _rels/presentation.xml.rels: 演示文稿关系
- slides/: 幻灯片内容
- slideLayouts/: 版式定义
- slideMasters/: 母版定义
- theme/: 主题文件
- media/: 媒体文件（图片等）

## 使用说明

1. 这个结构演示了PPTX文件解压后的内容
2. 所有XML文件都遵循Office Open XML标准
3. 实际的PPTX生成会将这些文件压缩成.pptx文件

## 在AiToPPTX中的应用

AiToPPTX系统会：
1. 创建这个目录结构
2. 生成相应的XML内容
3. 添加媒体文件
4. 压缩成最终的PPTX文件

生成时间: $(Get-Date -Format "yyyy-MM-dd HH:mm:ss")
"@

$readmeContent | Out-File -FilePath (Join-Path $OutputPath "README.md") -Encoding UTF8

Write-Host "`n✅ PPTX目录结构演示创建完成!" -ForegroundColor Green
Write-Host "📁 输出路径: $OutputPath" -ForegroundColor Cyan
Write-Host "📄 查看README.md了解详细说明" -ForegroundColor Yellow

# 显示目录树
Write-Host "`n目录结构预览:" -ForegroundColor Magenta
if (Get-Command tree -ErrorAction SilentlyContinue) {
    tree $OutputPath /F
} else {
    Write-Host "可以使用以下命令查看目录结构:" -ForegroundColor Yellow
    Write-Host "tree $OutputPath /F" -ForegroundColor Gray
}

Write-Host "`n💡 提示: 这个结构对应AiToPPTX系统中 include.inc.php 文件第66-79行的目录创建代码" -ForegroundColor Blue
