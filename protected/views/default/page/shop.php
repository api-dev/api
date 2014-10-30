<h1>API магазин</h1>
<p>Для того, чтобы начать работать с магазином, требуется открыть http соединение по адресу <b>api.lbr.ru</b></p>
<p class="list">Список разделов:</p>
<div class="api-tr-list">
    <!--a href="#addtr">Добавление/редактирование производителя техники</a-->
    <a href="#addtr">Добавление/редактирование запчастей</a>
</div>
<div class="item">
    <h4><a name="addtr">Добавление/редактирование запчастей</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>sparepart.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=sparepart:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название запчасти</span> </li>
                    <li><span class="param">catalog_number</span> <span class="type">(string)</span> <span class="info">Каталожный номер</span> </li>
                    <li><span class="param">+ картинка</span><span class="info" style="margin-left: 100px;">Пакет данных</span></li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет/редактирует двух производителей техники:</p>
        <pre style='font-size: 11px;'>
            action = 'sparepart'
            data[1][external_id] = 'MNS0032184'
            data[1][name] = 'Датчик весовой 375WS'
            data[1][catalog_number] = '375WS'
            ...
            data[2][external_id] = 'MNS0041059'
            data[2][name] = 'Индикатор GT-460'
            data[2][catalog_number] = 'GT-460'
        </pre>
    </div>
    <!--h4><a name="addtr">Добавление/редактирование производителя техники</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>equipmentmaker.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=equipmentmaker:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(integer)</span> <span class="info">Идентефикатор перевозки в системе учета. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название производителя техники</span> </li>
                    <li><span class="param">description</span> <span class="type">(string)</span> <span class="info">Описание производителя техники</span> </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет/редактирует двух производителей техники:</p>
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
    </div-->
</div>