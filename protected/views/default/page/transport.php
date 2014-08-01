<h1>API перевозок</h1>
<p>Для того чтобы начать работать с пользователями, требуется открыть http соединение по адресу <b>api.lbr.ru</b></p>
<p class="list">Список разделов:</p>
<div class="api-tr-list">
    <a href="#addtr">Добавление/редактирование перевозки/перевозчика</a>
    <a href="#gettr">Получение данных о перевозке/перевозчике</a>
    <a href="#deltr">Удаление перевозки/перевозчика</a>
    <a href="#getstat">Статистика - получение данных о всех архивных перевозках</a>
</div>
<div class="item">
    <h4><a name="addtr">Добавление/редактирование перевозки/перевозчика</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/tr?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>transport, user.</b></li>
            <li><span class="param">data</span> - массив с данными. Может быть множественным массивом с несколькими перевозками/перевозчиками.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=transport:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">t_id</span> <span class="type">(integer)</span> <span class="info">Идентефикатор перевозки в системе учета. Уникальный. Обязательный</span> </li>
                    <li><span class="param">type</span> <span class="type">(integer)</span> <span class="info">Тип перевозки. 0 - международная, 1 - региональная</span> </li>
                    <li><span class="param">user_id</span> <span class="type">(mixed)</span> <span class="info">Идентефикатор пользователя в системе учета, создавшего перевозку</span> </li>
                    <li><span class="param">start_rate</span> <span class="type">(integer)</span> <span class="info">Стартовая сумма ставки</span> </li>
                    <li><span class="param">currency</span> <span class="type">(integer)</span> <span class="info">Валюта. 0 - рубли(руб), 1 - доллары($), 2 - евро(€)</span> </li>
                    <li><span class="param">location_from</span> <span class="type">(string)</span> <span class="info">Место загрузки</span> </li>
                    <li><span class="param">location_to</span> <span class="type">(string)</span> <span class="info">Место разгрузки</span> </li>
                    <li><span class="param">date_close</span> <span class="type">(date)</span> <span class="info">Дата и время закрытия заявки. Формат - YYYY-MM-DD H:i:s</span> </li>
                    <li><span class="param">date_from</span> <span class="type">(date)</span> <span class="info">Дата загрузки. Формат - YYYY-MM-DD</span> </li>
                    <li><span class="param">date_to</span> <span class="type">(date)</span> <span class="info">Дата разгрузки. Формат - YYYY-MM-DD</span> </li>
                    <li><span class="param">auto_info</span> <span class="type">(string)</span> <span class="info">Информация об автомобиле</span> </li>
                    <li><span class="param">description</span> <span class="type">(string)</span> <span class="info">Описание</span> </li>
                    <li><span class="param">points</span> <span class="type">(array)</span> <span class="info">Массив с промежуточными точками:<ul class="table">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">point</span> <span class="type">(string)</span> <span class="info">Название/место</span> </li>
                                <li><span class="param">date</span> <span class="type">(date)</span> <span class="info">Дата. Формат - YYYY-MM-DD</span>
                        </ul></span>
                    </li>
                </ul>
            </li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=user:</span></li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">inn</span> <span class="type">(integer)</span> <span class="info">ИНН/УНП. Уникальный. Обязательный</span> </li>
                    <li><span class="param">company</span> <span class="type">(string)</span> <span class="info">Название компании без кавычек</span> </li>
                    <li><span class="param">country</span> <span class="type">(string)</span> <span class="info">Страна</span> </li>
                    <li><span class="param">region</span> <span class="type">(string)</span> <span class="info">Область</span> </li>
                    <li><span class="param">city</span> <span class="type">(string)</span> <span class="info">Город</span> </li>
                    <li><span class="param">district</span> <span class="type">(string)</span> <span class="info">Район</span> </li>
                    <li><span class="param">email</span> <span class="type">(mixed)</span> <span class="info">E-mail адрес. Уникальный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Имя контактного лица</span> </li>
                    <li><span class="param">surname</span> <span class="type">(string)</span> <span class="info">Фамилия контактного лица</span> </li>
                    <li><span class="param">secondname</span> <span class="type">(string)</span> <span class="info">Отчество контактного лица</span> </li>
                    <li><span class="param">phone</span> <span class="type">(integer)</span> <span class="info">Номер телефона</span> </li>
                    <li><span class="param">phone2</span> <span class="type">(integer)</span> <span class="info">Дополнительный номер телефона</span> </li>
                    <li><span class="param">type</span> <span class="type">(integer)</span> <span class="info">Тип. 0 - общий, 1 - региональный, 2 - международный</span> </li>
                    <li><span class="param">persons</span> <span class="type">(array)</span> <span class="info">Дополнительные контактные лица:<ul class="table">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">email</span> <span class="type">(mixed)</span> <span class="info">E-mail адрес. Уникальный. Обязательный</span> </li>
                                <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Имя контактного лица</span> </li>
                                <li><span class="param">surname</span> <span class="type">(string)</span> <span class="info">Фамилия контактного лица</span> </li>
                                <li><span class="param">secondname</span> <span class="type">(string)</span> <span class="info">Отчество контактного лица</span> </li>
                                <li><span class="param">phone</span> <span class="type">(integer)</span> <span class="info">Номер телефона</span> </li>
                                <li><span class="param">phone2</span> <span class="type">(integer)</span> <span class="info">Дополнительный номер телефона</span> </li>
                                <li><span class="param">type</span> <span class="type">(integer)</span> <span class="info">Тип. 0 - общий, 1 - региональный, 2 - международный</span> </li>
                        </ul></span> </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет/редактирует две перевозки:</p>
        <pre style='font-size: 11px;'>
            action = 'transport'
            data[1][t_id] = '1N34'
            data[1][type] = '0'
            data[1][user_id] = '82324'
            data[1][location_from] = 'Ставрополь'
            data[1][points][1][point] = 'Уфа'
            data[1][points][1][date] = '2014-03-14'
            data[1][points][2][point] = 'Москва'
            data[1][points][2][date] = '2014-03-16'
            ...
            data[2][t_id] = '2U52'
            data[2][type] = '1'
            data[2][user_id] = '23424'
        </pre>
        Пример добавляет/редактирует одну перезовку:
        <pre style='font-size: 11px;'>
            action = 'transport'
            data[t_id] = '1N34'
            data[type] = '0'
            data[user_id] = '82324'
        </pre>Пример добавляет/редактирует два перевозчика:
        <pre style='font-size: 11px;'>
            action = 'user'
            data[1][inn] = '345678999888'
            data[1][company] = 'ООО ЛБР-Агромаркет'
            data[1][country] = 'РФ'
            ...
            data[2][inn] = '234948756732'
            data[2][company] = 'ИП Жорик и Борик'
            data[2][country] = 'РФ'
            data[2][persons][0][email] = 'email@mail.com'
            data[2][persons][0][name] = 'Имя_контактного_лица'
            data[2][persons][0][surname] = 'Фамилия_контактного_лица'
        </pre>Пример добавляет/редактирует одного перевозчика:
        <pre style='font-size: 11px;'>
            action = 'user'
            data[inn] = '345678999888'
            data[company] = 'ООО ЛБР-Агромаркет'
            data[country] = 'Беларусь'
        </pre>
    </div>
