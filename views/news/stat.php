<?php
$this->title = 'Статистика';

?>

<span class="btn btn-primary" onClick="getReport()">Сформировать отчет</span> 
 
<div id='info'>
</div>	
<br>
<div id='result'>
</div>

<script>

    function getReport() {	
		
        $("#info").html('Идет формирование отчета...');
        $("#result").html('');
				
        $.ajax({
            type: "POST",
            url: 'report',
            success: function (result) {
                $("#result").html($(result).find('#result').html());
				$("#info").html('');
            }
        });

    }

</script>