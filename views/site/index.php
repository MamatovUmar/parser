<?php

/* @var $this yii\web\View */

$this->title = 'Проверка ИИН';
?>
    <div class="container">

        <div class="jumbotron">
            <h1>Добро пожаловать</h1>
            <p>Сведения об отсутствии (наличии) задолженности, учет по которым ведется в органах государственных
                доходов</p>
        </div>

        <!--    Форма для отправки ИИН     -->
        <div class="input-group">
            <input type="text" id="iin" class="form-control" placeholder="Введите ИНН номер">
            <span class="input-group-btn">
                <button class="btn btn-primary" id="go" type="button">Go!</button>
            </span>
        </div>
        <!--    Форма для отправки ИИН  end   -->

        <!--    Вывод ошибок    -->
        <div class="alert alert-danger alert-dismissible mt-50" style="display: none" id="error" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <span id="error-message"></span>
        </div>
        <!--    Вывод ошибок  end  -->

        <!--    Вывод сообщении    -->
        <div class="alert alert-success alert-dismissible mt-50" style="display: none" id="success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <span id="success-message"></span>
        </div>
        <!--    Вывод сообщении  end  -->

        <!--     Loader     -->
        <div class="text-center mt-50" id="loader" style="display: none">
            <img src="/web/image/loader.gif" width="200px">
        </div>
        <!--     Loader end    -->

        <!--    Полученные резултаты      -->
        <div class="panel panel-info mt-50" id="resultTable" style="display: none">
            <div class="panel-heading">
                <div class="panel-title">
                    Полученные резултаты
                    <button class="btn btn-primary pull-right save-btn" id="save-data" type="button">
                        <i class="glyphicon glyphicon-floppy-disk"></i>
                    </button>
                </div>

            </div>
            <div class="panel-body">
                <table class="table table-hover table-bordered">
                    <tbody>
                    <tr>
                        <td width="50%">Наименование налогоплательщика</td>
                        <td id="nameRu"></td>
                    </tr>
                    <tr>
                        <td>ИИН/БИН налогоплательщика</td>
                        <td id="iinBin"></td>
                    </tr>
                    <tr>
                        <td>Всего задолженности (тенге)</td>
                        <td id="totalArrear"></td>
                    </tr>
                    <tr>
                        <td>Итого задолженности в бюджет</td>
                        <td id="totalTaxArrear"></td>
                    </tr>
                    <tr>
                        <td>Задолженность по обязательным пенсионным взносам, обязательным профессиональным пенсионным
                            взносам
                        </td>
                        <td id="pensionContributionArrear"></td>
                    </tr>
                    <tr>
                        <td>Задолженность по отчислениям и (или) взносам на обязательное социальное медицинское
                            страхование
                        </td>
                        <td id="socialHealthInsuranceArrear"></td>
                    </tr>
                    <tr>
                        <td>Задолженность по социальным отчислениям</td>
                        <td id="socialContributionArrear"></td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <!--    Полученные резултаты  end     -->


    </div>


<?php

$csrf = \yii\helpers\Json::encode(Yii::$app->request->getCsrfToken());

$js = <<<JS

    let info = null;

    // Получить информации по ИИН
    $('#go').click(function() {
        let btn = $(this);
        let iin = $('#iin').val();
        
        if (!iin){
            return false;
        }
        
        let check = /^[\d+]{10,12}$/.test(iin);
        if (check){
            btn.attr('disabled', 'disabled');
            $('#loader').show();
             $.ajax({
               url:  '/site/info?iin=' + iin,
               type: 'get',
               success: function(data){
                   if (data.status === 'success'){
                       info = data.data;
                       setData(data.data);
                       $('#resultTable').show();
                       $('#iin').val('');
                   } else{
                       $('#error').show();
                       $('#error-message').html(data.message);
                   }
                   $('#loader').hide();
                   btn.removeAttr('disabled');                   
               },
               error: function(e) {
                    $('#error').show();
                    $('#error-message').html('Ошибка');
               }
            });
        } else{
            return false;
        }
        
        
    });
    
    // Заполняем таблицу полученными данными
    function setData(data){
        for (item in data){
            $('#' + item).html(data[item]);
        }         
    }
    
    // Сохраняем полученные данные
    $('#save-data').click(function() {
        console.log(123);
        if(info === null){
            return false;
        }
        
        $.ajax({
           url:  '/site/save-data',
           type: 'post',
           data: {info, '_csrf': $csrf},
           success: function(res){
               if (res.status === 'success'){
                   $('#success').show();
                   $('#success-message').html(res.message);
               } else{
                   $('#error').show();
                   $('#error-message').html(res.message);
               }
                                
           },
           error: function(e) {
                $('#error').show();
                $('#error-message').html('Ошибка');
           }
        });
    })

JS;

$this->registerJs($js);


?>