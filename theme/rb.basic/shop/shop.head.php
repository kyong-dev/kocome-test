<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$q = isset($_GET['q']) ? clean_xss_tags($_GET['q'], 1, 1) : '';


/********************/

if(G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

add_javascript('<script src="'.G5_JS_URL.'/owlcarousel/owl.carousel.min.js"></script>', 10);
add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/owlcarousel/owl.carousel.css">', 0);


/* 팝업 추가 2.1.5 { */
if(defined('_INDEX_')) { // index에서만 실행
    include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
}
/* } */

?>

<?php 

    if (isset($rb_core['layout_hd_shop']) && $rb_core['layout_hd_shop'] == "") {
        echo "<div class='no_data' style='padding:30px 0 !important; margin-top:0px; border:0px !important; background-color:#f9f9f9;'><span class='no_data_section_ul1 font-B color-000'>선택된 헤더 레이아웃이 없습니다.</span><br>환경설정 패널에서 먼저 헤더 레이아웃을 설정해주세요.</div>";
    } else if (isset($rb_core['layout_hd_shop'])) { 
        // 레이아웃 인클루드
        include_once(G5_THEME_SHOP_PATH . '/rb.layout_hd/' . $rb_core['layout_hd_shop'] . '/header.php'); 
    } else {
        echo "<div class='no_data' style='padding:30px 0 !important; margin-top:0px; border:0px !important; background-color:#f9f9f9;'>헤더 레이아웃 설정이 올바르지 않습니다.</span><br>환경설정 패널에서 먼저 헤더 레이아웃을 설정해주세요.</div>";
    }

    ?>

    
    <script>
        function adjustContentPadding() {
            // header의 높이 구하기
            var height_header = $('#header').outerHeight();
            // contents_wrap 에 구해진 높이값 적용
            $('#contents_wrap').css('padding-top', height_header + 'px');
        }

        $(document).ready(function() {
            // 처음 페이지 로드 시 호출
            adjustContentPadding();

            // 브라우저 리사이즈 시 호출
            $(window).resize(function() {
                adjustContentPadding();
            });
        });
    </script>
    
    <div class="contents_wrap" id="contents_wrap">
       
        <!-- $rb_core['sub_width'] 는 반드시 포함해주세요 (환경설정 > 서브가로폭) -->
        <section class="<?php if (defined("_INDEX_")) { ?>index co_inner_padding_pc_<?php echo $rb_core['inner_padding_pc'] ?> co_gap_pc_<?php echo $rb_core['gap_pc'] ?><?php } else { ?>sub<?php } ?>" <?php if (!defined("_INDEX_")) { ?>style="width:<?php echo $rb_core['sub_width'] ?>px;"<?php } else { ?>style="width:<?php echo $rb_core['main_width'] ?>px;"<?php } ?>>
        
        <?php if (isset($rb_core['padding_top_shop']) && $rb_core['padding_top_shop'] == 1) { ?>
        <?php if (defined("_INDEX_")) { ?><span style="margin-top:-70px;" class="pc"></span><?php } ?>
        <?php } ?>
        
        <?php if (!defined("_INDEX_")) { ?><h2 id="container_title"><?php echo get_head_title($g5['title']); ?></h2><?php } ?>
