<h1>КП API</h1>
<p>Для того чтобы начать работать с пользователями, требуется открыть http соединение по адресу <b>api.lbr.ru</b></p>
<div class="item">
    <h4>КП по запасным частям и <i>технике(временно не функционирует)</i></h4>
    <div class="text">
        <p><b>URL:</b> api.lbr.ru/?r=kp&m=set</p>
        <p>Параметры:
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>spares</b> - Запчасти; <i><b>machine</b> - Техника(в разработке)</i></li>
            <li><span class="param">template</span> - шаблон. Принимаемые: <b>email</b> - письмо на электронную почту, <b>print</b> - печатный шаблон(возвращает ссылку на документ) </li>
            <li><span class="param">header</span> - Шапка. Текст либо число. 0 - скрыть шапку.</li>
            <li><span class="param">client</span> - Клиент. ФИО.</li>
            <li><span class="param">login</span> - Логин сзязанного лица(любой человек, существующий в базе <a href="http://auth.lbr.ru">Центра авторизации</a>)</li>
            <li><span class="param">f_id</span> - Филиал (Код из трех символов)</li>
            <li><span class="param">data</span> - массив с данными. Может быть множественным массивом.</li>
            <li><br>Принимаемые параметры массива <b>data</b> для <b>action=spares</b></li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">title</span> <span class="type">(string)</span> <span class="info">Название таблицы</span> </li>
                    <li><span class="param">table</span> <span class="type">(array)</span> <span class="info">Массив со значениями таблицы</span> </li>
                </ul>
            </li>
        </ul>
        <p>
<p style="padding: 10px;">Пример генерирует таблицу вида:
<table class="parent" style="border-collapse: collapse; margin-left: 10px; margin-bottom: 10px;" border="1" cellspacing="0" cellpadding="0" ><thead><tr><td>№</td><td>Наименование</td><td>Количество</td><td>Цена</td><td>Сумма</td></tr></thead><tbody><tr><td>1</td><td>Запчасть под номер 1</td><td>345</td><td>34</td><td>11730</td></tr><tr><td>2</td><td>Вторая ЗЧ</td><td><table class="children" width="100%" cellspacing="0" cellpadding="0"><tbody><tr><td style="border-bottom: 1px solid black;">345</td></tr><tr><td>565</td></tr></tbody></table></td><td><table class="children" width="100%" cellspacing="0" cellpadding="0"><tbody><tr><td style="border-bottom: 1px solid black;">35</td></tr><tr><td>37</td></tr></tbody></table></td><td>32980</td></tr></tbody></table>
<pre style='font-size: 11px;'>
    action = 'spares'
    data[1][table][head][0][0] = '№';
    data[1][table][head][0][1] = 'Наименование';
    data[1][table][head][0][2] = 'Количество';
    data[1][table][head][0][3] = 'Цена';
    data[1][table][head][0][4] = 'Сумма';

    data[1][table][body][0][0] = '1';
    data[1][table][body][0][1] = 'Запчасть под номер 1';
    data[1][table][body][0][2] = '345';
    data[1][table][body][0][3] = '34';
    data[1][table][body][0][4] = '11730';
    
    data[1][table][body][1][0] = '2';
    data[1][table][body][1][1] = 'Вторая ЗЧ';
    data[1][table][body][1][2][body][0][0] = '345';
    data[1][table][body][1][2][body][1][0] = '565';
    data[1][table][body][1][3][body][0][0] = '35';
    data[1][table][body][1][3][body][1][0] = '37';
    data[1][table][body][1][4] = '32980';
</pre>
</p>
    </p>
    </div>
</div>