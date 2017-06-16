<?php
/**
 * @author: xin
 * Date: 2016/8/9
 * Time: 13:34
 */

use yii\helpers\Url;

$this->title = $msg;

?>
<!-- #section:pages/error -->
<div class="error-container">
    <div class="well">
        <h1 class="grey lighter smaller">
			<span class="blue bigger-125">
				<i class="ace-icon fa fa-bell"></i>
			</span>
            提示消息
        </h1>

        <hr/>
        <h3 class="lighter smaller">
            <?php echo isset($msg) ? $msg : '页面跳转中...'; ?>
        </h3>

        <div class="space"></div>

        <div>
            <?php if (isset($type) && $type == 'error') { ?>
                <span id="end-time">5</span>秒跳转。</a>
            <?php } else { ?>
                <span id="end-time">5</span>秒后将会跳转到<a href="<?php echo isset($url) && $url ? $url : Url::toRoute(['base/base-index']); ?>">页面</a>。
            <?php } ?>
        </div>

        <?php if (isset($type) && $type == 'error') { ?>
            <hr/>
            <div class="space"></div>
            <div class="center">
                <a href="javascript:history.back()" class="btn btn-grey">
                    <i class="ace-icon fa fa-arrow-left"></i>
                    返回上一页
                </a>

                <a href="<?= Url::toRoute(['base/base-index']) ?>" class="btn btn-primary">
                    <i class="ace-icon fa fa-tachometer"></i>
                    返回后台首页
                </a>
            </div>
        <?php } ?>
    </div>
</div>

<!-- /section:pages/error -->
<script type="text/javascript">
    //设定倒数秒数
    var t = document.getElementById("end-time").innerHTML;
    //显示倒数秒数
    function showTime() {
        t -= 1;
        document.getElementById("end-time").innerHTML = t;
        if (t == 0) {
            <?php if(isset($type) && $type == "error") { ?>
            history.back();
            <?php }else {?>
            location.href = '<?php echo isset($url) && $url ? $url : Url::toRoute(['base/base-index']);?>';
            <?php } ?>
        }
        //每秒执行一次,showTime()
        setTimeout("showTime()", 1000);
    }

    //执行showTime()
    showTime();
</script>