</div>
<div class="item">
    <h4><a name="gettr">Получение данных о перевозке/перевозчике</a></h4>
    <div class="text">
        <p><b>URL:</b> api.lbr.ru/tr?m=get</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>transport, user.</b></li>
            <li><span class="param">data</span> - массив с идентефикаторами перевозок/перевозчиков.</li>
        </ul>
        <p>
            <div class="h2">Примеры:</div>
        Пример вернет xml-файл с информацией о двух перевозках
        <pre style='font-size: 11px;'>
            action = 'transport'
            data[1][t_id] = 'UPR-009041'
            data[2][t_id] = '2U52'
        </pre>
        <br/>Возвращаемый xml:
        <code>
            <pre style='font-size:12px;'>
            &lt;transport t_id=&quot;UPR-009041&quot;&gt;
                &lt;status&gt;0&lt;/status&gt;
                &lt;datepublished&gt;2014-04-01 10:48:03&lt;/datepublished&gt;
                &lt;dateclose&gt;2014-04-01 15:00:00&lt;/dateclose&gt;
                &lt;editstatus&gt;Перевозка участвует в торгах. Изменение невозможно.&lt;/editstatus&gt;
                &lt;startprice&gt;1800&lt;/startprice&gt;
                &lt;ratescount&gt;9&lt;/ratescount&gt;
                &lt;memberscount&gt;6&lt;/memberscount&gt;
                &lt;win&gt;
                    &lt;inn&gt;300004425&lt;/inn&gt;
                    &lt;nds&gt;0&lt;/nds&gt;
                    &lt;price&gt;1600.0&lt;/price&gt;
                    &lt;currency&gt;2&lt;/currency&gt;
                    &lt;date&gt;2014-04-01 13:46:25&lt;/date&gt;
                &lt;/win&gt;
            &lt;/transport&gt;
            &lt;transport t_id=&quot;2U52&quot;&gt;
                &lt;status&gt;1&lt;/status&gt;
                &lt;datepublished&gt;2014-04-01 10:48:03&lt;/datepublished&gt;
                &lt;dateclose&gt;2014-04-15 15:00:00&lt;/dateclose&gt;
                &lt;editstatus&gt;&lt;/editstatus&gt;
                &lt;startprice&gt;1200&lt;/startprice&gt;
                &lt;ratescount&gt;0&lt;/ratescount&gt;
                &lt;memberscount&gt;0&lt;/memberscount&gt;
                &lt;win&gt;
                    &lt;inn&gt;&lt;/inn&gt;
                    &lt;nds&gt;&lt;/nds&gt;
                    &lt;price&gt;&lt;/price&gt;
                    &lt;currency&gt;2&lt;/currency&gt;
                    &lt;date&gt;&lt;/date&gt;
                &lt;/win&gt;
            &lt;/transport&gt;
            </pre>        
        </code>
    </div>
