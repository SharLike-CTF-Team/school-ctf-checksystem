<div id="ajax-wrap">
    <div id="text">
    <div class="container" style="padding-top:10px;">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th class="text-center">Участник</th>
                      <th class="text-center">Откуда</th>
                      <th class="text-center">Рейтинг</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    for($i = 0; $i < count($score); $i++) {
                        if($i == 0) {
                            $style = "background-color: #ffe033;";
                        }
                        elseif($i == 1) {
                            $style = "background-color: #d9d9d9;";
                        }
                        elseif($i == 2) {
                            $style = "background-color: #d6985a;";
                        }
                        else {
                            $style= "background-color: #fff";
                        }
                        ?>
                        <tr style="<?php if(isset($style)) echo $style;?>">
                            <td class="text-center" style="vertical-align: middle;"><?php echo $i+1;?></td>
                            <td class="text-center" style="vertical-align: middle;"><?php echo $score[$i]['name'];?></td>
                            <td class="text-center" style="vertical-align: middle;"><?php echo $score[$i]['location'];?></td>
                            <td class="text-center" style="vertical-align: middle;"><?php echo $score[$i]['result'];?></td>
                        </tr>
                        <?php
                    }
                  ?>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
</div>
