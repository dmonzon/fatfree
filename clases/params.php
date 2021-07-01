<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo $f3->get('BASE');?>/ui/css/style.css">
</head>
<script type="text/javascript">
    $(function(){
        $("option").bind("dblclick", function(){
            alert($(this).text());
        });
    });
</script>
<body>
<?php 
//echo "<pre>";
    require_once("cn.php");
    require_once("controls.php");
?>
    <div class="noprint">
        <table>
            <thead>
                    <tr>   
                        <th style="text-align:center; vertical-align: text-top;">
                            Projects
                        </th>
                        <th colspan="2" style="text-align: center;">
                            <form name="main" action="<?php echo $f3->get('BASE');?>/params" target="_self" method="POST">
                                <?php 
                                    ($f3->get('POST.itemID')) ? $item = $f3->get('POST.itemID') : $item = 0;
                                    echo ddBuilder('itemID',10,'',"select id,p.pkgName,p.description from tbl_Packages p order by 2",$item);
                                ?><br>
                                <button class="dentro">Go</button>
                                <input type="hidden" name="req" value="1">
                            </form>
                        </th>
                    </tr>
            </thead>
    </div>
    <div>
        <?php
            //print_r($_POST);
            if($f3->get('POST.req') == 1){
                //echo "aqui estamos " . $f3->get('POST.itemID')."<br>";
                $x = $f3->get('POST.itemID'); //$proj = $_POST['proj'];
                echo getItems("select id,opt_name,opt_value,pkg_id
                from [dbo].[tbl_PackageOptions]
                where pkg_id =",$x);
            }elseif ($f3->get('POST.req') == 2) {
                $x = $f3->get('POST.optID');
                $value = $f3->get('POST.optVal');
                $itemID = $f3->get('POST.itemID');
                echo updateItem($x,$value,);
                echo getItems("select id,opt_name,opt_value,pkg_id
                from [dbo].[tbl_PackageOptions]
                where pkg_id =",$itemID);
            }elseif ($f3->get('POST.req') == 3) {
                $x = $f3->get('POST.txtParam');
                $value = $f3->get('POST.txtValue');
                $itemID = $f3->get('POST.itemID');
                echo addParam($x,$value,$itemID);
                echo getItems("select id,opt_name,opt_value,pkg_id
                from [dbo].[tbl_PackageOptions]
                where pkg_id =",$itemID);
            }
        ?>
        </table>
    </div>
</body>