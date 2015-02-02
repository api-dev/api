<h1>API магазин</h1>
<p>Для того, чтобы начать работать с магазином, требуется открыть http соединение по адресу <b>api.lbr.ru</b></p>
<p class="list">Список разделов:</p>
<div class="api-tr-list">
    <a href="#addproductmaker">Добавление/редактирование производителя запчастей</a>
    <a href="#addequipmentmaker">Добавление/редактирование производителя техники</a>
    <a href="#addcategory">Добавление/редактирование категорий</a>
    <a href="#addmodelline">Добавление/редактирование модельных рядов и моделей</a>
    <a href="#addgroup">Добавление/редактирование группы запчастей</a>
    <a href="#addtr">Добавление/редактирование запчастей</a>
    <a href="#addmodelproduct">Добавление/редактирование отношения товаров (запчастей) к модельным рядам</a>
    <a href="#addrelatedproduct">Добавление/редактирование сопутствующих товаров</a>
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
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета 1С. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название запчасти</span> </li>
                    <li><span class="param">product_group</span> <span class="type">(string)</span> <span class="info">ID группы в 1С, которой принадлежит запчасть</span> </li>
                    <!--li><span class="param">price_id</span> <span class="type">(int)</span> <span class="info">ID группы цен в 1С</span> </li-->
                    <li><span class="param">catalog_number</span> <span class="type">(string)</span> <span class="info">Каталожный номер</span> </li>
                    <li><span class="param">product_maker</span> <span class="type">(string)</span> <span class="info">ID производителя в 1С, которой принадлежит запчасть</span> </li>
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
        <p>Пример добавляет/редактирует две запчасти:</p>
        <pre style='font-size: 11px;'>
            action = 'sparepart'
            data[0][external_id] = '1111111111'
            data[0][name] = 'Датчик весовой 375WS'
            data[0][catalog_number] = '375WS'
            ...
            data[1][external_id] = '222222222'
            data[1][name] = 'Индикатор GT-460'
            data[1][catalog_number] = 'GT-460'
        </pre>
    </div>
    <h4><a name="addproductmaker">Добавление/редактирование производителя запчастей</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>productmaker.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=productmaker:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор производителя в системе учета 1С. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название производителя запчастей</span> </li>
                    <li><span class="param">description</span> <span class="type">(string)</span> <span class="info">Описание производителя запчастей</span> </li>
                    <!--li><span class="param">published</span> <span class="type">(string)</span><span class="info">Публиковать</span></li-->
                    <li><span class="param">country</span> <span class="type">(string)</span> <span class="info">Страна производителя</span></li>
                    <li><span class="param">image_name</span> <span class="type">(string)</span> <span class="info">Название картинки в системе учета 1С</span></li>
                    <li><span class="param">+ картинка</span><span class="info" style="margin-left: 100px;">Пакет данных</span></li>
                </ul>
            </li>
        </ul>
    </div>
    <h4><a name="addequipmentmaker">Добавление/редактирование производителя техники</a></h4>
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
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор производителя в системе учета 1С. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название производителя техники</span> </li>
                    <li><span class="param">description</span> <span class="type">(string)</span> <span class="info">Описание производителя техники</span> </li>
                    <!--li><span class="param">published</span> <span class="type">(string)</span><span class="info">Публиковать</span></li-->
                    <li><span class="param">country</span> <span class="type">(string)</span> <span class="info">Страна производителя</span></li>
                    <li><span class="param">image_name</span> <span class="type">(string)</span> <span class="info">Название картинки в системе учета 1С</span></li>
                    <li><span class="param">+ картинка</span><span class="info" style="margin-left: 100px;">Пакет данных</span></li>
                </ul>
            </li>
        </ul>
    </div>
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
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета 1С. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название группы</span> </li>
                    <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Дочерние группы:
                            <ul class="table-inner">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета 1С. Уникальный. Обязательный</span> </li>
                                <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название группы</span> </li>
                                <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Дочерние группы ...</span></li>
                            </ul>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет/редактирует группы:</p>
        <pre style='font-size: 11px;'>
            action = 'group'
            data[0][external_id] = '111111111'
            data[0][name] = 'Метизы'
            data[0][inner][0][external_id] = '2222222222'
            data[0][inner][0][name] = 'Болты'
            data[0][inner][1][external_id] = '3333333333'
            data[0][inner][1][name] = 'Гайки'
        </pre>
    </div>
    <h4><a name="addmodelline">Добавление/редактирование модельных рядов и моделей</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>modelline.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=modelline:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета 1С. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название модельного ряда</span> </li>
                    <li><span class="param">category</span> <span class="type">(string)</span> <span class="info">ID категории в 1С, которой принадлежит модельный ряд</span> </li>
                    <li><span class="param">published</span> <span class="type">(int)</span> <span class="info">Отображать модельный ряд пользователям (1) или нет (0)</span> </li>
                    <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Дочерние модели:
                            <ul class="table-inner">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета. Уникальный. Обязательный</span> </li>
                                <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название модели</span> </li>
                                <li><span class="param">category</span> <span class="type">(string)</span> <span class="info">ID категории в 1С, которой принадлежит модель</span> </li>
                                <li><span class="param">published</span> <span class="type">(int)</span> <span class="info">Отображать модель пользователям (1) или нет (0)</span> </li>
                                <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Дочерние модели ...</span></li>
                            </ul>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет/редактирует модельный ряд и модели:</p>
        <pre style='font-size: 11px;'>
            action = 'modelline'
            data[0][external_id] = '3333333'
            data[0][name] = '2N Сеялки'
            data[0][category_id] = '9999999999'
            data[0][inner][0][external_id] = '111111'
            data[0][inner][0][name] = '2N-2410'
            data[0][inner][0][category_id] = '8888888888'
            data[0][inner][1][external_id] = '222222'
            data[0][inner][1][name] = '2N-3010'
            data[0][inner][1][category_id] = '7777777777'
        </pre>
    </div>
    <h4><a name="addcategory">Добавление/редактирование категорий</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>category.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=category:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор в системе учета 1С. Уникальный. Обязательный</span> </li>
                    <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название категории</span> </li>
                    <li><span class="param">published</span> <span class="type">(int)</span> <span class="info">Отображать категорию пользователям (1) или нет (0)</span> </li>
                    <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Дочерние категории:
                            <ul class="table-inner">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">external_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор гв системе учета. Уникальный. Обязательный</span> </li>
                                <li><span class="param">name</span> <span class="type">(string)</span> <span class="info">Название категории</span> </li>
                                <li><span class="param">published</span> <span class="type">(int)</span> <span class="info">Отображать категорию пользователям (1) или нет (0)</span> </li>
                                <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Дочерние категории ...</span></li>
                            </ul>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет/редактирует категории:</p>
        <pre style='font-size: 11px;'>
            action = 'category'
            data[0][external_id] = '999999999'
            data[0][name] = 'Почвообработка и посев'
            data[0][inner][0][external_id] = '8888888888'
            data[0][inner][0][name] = 'Бороны дисковые'
            data[0][inner][1][external_id] = '7777777777'
            data[0][inner][1][name] = 'Бороны пружинные'
        </pre>
    </div>
    <h4><a name="addmodelproduct">Добавление/редактирование отношения товаров (запчастей) к модельным рядам</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>modelproduct.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=modelproduct:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">model_line</span> <span class="type">(string)</span> <span class="info">Идентефикатор модели в системе учета 1С. Уникальный. Обязательный</span></li>
                    <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Запчасти, относящиеся к данному модельному ряду:
                            <ul class="table-inner">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">product_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор продукта (запчасти) в системе учета 1С. Уникальный. Обязательный</span> </li>
                            </ul>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет два товара (запчасти) в модельный ряд:</p>
        <pre style='font-size: 11px;'>
            action = 'modelproduct'
            data[0][model_line] = '3333333'
            data[0][inner][0][product_id] = '111111'
            data[0][inner][1][product_id] = '222222'
        </pre>
    </div>
    <h4><a name="addrelatedproduct">Добавление/редактирование сопутствующих товаров</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>relatedproduct.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=relatedproduct:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">product_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор продукта (запчасти) в системе учета 1С. Уникальный. Обязательный</span></li>
                    <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Сопутствующие товары, относящиеся к указанной запчасти:
                            <ul class="table-inner">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">related_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор продукта (запчасти) в системе учета 1С. Уникальный. Обязательный</span> </li>
                            </ul>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет два сопутствующих товара:</p>
        <pre style='font-size: 11px;'>
            action = 'relatedproduct'
            data[0][product_id] = '3333333'
            data[0][inner][0][related_id] = '111111'
            data[0][inner][1][related_id] = '222222'
        </pre>
    </div>
    <h4><a name="addrelatedproduct">Добавление/редактирование аналогов</a></h4>
    <div class="text">
        <p><span class="param">URL</span> : api.lbr.ru/shop?m=set</p>
        <p>Параметры:</p>
        <ul>
            <li><span class="param">action</span> - тип передаваемых данных. Принимаемые: <b>analogproduct.</b></li>
            <li><span class="param">data</span> - массив с данными.</li>
            <li><br>Принимаемые параметры <span class="param">data</span> при <span class="param">action=analogproduct:</span> </li>
            <li>
                <ul class="table">
                    <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                    <li><span class="param">product_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор продукта (запчасти) в системе учета 1С. Уникальный. Обязательный</span></li>
                    <li><span class="param">inner</span> <span class="type">(array)</span> <span class="info">Сопутствующие товары, относящиеся к указанной запчасти:
                            <ul class="table-inner">
                                <li><span class="param">Параметр</span> <span class="type"><b>Тип</b></span> <span class="info"><b>Описание</b></span> </li>
                                <li><span class="param">analog_id</span> <span class="type">(string)</span> <span class="info">Идентефикатор продукта (запчасти) в системе учета 1С. Уникальный. Обязательный</span> </li>
                            </ul>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="h2">Примеры:</div>
        <p>Пример добавляет два сопутствующих товара:</p>
        <pre style='font-size: 11px;'>
            action = 'analogproduct'
            data[0][product_id] = '3333333'
            data[0][inner][0][analog_id] = '111111'
            data[0][inner][1][analog_id] = '222222'
        </pre>
    </div>
</div>