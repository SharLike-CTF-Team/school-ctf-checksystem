    <div id="ajax-wrap">
        <div id="text">
        <div class="container" style="width: 94%;">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-9">
                      <ul class="nav nav-tabs">
                          <li class="active">
                              <a href="#tab1default" data-toggle="tab">Все <span class="badge"><?php $task_info = array(); $tasks = new TaskActions(); $task_info = $tasks->getAllTasks(); echo count($task_info)?></span></a>
                          </li>
                          <?php
                            $j = 0;
                            for($i = 0; $i < count($cat_list); $i++) {
                                ?>
                                <li>
                                    <a href="#tab<?php echo $j == 0 ? $j + 2 : $j + 1;?>default" data-toggle="tab"><?php echo $cat_list[$i];?> <span class="badge"><?php $task_info = array(); $tasks = new TaskActions(); $task_info = $tasks->getTasksInfo($cat_list[$i]); echo count($task_info)?></span></a>
                                </li>
                                <?php
                                $j = $j == 0 ? $j + 2 : $j + 1;
                            }
                          ?>
                      </ul>
                    <div class="panel-body" style="padding: 0; padding-top:15px;">
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="tab1default">
                                <?php
                                $task_info = array();
                                $tasks = new TaskActions();
                                $task_info = $tasks->getAllTasks();
                                for($j = 0; $j < count($task_info); $j++) {
                                    ?>
                                    <a class="panel panel-default task" data-toggle="modal" id="<?php echo $task_info[$j]['id']  . "by" . $task_info[$j]['points'];?>" data-target="#myModal"
                                       style="text-decoration: none; cursor: pointer;">
                                        <div class="panel-heading pnhead"><?php echo $task_info[$j]['title']; ?></div>
                                        <div class="panel-body"
                                             style="height: 76px; font-size: 35px; <?php if(!$task_info[$j]['completed']) { echo "background: url('" . VIEWSPATH . "/img/categories/bg". ($task_info[$j]['cat_id']) .".jpg');"; } else { echo "background-color: #f5f5f5; color: #184012;"; } ?> background-size: cover;"><?php echo $task_info[$j]['points']; ?></div>
                                        <div class="panel-footer pnhead">Решили: <?php echo $tasks->countSolves($task_info[$j]['id']);?></div>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                                $n = 0;
                                for($i = 0; $i < count($cat_list); $i++) {
                                    ?>
                                    <div class="tab-pane fade" id="tab<?php echo $n == 0 ? $n + 2 : $n + 1;?>default">
                                        <?php
                                            $task_info = array();
                                            $tasks = new TaskActions();
                                            $task_info = $tasks->getTasksInfo($cat_list[$i]);
                                            for($j = 0; $j < count($task_info); $j++) {
                                                ?>
                                                <a class="panel panel-default task" data-toggle="modal" id="<?php echo $task_info[$j]['id'] . "by" . $task_info[$j]['points']; ?>" data-target="#myModal"
                                                   style="text-decoration: none; cursor: pointer;">
                                                    <div class="panel-heading pnhead"><?php echo $task_info[$j]['title']; ?></div>
                                                    <div class="panel-body"
                                                         style="height: 76px; font-size: 35px; <?php if(!$task_info[$j]['completed']) { echo "background: url('" . VIEWSPATH . "/img/categories/bg". ($i+1) .".jpg');"; } else { echo "background-color: #f5f5f5; color: #184012;"; } ?>
    background-size: cover;"><?php echo $task_info[$j]['points']; ?></div>
                                                    <div class="panel-footer pnhead">Решили: <?php echo $tasks->countSolves($task_info[$j]['id']);?></div>
                                                </a>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                    <?php
                                    $n = $n == 0 ? $n + 2 : $n + 1;
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- hints -->
                <div class="col-md-3 hidden-xs hidden-sm">
                    <div class="panel panel-default">
                        <div class="panel-heading pnhead">Подсказки</div>
                        <?php
                            //for($i = 0; $i < count($hint_list["task"]); $i++) {
                        ?>
                       <!-- <div class="list-group-item listgr">
                            <h3 class="list-group-item-heading">
                                <a href="#hint">
                                    <?php
                                       // echo $hint_list["task"][$i];
                                    ?>
                                </a>
                            </h3>
                            <div class="list-group-item-text hint">
                            <p>
                                <?php
                                   // echo $hint_list["hint"][$i];
                                ?>
                            </p>
                            </div>
                        </div>-->
                        <?php
                           // }
                        ?>
                    </div>
                </div>
                <!-- /hints -->
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog one-task">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="task-title"></h4>
                            </div>
                            <div class="modal-body">
                                <p id="task-descr">
                                </p>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>