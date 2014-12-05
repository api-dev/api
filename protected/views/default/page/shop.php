<h1>API магазин</h1>
<p>Для того, чтобы начать работать с магазином, требуется открыть http соединение по адресу <b>api.lbr.ru</b></p>
<p class="list">Список разделов:</p>
<div class="api-tr-list">
    <!--a href="#addtr">Добавление/редактирование производителя техники</a-->
    <a href="#addtr">Добавление/редактирование запчастей</a>
    <a href="#addgroup">Добавление/редактирование группы запчастей</a>
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
                    <li><span class="param">product_group_id</span> <span class="type">(int)</span> <span class="info">ID группы в 1С</span> </li>
                    <!--li><span class="param">price_id</span> <span class="type">(int)</span> <span class="info">ID группы цен в 1С</span> </li-->
                    <li><span class="param">catalog_number</span> <span class="type">(string)</span> <span class="info">Каталожный номер</span> </li>
                    <li><span class="param">product_maker_id</span> <span class="type">(int)</span> <span class="info">ID производителя запчастей в 1С</span> </li>
                    <li><span class="param">count</span> <span class="type">(int)</span> <span class="info">Количество в наличии</span> </li>
                    <li><span class="param">min_quantity</span> <span class="type">(int)</span> <span class="info">Минимальное количество для заказа</span> </li>
                    <li><span class="param">liquidity</span> <span class="type">(string)</span> <span class="info">Ликвидность</span> </li>
                    <li><span class="param">additional_info</span> <span class="type">(string)</span> <span class="info">Дополнительная информация</span> </li>
                    <li><span class="param">image_name</span> <span class="type">(string)</span> <span class="info">Имя изображения запчасти в 1C</span> </li>
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
    <!--h4><a name="addtr">Добавление/редактирование производителя запчастей</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>prodmaker.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=prodmaker:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(integer)</span> <span class="info">Идентефикатор производителя в системе учета. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название производителя запчастей</span> </li>
                    <li><span class="param">description</span> <span class="type">(string)</span> <span class="info">Описание производителя запчастей</span> </li>
                    <li><span class="param">country</span> <span class="type">(string)</span> <span class="info">Страна производителя</span> </li>
                </ul>
            </li>
        </ul>
    </div-->
    <h4><a name="addgroup">Добавление/редактирование группы запчастей</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>group.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=group:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(integer)</span> <span class="info">Идентефикатор группы в системе учета. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название группы</span> </li>
                    <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Дочерние группы:
                            <ul class="table">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">external_id</span> <span class="type">(integer)</span> <span class="info">Идентефикатор группы в системе учета. Уникальный. Обязательный</span> </li>
                                <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название группы</span> </li>
                                <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Дочерние группы ...</span></li>
                            </ul>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет/редактирует двух производителей запчастей:</p>
        <pre style='font-size: 11px;'>
            action = 'group'
            data[1][external_id] = '3333333'
            data[1][name] = 'Метизы'
            data[1][inner][1][external_id] = '111111'
            data[1][inner][1][name] = 'Болты'
            data[1][inner][2][external_id] = '222222'
            data[1][inner][2][name] = 'Гайки'
        </pre>
    </div>
</div>