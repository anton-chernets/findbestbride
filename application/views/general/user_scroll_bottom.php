<style>

    .scroll-text {
        border: 1px solid red;
        width: 400px;
        height: 4.5em;
        overflow: hidden;
    }

    .scroll-text ul {
        width: 800px;
        height: 100px;
        overflow: hidden;
        margin: 0;
    }

    .scroll-text ul li {
        height: 1.5em;
    }

    .scroll-img {
        border: 2px solid #d25821;
        width: 960px;
        height: 155px;
        overflow: hidden;
        font-size: 0;
        float: left;
    }

    .scroll-img ul {
        width: 92%;
        height: 155px;
        margin: 0;
    }

    .scroll-img ul li {
        display: inline-block;
        margin: 10px 5px 10px 10px;
        width: 80px;
        height: 125px;
    }

    .scroll-img img {
        width: auto;
        height: 125px;
    }

    #demo4.scroll-img ul,
    .scroll-img ul {
        width: 1500px;
        padding-left: 0;
    }

    #scroll-bottom-btn {
        width: 680px;
        padding-top: 10px;
    }

    #demo6 {
        width: 412px;
    }

    #demo6-queue {
        width: 680px;
    }

    #scroll-bottom p, #demo6-queue p {
        width: 124px;
        height: 124px;
        background-color: lightgray;
        font-family: 'Amaranth', sans-serif;
        font-size: 82px;
        text-align: center;
        display: table-cell;
        vertical-align: middle;
    }

    .btn-prev {
        opacity: 1;
        background-image: url("/content/img/arrow-left-dark.png");
        background-repeat: no-repeat;
        background-position: left;
        background-size: 75% 50%;
        height: 145px;
        width: 100%;
        cursor: pointer;
    }

    .btn-next {
        opacity: 1;
        background-image: url("/content/img/arrow-right-dark.png");
        background-repeat: no-repeat;
        background-position: right;
        background-size: 75% 50%;
        height: 145px;
        width: 100%;
        cursor: pointer;
    }

    .name-scroll-photo {
        color: #333;
        margin-top: 5px;
        font-size: 11px;
        float: left;
        font-weight: bold;
        width: 85px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .age-scroll-photo {
        color: #333;
        margin-top: 5px;
        font-size: 11px;
        float: right;
    }

</style>
<?php //if ( $this->userInfo['sex'] == 2 ) : ?>
<!--    <div style="padding-top: 500px;"></div>-->
<?php //endif; ?>

<br style="clear: both"/>
<br/>
<div class="clearfix slider">
    <div style="width:41px; float:left;">
        <div class="btn-prev" id="scroll-bottom-backward"></div>
    </div>
    <div id="scroll-bottom" class="scroll-img">
        <ul>
			<?php if ( $this->isAuth == true && $this->userInfo['sex'] == 2 ) {
				$sql = "SELECT * FROM `user_profile` where user_status=0 AND sex=1 AND photo_link != '' ORDER BY `register_date` DESC LIMIT 100";
			} else {
				$sql = "SELECT * FROM `user_profile` where user_status=0 AND sex=2 AND photo_link != '' ORDER BY `register_date` DESC LIMIT 100";
			}

			$query   = $this->db->query( $sql );
			$results = $query->result_array();

			foreach ( $results as $result ) {
				$link2 = ( $this->isAuth == true ) ? '<a href="/user' . $result['id'] . '">' : '<a href="javascript:;" class="open-modal">';
				echo '<li>' . $link2 . '
		<img src="/profiles/photo/user_' . $result['id'] . '/' . $result['photo_link'] . '_100.jpg">
		<div class="name-scroll-photo">' . $result['name'] . ' ' . $result['age'] . '</div>
		</a>
		</li>';
			}
			?>
        </ul>
    </div>
    <div style="width:41px; float:left;">
        <div class="btn-next" id="scroll-bottom-forward"></div>
    </div>
</div>
<script>
    $(function () {

        $('#scroll-bottom').scrollbox({
            direction: 'h',
            switchItems: 5,
            distance: 475,
            delay: 5,
            speed: 50
        });
        $('#scroll-bottom-backward').click(function () {
            $('#scroll-bottom').trigger('backward');
        });
        $('#scroll-bottom-forward').click(function () {
            $('#scroll-bottom').trigger('forward');
        });

    });
</script>
