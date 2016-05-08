$(document).ready(function(){
    $('.task').click(function() {
        $('#inputFlag').val('');
        var task_id = $(this).attr('id').split('by')[0];
        var points = $(this).attr('id').split('by')[1];
        $.ajax({
            type: 'POST',
            data: {task_id: task_id},
            success: function (data) {
                var task_info = jQuery.parseJSON(data);
                $('#task-title').text('').append(task_info['title']);
                $('#task-descr').text('').append(task_info['description']);
                $('.modal-footer').empty();
                if(!task_info['completed']) {
                    $('.modal-footer').append('<div class="form-group"><input type="text" class="form-control" id="inputFlag" placeholder="Flag"></div><button type="submit" id="sendflag" class="btn btn-primary">Отправить</button>');
                    $('#sendflag').on('click', function () {
                        var flag = $('#inputFlag').val();
                        var task = $('#task-title').text();
                        $.ajax({
                            type: 'POST',
                            data: {task: task, flag: flag},
                            success: function (data) {
                                if (data == 'success') {
                                    $('.modal-footer').empty().append('<p class="text-center" style="color: #004d00;">Поздравляем! Вам зачислено ' + points + ' очков </p>');
                                    window.location.reload();
                                }
                                else {
                                    $('.modal-footer').append('<p class="text-center" style="color: #ab2020;">Неправильный флаг</p>');
                                    $('.modal-footer p').fadeOut(2500);
                                }
                            }
                        });
                    });
                }
                else {
                    $('.modal-footer').append('<p class="text-center" style="color: #004d00;">Вы уже решили задание</p>');
                }
            }
        });

    });
});