</div>
<div class="item">
    <h4><a name="deltr">Удаление перевозки/перевозчика</a></h4>
    <div class="text">
        <p><b>URL:</b> api.lbr.ru/tr?m=del</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>transport, user.</b></li>
            <li><span class="param">data</span> - массив с данными. Может быть множественным массивом с несколькими перевозками/перевозчиками.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=transport:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">t_id</span> <span class="type">(integer)</span> <span class="info">Идентефикатор перевозки в системе учета. Уникальный. Обязательный</span> </li>
                </ul>
            </li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=user:</span></li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">inn</span> <span class="type">(integer)</span> <span class="info">ИНН/УНП. Уникальный. Обязательный</span> </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример удаляет две перевозки
        <pre style='font-size: 11px;'>
            action = 'transport'
            data[1][t_id] = '1N34'
            data[2][t_id] = '2U52'
        </pre>
        Пример удаляет одну перезовку:
        <pre style='font-size: 11px;'>
            action = 'transport'
            data[t_id] = '1N34'
        </pre>Пример удаляет два перевозчика:
        <pre style='font-size: 11px;'>
            action = 'user'
            data[1][inn] = '345678999888'
            data[2][inn] = '234948756732'
        </pre>Пример удаляет одного перевозчика:
        <pre style='font-size: 11px;'>
            action = 'user'
            data[inn] = '345678999888'
        </pre>
    </div>
</div>
<div class="item">
    <h4><a name="getstat">Статистика - получение данных о всех архивных перевозках</a></h4>
    <div class="text">
        <p><b>URL:</b> api.lbr.ru/tr?m=get</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>statistics.</b></li>
        </ul>
        <div class="h2">Примеры:</div>
        Пример вернет xml-файл с информацией о всех архивных перевозках
        <pre style='font-size: 11px;'>
            action = 'statistics'
        </pre>
        <br/>Возвращаемый xml:
        <code>
            <pre style='font-size:12px;'>
            &lt;data count="2"&gt;
                &lt;transport t_id=&quot;UPR-009041&quot;&gt;
                    &lt;status&gt;0&lt;/status&gt;
                    &lt;datepublished&gt;2014-04-01 10:48:03&lt;/datepublished&gt;
                    &lt;dateclose&gt;2014-04-01 15:00:00&lt;/dateclose&gt;
                    &lt;startprice&gt;1800&lt;/startprice&gt;
                    &lt;ratescount&gt;9&lt;/ratescount&gt;
                    &lt;memberscount&gt;6&lt;/memberscount&gt;
                    &lt;win&gt;
                        &lt;inn&gt;300004425&lt;/inn&gt;
                        &lt;nds&gt;0&lt;/nds&gt;
                        &lt;price&gt;1600.0&lt;/price&gt;
                        &lt;currency&gt;2&lt;/currency&gt;
                        &lt;date&gt;2014-04-01 13:46:25&lt;/date&gt;
                    &lt;/win&gt;
                &lt;/transport&gt;
                &lt;transport t_id=&quot;2U52&quot;&gt;
                    &lt;status&gt;0&lt;/status&gt;
                    &lt;datepublished&gt;2014-04-01 10:48:03&lt;/datepublished&gt;
                    &lt;dateclose&gt;2014-04-15 15:00:00&lt;/dateclose&gt;
                    &lt;startprice&gt;1200&lt;/startprice&gt;
                    &lt;ratescount&gt;0&lt;/ratescount&gt;
                    &lt;memberscount&gt;0&lt;/memberscount&gt;
                    &lt;win&gt;
                        &lt;inn&gt;&lt;/inn&gt;
                        &lt;nds&gt;&lt;/nds&gt;
                        &lt;price&gt;&lt;/price&gt;
                        &lt;currency&gt;2&lt;/currency&gt;
                        &lt;date&gt;&lt;/date&gt;
                    &lt;/win&gt;
                &lt;/transport&gt;
            &lt;/data&gt;
            </pre>        
        </code>
    </div>
</div>