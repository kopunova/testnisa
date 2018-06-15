<?php
use yii\widgets\LinkPager;

?>

<div id='result'>
    <div class="panel panel-default panel-body">

        <table class="table table-bordered">
            <tr>
                <th>news_id</th>
                <th>unique_clicks</th>
                <th>clicks</th>
                <th>country_code</th>
                <th>date</th>			  
            </tr>

            <?php foreach ($posts as $post): ?>		
                <tr>
                    <td><?= $post['news_id'] ?></td>
                    <td><?= $post['unique_clicks'] ?></td>
                    <td><?= $post['clicks'] ?></td>
                    <td><?= $post['country_code'] ?></td>
                    <td><?= date('d.m.Y', strtotime($post['date'])) ?></td>
                </tr>	
            <?php endforeach; ?>	

        </table>

    </div>
	
	<?=
    LinkPager::widget([
        'pagination' => $pages,
    ]);
    ?>

</div>